<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.view');
    }


    public function datatable()
    {
        return datatable(User::datatable())
        ->addColumns([
            'actions' => function($data){
                $deleteUrl = route('users.delete',$data->id);
                return "<td><a title='View Status Logs'  href='#' class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i></a>&nbsp;
                <a href='#' class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i></a>&nbsp
                <a href=' $deleteUrl' class='btn btn-xs btn-danger delete-warning'>
                <i class='glyphicon glyphicon-trash'></i></a></td>";
            }
        ])->init();
    }
   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->image = $avatarPath;
        $user->password = Hash::make('password');
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User added successfully.');
    }
}
