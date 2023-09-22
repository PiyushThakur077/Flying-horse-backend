<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
