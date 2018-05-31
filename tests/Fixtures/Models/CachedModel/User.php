<?php

namespace Tests\Fixtures\Models\CachedModel;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

/**
 * Class User
 * @package Tests\Fixtures\StandardModel
 */
class User extends Authenticatable
{
    use Notifiable, Cachable;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function integrated()
    {
        return $this->belongsToMany(
            'Tests\Fixtures\Models\CachedModel\IntegrationServer',
            'user_integrations',
            'user_id',
            'integration_server_id',
            'id',
            'id');
    }
}
