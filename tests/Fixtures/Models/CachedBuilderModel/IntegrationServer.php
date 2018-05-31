<?php

namespace Tests\Fixtures\Models\CachedBuilderModel;

use Illuminate\Database\Eloquent\Model;
use RBennett\ModelCache\ModelCaching\CachedModel;

/**
 * Class IntegrationServer
 * @package Tests\Fixtures\Models\StandardModel
 */
class IntegrationServer extends Model
{
    use CachedModel;

    public function users()
    {
        return $this->belongsToMany(
            'Tests\Fixtures\Models\CachedBuilderModel\User',
            'user_integrations',
            'integration_server_id',
            'user_id',
            'id',
            'id');
    }
}