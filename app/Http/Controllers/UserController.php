<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function add(Request $request)
    {
        DB::table('radcheck')->insert([
            'username' => $request->username,
            'attribute' => 'Cleartext-Password',
            'op' => ':=',
            'value' => $request->password
        ]);

        DB::table('radcheck')->insert([
            'username' => $request->username,
            'attribute' => 'User-Profile',
            'op' => ':=',
            'value' => $request->profile
        ]);

        DB::table('radcheck')->insert([
            'username' => $request->username,
            'attribute' => 'Simultaneous-Use',
            'op' => ':=',
            'value' => '1'
        ]);

        DB::table('radcheck')->insert([
            'username' => $request->username,
            'attribute' => 'Expiration',
            'op' => ':=',
            'value' => date("d M Y H:i", strtotime($request->exp . " 00:00"))
        ]);

        DB::table('radcheck')->insert([
            'username' => $request->username,
            'attribute' => 'Called-Station-Id',
            'op' => '==',
            'value' => $request->servername
        ]);

        return redirect('/pppoe/user');
    }

    public function delete(Request $request)
    {
        DB::table('radcheck')->where('username', $request->name)->delete();

        return redirect('/pppoe/user');
    }

    public function update(Request $request)
    {
        DB::table('radcheck')->where('username', $request->oldname)->where('attribute', 'Cleartext-Password')->update([
            'value' => $request->password
        ]);

        DB::table('radcheck')->where('username', $request->oldname)->where('attribute', 'User-Profile')->update([
            'value' => $request->profile
        ]);

        DB::table('radcheck')->where('username', $request->oldname)->where('attribute', 'Called-Station-Id')->update([
            'value' => $request->servername
        ]);

        DB::table('radcheck')->where('username', $request->oldname)->where('attribute', 'Expiration')->update([
            'value' => date("d M Y H:i", strtotime($request->exp . " 00:00"))
        ]);

        DB::table('radcheck')->where('username', $request->oldname)->update([
            'username' => $request->username
        ]);

        return redirect('/pppoe/user');
    }
}
