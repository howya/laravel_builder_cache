<?php

namespace Tests\Unit\Performance;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Schema;
use Tests\Fixtures\Models\StandardModel\User as UserNonCached;
use Tests\Fixtures\Models\CachedBuilderModel\User as UserBuilderCached;
use Tests\Fixtures\Models\CachedModel\User as UserModelCached;
use Illuminate\Support\Facades\Config;

/**
 * Class HasEncryptedAttributesTest
 * @package Tests\Unit\Performance
 */
class CachePerformanceTest extends TestCase
{

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/../../Fixtures/Factories');

        Schema::defaultStringLength(191);

        $this->loadMigrationsFrom(__DIR__ . '/../../Fixtures/Migrations');

        $this->artisan('db:seed', [
            '--class' => 'Tests\Fixtures\Seeds\TestDatabaseSeeder'
        ]);

        $this->artisan('cache:clear');

    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        //$app['config']->set('database.default', 'mysql');

        //$app['config']->set('cache.default', 'memcached');

        $app['config']->set('cache.default', 'redis');

        $app['config']->set('database.redis', [
            'client' => 'predis',
            'default' => [
                'host' => env('REDIS_HOST'),
                'password' => env('REDIS_PASSWORD'),
                'port' => env('REDIS_PORT'),
                'database' => 0,
            ],
        ]);
    }


    /**
     * @return void
     */
    public function testPerformance()
    {
        dump(Config::get('cache.default'));
        dump(Config::get('cache.stores.memcached'));
        //dump(Config::get('database.redis'));

        $non_cached_start = microtime(true);

        for ($i = 0; $i < 1000; $i++) {
            $this->runTheQuery(UserNonCached::class);
        }

        $non_cached_end = microtime(true);

        $non_cached_dur = $non_cached_end - $non_cached_start;

        dump('Non-Cached time taken: ' . $non_cached_dur);


        $builder_cached_start = microtime(true);

        for ($i = 0; $i < 1000; $i++) {
            $this->runTheQuery(UserBuilderCached::class);
        }

        $builder_cached_end = microtime(true);

        $builder_cached_dur = $builder_cached_end - $builder_cached_start;

        dump('Builder-Cached time taken: ' . $builder_cached_dur);


        $model_cached_start = microtime(true);

        for ($i = 0; $i < 1000; $i++) {
            $this->runTheQuery(UserModelCached::class);
        }

        $model_cached_end = microtime(true);

        $model_cached_dur = $model_cached_end - $model_cached_start;

        dump('Model-Cached time taken: ' . $model_cached_dur);
    }


    private function runTheQuery($class)
    {
        $class::with('integrated')->findOrFail(1)->integrated;
        $class::findOrFail(2);
        $class::with('integrated')->get();
        $class::whereHas('integrated', function ($query) {
            $query->where('client_id', '=', '2');
        })->get();
        $class::with('integrated')->findOrFail(2)->integrated;
        $class::findOrFail(3);
        $class::with('integrated')->get();
        $class::whereHas('integrated', function ($query) {
            $query->where('client_id', '=', '1');
        })->get();
    }

}
