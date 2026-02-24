<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->join("roles","roles.id","=","users.role_id")->select("users.*", "roles.name as role_name")->get();
        return view('admin.index', compact('users'));
    }
}
