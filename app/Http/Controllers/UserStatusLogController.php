<?php

namespace App\Http\Controllers;

use App\Models\UserStatusLog;
use Illuminate\Http\Request;

class UserStatusLogController extends Controller
{
    public function index( Request $request )
    {
        $status_id = $request->status_id ?? null;
        $user_id = $request->user_id ?? null;
        $date = $request->date ?? null;
        $page = $request->page ?? 1;
        $per_page = $request->per_page  ?? 10;

        $logs = UserStatusLog::join('users', 'users.id','=','user_status_logs.user_id')
        ->join('statuses', 'statuses.id','=','user_status_logs.status_id')
        ->when($date, function($q) use($date) {
            $q->whereDate('user_status_logs.date',$date);
        })
        ->when($status_id, function($q) use($status_id) {
            $q->where('user_status_logs.status_id',$status_id);
        })
        ->when($user_id, function($q) use($user_id) {
            $q->where('user_status_logs.user_id',$user_id);
        })
        ->selectRaw(
            '
                user_status_logs.*,
                statuses.status,
                users.name as user_name,
                users.email as user_email,
                users.phone as user_phone
            '
        )
        ->limit( $per_page )->offset( ( $page-1 ) * $per_page )
        ->get();

        return $this->response( 'log details', [
            'page' => $page,
            'per_page' =>  $per_page,
            'result' => $logs
        ]);
    }

}
