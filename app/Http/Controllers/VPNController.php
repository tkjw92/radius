<?php

namespace App\Http\Controllers;

use App\Models\NASModel;
use App\Models\VPNModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\error;

class VPNController extends Controller
{
    public function randomAddr()
    {
        $randomAddress = '172.16.100.' . rand(2, 254);
        while (VPNModel::where('address', $randomAddress)->count() >= 1) {
            $randomAddress = '172.16.100.' . rand(2, 254);
        }
        return $randomAddress;
    }

    public function updateCCD()
    {
        $data = VPNModel::get(['address', 'user_id']);
        foreach ($data as $x) {
            $ip = $x['address'];
            $name = $x['user_id'];
            exec("echo 'ifconfig-push $ip 255.255.255.0' > /etc/openvpn/ccd/$name");
        }
    }

    public function add(Request $request)
    {
        $addr = $this->randomAddr();

        VPNModel::insert([
            'user_id' => str_replace(' ', '_', $request->name),
            'user_pass' => uniqid(),
            'address' => $addr,
            'user_online' => '0',
            'user_enable' => '1'
        ]);

        $this->updateCCD();

        NASModel::insert([
            'nasname' => $addr,
            'shortname' => str_replace(' ', '_', $request->name),
            'secret' => $request->secret,
            'ports' => $request->coa
        ]);

        return redirect('/router');
    }

    public function delete(Request $request)
    {
        $data = NASModel::where('id', $request->id)->first();
        $active = DB::table('radacct')->where('acctstoptime', null)->where('nasipaddress', $data->nasname)->get();

        VPNModel::where('address', $data->nasname)->delete();
        $data->delete();

        if ($active->count() > 0) {
            foreach ($active as $x) {
                exec("echo user-name=$x->username | radclient -r 1 $x->nasipaddress disconnect $data->secret");
            }
        }

        exec("rm -f /etc/openvpn/ccd/$data->shortname");
        exec("sudo systemctl restart openvpn@server");

        return redirect('/router');
    }

    public function script($version, $id)
    {
        if ($version == 'v6' || $version == 'v7') {
            $data = NASModel::where('id', $id);
            if ($data->count() > 0) {
                $data = $data->first();
                $vpn = VPNModel::where('user_id', $data->shortname)->first();
                if ($version == 'v6') {
                    echo '/interface ovpn-client add name=AltaFocusRadius connect-to=103.193.147.153 port=443 protocol=tcp user=' . $vpn->user_id . ' password=' . $vpn->user_pass;
                    echo '<br>';
                    echo '/ip pool add name=expired-pool ranges=172.16.50.1-172.16.50.254';
                    echo '<br>';
                    echo '/radius incoming set port=' . $data->ports;
                } else {
                    echo '/interface/ovpn-client/add name=AltaFocusRadius connect-to=103.193.147.153 port=443 protocol=tcp user=' . $vpn->user_id . ' password=' . $vpn->user_pass;
                    echo '<br>';
                    echo '/ip/pool/add name=expired-pool ranges=172.16.50.1-172.16.50.254';
                    echo '<br>';
                    echo '/radius/incoming set port=' . $data->ports;
                }
            } else {
                return abort(404, 'NOT FOUND');
            }
        } else {
            return abort(404, 'NOT FOUND');
        }
    }

    public function disable(Request $request)
    {
        $data = NASModel::where('id', $request->id)->first();
        VPNModel::where('user_id', $data->shortname)->update([
            'user_enable' => '0'
        ]);

        $active = DB::table('radacct')->where('acctstoptime', null)->where('nasipaddress', $data->nasname)->get();

        if ($active->count() > 0) {
            foreach ($active as $x) {
                exec("echo user-name=$x->username | radclient -r 1 $x->nasipaddress disconnect $data->secret");
            }
        }
        exec("sudo systemctl restart openvpn@server");

        return redirect('/router');
    }
}
