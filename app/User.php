<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'preferences'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var string
     */
    protected $guard_name = 'api';

//    /**
//     * @var array
//     */
//    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'preferences' => 'array',
    ];

    /**
     * Relations
     */
    public function completedTasks(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'task_completion', 'user_id', 'task_id');
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'user_location');
    }

    /**
     * Methods
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }
}
