<?php

namespace Tests\Fixtures\Models\CachedModel;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

/**
 * Class IntegrationServer
 * @package Tests\Fixtures\Models\StandardModel
 */
class IntegrationServer extends Model
{
    use Cachable;

    public function users()
    {
        return $this->belongsToMany(
            'Tests\Fixtures\Models\CachedModel\User',
            'user_integrations',
            'integration_server_id',
            'user_id',
            'id',
            'id');
    }
}