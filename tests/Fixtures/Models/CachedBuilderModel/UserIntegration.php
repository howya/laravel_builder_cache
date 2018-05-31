<?php

namespace Tests\Fixtures\Models\CachedBuilderModel;

use Illuminate\Database\Eloquent\Model;
use RBennett\ModelCache\ModelCaching\CachedModel;

/**
 * Class UserIntegration
 * @package Tests\Fixtures\Models\StandardModel
 */
class UserIntegration extends Model
{
    use CachedModel;

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