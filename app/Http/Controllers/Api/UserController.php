<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index( Request $request )
    {
        $page = $request->page ?? 1;
        $per_page = $request->per_page  ?? 10;

        $user =  User::datatable()->when( $per_page && $page, function($q) use($page,$per_page) {
            $q->limit( $per_page )->offset( ( $page-1 ) * $per_page );
        }) ->get();

        return $this->response( 'users list' , $user);
    }

    public function profile(){
        $user =  User::datatable()->where('users.id', $this->userId())->first();

        return $this->response( 'user Details' , $user);
    }

    public function updateStatus( Request $request )
    {
        $request->validate(['status_id' => 'required']);

        DB::beginTransaction();
        try {

            $user =  $this->user();

            if(  $user->status_id )
            {
                UserStatusLog::where([
                    'user_id' =>   $user->id,
                    'status_id' =>  $user->status_id,
                ])->whereNull('end_at')
                ->update(['end_at' => date('Y-m-d H:i:s')]);
            }
            $user->update(['status_id' => $request->status_id]);

            UserStatusLog::create([
                'user_id' =>   $user->id,
                'status_id' => $request->status_id,
                'date' => date('Y-m-d'),
                'started_at' => date('Y-m-d H:i:s')
            ]);
            DB::commit();
            return $this->response('Status updated successfully',  User::datatable()->where('users.id', $user->id)->first() );

        } catch ( \Exception $e ) {
            DB::rollBack();
            return $this->failedResponse('Something went wrong Error 500',['error' => $e->getMessage()]);
        }
        
    }


    public function stopTimer( Request $request )
    {
        $request->validate(['status_id' => 'required']);

        DB::beginTransaction();
        try {

            $user =  $this->user();

            $user->update(['status_id' => $request->status_id]);

            UserStatusLog::where([
                'user_id' =>   $user->id,
                'status_id' =>  $user->status_id,
                'date' => date('Y-m-d')
            ])->update(['end_at' => date('Y-m-d H:i:s')]);

            UserStatusLog::create([
                'user_id' =>   $user->id,
                'status_id' => $request->status_id,
                'date' => date('Y-m-d'),
                'started_at' => date('Y-m-d H:i:s')
            ]);

            DB::commit();
            return $this->response('Status timer stoped successfully',   User::datatable()->where('users.id', $user->id)->first());

        } catch ( \Exception $e ) {
            DB::rollBack();
            return $this->failedResponse('Something went wrong Error 500',['error' => $e->getMessage()]);
        }
        
    }

    public function search( Request $request )
    {
        $request->validate([
            'keyword' => 'required'
        ]);

        $page = $request->page ?? 1;
        $per_page = $request->per_page  ?? 10;
    

        $users = User::datatable()
                    ->where(function($q) use($request) {
                        $q->where('users.email', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('users.name', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('users.phone', 'LIKE', "%{$request->keyword}%")
                        ->orWhere('statuses.status', 'LIKE', "%{$request->keyword}%");
                    })
                   ->limit( $per_page )->offset( ( $page-1 ) * $per_page )
                     ->get();

        return $this->response('',[
            'page' =>  $page,
            'per_page' =>  $per_page,
            'result' =>   $users
        ]);     
    }
}
