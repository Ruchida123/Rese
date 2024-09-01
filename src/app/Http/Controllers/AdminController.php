<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\AdminRequest;

class AdminController extends Controller
{
    public function index()
    {
        // ユーザーを取得
        $users = User::with('roles')->Paginate(5);

        // ページ表示
        return view('admin.index', compact('users'));
    }

    public function register_view()
    {
        // ページ表示
        return view('admin.register');
    }

    public function register(AdminRequest $request)
    {
        // ユーザーを作成
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        // 権限を付与
        $role = $request->role;
        if ($role == 1) {
            $user->assignRole('user');
        } elseif ($role == 2) {
            $user->assignRole('represent');
        }

        // ページ遷移
        return redirect('/admin');
    }
}
