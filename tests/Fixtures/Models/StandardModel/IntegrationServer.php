<?php

namespace Tests\Fixtures\Models\StandardModel;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IntegrationServer
 * @package Tests\Fixtures\Models\StandardModel
 */
class IntegrationServer extends Model
{

    public function users()
    {
        return $this->belongsToMany(
            'Tests\Fixtures\Models\StandardModel\User',
            'user_integrations',
            'integration_server_id',
            'user_id',
            'id',
            'id');
    }
}