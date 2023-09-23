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
                'actions' => function ($data) {
                    $csrf = csrf_field();
                    $editUrl = route('users.edit', $data->id);
                    $deleteUrl = route('users.destroy', $data->id);
    
                    return "<td>
                        <a href='$editUrl' class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i></a>&nbsp
                        <form method='post' id='deleteForm' action='$deleteUrl' style='display: inline'>
                            $csrf 
                            <input type='hidden' name='_method' value='DELETE'>
                            <button type='submit' data-form='deleteForm' class='btn btn-xs btn-danger delete-warning'>
                                <i class='glyphicon glyphicon-trash'></i>
                            </button>
                        </form>
                    </td>";
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


    public function destroy(Int $id)
    {
        $user = User::find($id);

        if( $user ) {
            $user->active = 0 ;
            $user->update();

            return back()->with('success', 'User Deleted Successfully');
        }
        return back()->with('error', 'User Not Found');
    }

    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->storeAs('avatars', $id . '.' . $avatar->getClientOriginalExtension(), 'public');
            $user->image = $avatarPath;
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User Updated successfully.');
    }


}
