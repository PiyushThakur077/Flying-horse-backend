<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status_id','date' ,'started_at', 'end_at'
    ];
}
