<?php

namespace App\Http\Controllers;

use App\Models\NASModel;
use App\Models\VPNModel;
use Illuminate\Http\Request;

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
            'secret' => $request->secret
        ]);

        return redirect('/router');
    }
}
