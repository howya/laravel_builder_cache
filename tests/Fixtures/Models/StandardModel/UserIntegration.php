<?php

namespace Tests\Fixtures\Models\StandardModel;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserIntegration
 * @package Tests\Fixtures\Models\StandardModel
 */
class UserIntegration extends Model
{

    public $fillable = [
        'authorization_code',
        'access_token',
        'refresh_token',
        'access_token_expires_in',
        'user_id',
        'integration_server_id',
        'token_type',
        'scope'
    ];

}