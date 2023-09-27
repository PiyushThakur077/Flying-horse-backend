<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function status()
    {
        return $this->hasOne(Status::class);
    }

    public static function datatable()
    {
        return self::leftJoin('statuses','statuses.id','=','users.status_id')
            ->leftJoin('user_status_logs', function($join){
                $join->on('user_status_logs.status_id','=','statuses.id')
                    ->on('user_status_logs.user_id','=', 'users.id')
                ->whereNull('user_status_logs.end_at');
            })
            ->where('users.active',1)
            ->where('users.role','!=', 'admin')
            ->selectRaw(
                '
                    users.*,
                    statuses.status,
                    user_status_logs.started_at
                '
            );
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
