<?php

namespace App\Http\Controllers;

use App\Models\NASModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // dashboard view
    public function dashboard()
    {
        return view('dashboard.dashboard', [
            'title' => 'Home - websitename.com'
        ]);
    }

    // router & server view
    public function router()
    {
        return view('dashboard.router', [
            'title' => 'Router & server - websitename.com',
            'routers' => NASModel::all()
        ]);
    }

    // Langganan
    public function profile()
    {
        $data = DB::table('radgroupreply')->get();
        $name = [];
        $profiles = [];

        foreach ($data as $x) {
            if (!in_array($x->groupname, $name)) {
                array_push($name, $x->groupname);
            }
        }

        foreach ($name as $x) {
            $y = [];
            array_push($y, $x);
            array_push($y, $data->where('attribute', 'Framed-Pool')->where('groupname', $x)->first()->value);
            array_push($y, $data->where('attribute', 'Mikrotik-Rate-Limit')->where('groupname', $x)->first()->value);

            array_push($profiles, $y);
        }

        return view('dashboard.profile', [
            'title' => 'Langganan - websitename.com',
            'profiles' => $profiles
        ]);
    }

    public function user()
    {
        $data = DB::table('radcheck')->get();
        $profiles = DB::table('radusergroup')->get();
        $username = [];
        $users = [];

        foreach ($data as $x) {
            if (!in_array($x->username, $username)) {
                array_push($username, $x->username);
            }
        }

        foreach ($username as $x) {
            $y = [];

            array_push($y, $x);
            array_push($y, $data->where('username', $x)->where('attribute', 'Cleartext-Password')->first()->value);
            array_push($y, $data->where('username', $x)->where('attribute', 'User-Profile')->first()->value);
            array_push($y, $data->where('username', $x)->where('attribute', 'Called-Station-Id')->first()->value);
            array_push($y, $data->where('username', $x)->where('attribute', 'Expiration')->first()->value);

            array_push($users, $y);
        }

        return view('dashboard.user', [
            'title' => 'User PPPOE',
            'users' => $users,
            'profiles' => $profiles
        ]);
    }
}
