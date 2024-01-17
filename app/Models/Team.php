<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'teams';

    protected $fillable = [
        'title',
        'user_ids',
    ];


    public function users() {
        return $this->belongsToMany( User::class, 'team_user', 'team_id','user_id');
    }

    public function teamUsers()
    {
        return $this->hasMany(TeamUser::class);
    }
}
