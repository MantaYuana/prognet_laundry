<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller {
    public function index(Request $request) {
        $search = $request->input('search');
        $usersPaginated = User::all();

        return view('admin.users.index', [$usersPaginated]);
    }
}
