<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable as NotificationsNotifiable;

class Collaborators extends Model
{
    use HasFactory, NotificationsNotifiable, SoftDeletes;
    protected $table = 'collaborators';
    protected $fillable = [
        'name',
        'lastName',
        'address',
        'email',
        'phone',
        'location',
        'country',
        'ruc'
    ];
    protected $hidden = [];
    protected $cadsts = [];
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function setRucAttribute($value)
    {
        $this->attributes['ruc'] = bcrypt($value);
    }

}
