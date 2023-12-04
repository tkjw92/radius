<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    //

    public function add(Request $request)
    {
        // radgroupcheck
        DB::table('radgroupcheck')->insert([
            'groupname' => $request->name,
            'attribute' => 'Framed-Protocol',
            'op' => ':=',
            'value' => 'PPP'
        ]);

        // radgroupreply
        DB::table('radgroupreply')->insert([
            'groupname' => $request->name,
            'attribute' => 'Framed-Pool',
            'op' => '=',
            'value' => $request->pool
        ]);
        DB::table('radgroupreply')->insert([
            'groupname' => $request->name,
            'attribute' => 'Mikrotik-Rate-Limit',
            'op' => '=',
            'value' => $request->rate
        ]);

        // radusergroup
        DB::table('radusergroup')->insert([
            'username' => $request->name,
            'groupname' => $request->name,
            'priority' => '1'
        ]);

        return redirect('/pppoe/profile');
    }

    public function delete(Request $request)
    {
        DB::table('radgroupcheck')->where('groupname', $request->name)->delete();
        DB::table('radgroupreply')->where('groupname', $request->name)->delete();
        DB::table('radusergroup')->where('groupname', $request->name)->delete();

        DB::table('radcheck')->where('attribute', 'User-Profile')->where('value', $request->name)->update([
            'value' => 'disabled'
        ]);

        return redirect('/pppoe/profile');
    }

    public function update(Request $request)
    {
        DB::table('radgroupreply')->where('groupname', $request->oldname)->where('attribute', 'Framed-Pool')->update([
            'value' => $request->pool
        ]);

        DB::table('radgroupreply')->where('groupname', $request->oldname)->where('attribute', 'Mikrotik-Rate-Limit')->update([
            'value' => $request->rate
        ]);

        DB::table('radgroupreply')->where('groupname', $request->oldname)->where('attribute', 'Framed-Pool')->update([
            'value' => $request->pool
        ]);

        DB::table('radgroupreply')->where('groupname', $request->oldname)->update([
            'groupname' => $request->name
        ]);


        DB::table('radusergroup')->where('username', $request->oldname)->update([
            'username' => $request->name,
            'groupname' => $request->name
        ]);

        DB::table('radcheck')->where('attribute', 'User-Profile')->where('value', $request->oldname)->update([
            'value' => $request->name
        ]);

        return redirect('/pppoe/profile');
    }
}
