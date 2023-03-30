<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable as NotificationsNotifiable;

class Tasks extends Model
{
    use HasFactory, NotificationsNotifiable, SoftDeletes;
    protected $table = 'tasks';

    protected $fillable = [
        'description',
        'collaborator_id',
        'state',
        'priority',
        'startDate',
        'endDate',
        'notes',
    ];
    protected $hidden = [];
    protected $cadsts = [];
    protected $dates = [
        'startDate',
        'endDate',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    //protected $with = ['collaborator']; // or implement load() method in query
    protected $withCount = ['collaborator'];

    public function collaborator() {
        return $this->hasOne(Collaborators::class, 'id', 'collaborator_id');
    }
}
