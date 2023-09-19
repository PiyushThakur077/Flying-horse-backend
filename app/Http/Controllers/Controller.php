<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,ApiResponse;


    public function user( $id = null )
    {
        if($id)
        {
            return User::select('id','name','email','contact_no')->find($id);
        }
        // Get user from api/web
        else if (request()->is('api/*'))
        {
           return auth()->guard('sanctum')->user();
        }
        else {
            return auth()->user();
        }
    }

    public function userId()
    {
        return $this->user()->id;
    }
}
