<?php

namespace Tests\Fixtures\Seeds;

use Tests\Fixtures\Models\StandardModel\User;
use Tests\Fixtures\Models\StandardModel\IntegrationServer;
use Tests\Fixtures\Models\StandardModel\UserIntegration;

/**
 * Class TestSeederTable1
 * @package Tests\Fixtures\Seeds
 */
class TestSeederTable1 extends \Illuminate\Database\Seeder
{
    public function run()
    {
        //Eloquent::unguard();

        User::create([
            'id' => 1,
            'name' => 'clientuser1',
            'email' => 'clientuser1@test.com',
            'password' => bcrypt('test123')
        ]);

        User::create([
            'id' => 2,
            'name' => 'clientuser2',
            'email' => 'clientuser2@test.com',
            'password' => bcrypt('test123')
        ]);

        User::create([
            'id' => 3,
            'name' => 'clientuser3',
            'email' => 'clientuser3@test.com',
            'password' => bcrypt('test123')
        ]);


        IntegrationServer::create([
            'name' => 'Example API Server1',
            'client_id' => '1',
            'redirect_uri' => 'http://localhost:8080/oauth/authgranted',
            'authorize_uri' => 'http://localhost:8081/oauth/authorize',
            'token_uri' => 'http://webauthserver/oauth/token',
            'client_secret' => 'xnE08FxmaIdkO4xBkfNJ88dMjktqqRUzTH6AzOL4',
            'api_uri' => 'http://webauthserver/api/v1.0/recipies'
        ]);

        IntegrationServer::create([
            'name' => 'Example API Server2',
            'client_id' => '2',
            'redirect_uri' => 'http://localhost:8080/oauth/authgranted',
            'authorize_uri' => 'http://localhost:8081/oauth/authorize',
            'token_uri' => 'http://webauthserver/oauth/token',
            'client_secret' => 'xnE08FxmaIdkO4xBkfNJ88dMjktqqRUzTH6AzOL4',
            'api_uri' => 'http://webauthserver/api/v1.0/recipies'
        ]);

        IntegrationServer::create([
            'name' => 'Example API Server3',
            'client_id' => '3',
            'redirect_uri' => 'http://localhost:8080/oauth/authgranted',
            'authorize_uri' => 'http://localhost:8081/oauth/authorize',
            'token_uri' => 'http://webauthserver/oauth/token',
            'client_secret' => 'xnE08FxmaIdkO4xBkfNJ88dMjktqqRUzTH6AzOL4',
            'api_uri' => 'http://webauthserver/api/v1.0/recipies'
        ]);

        UserIntegration::create([
            'access_token' => 'exampletaccesstoken',
            'refresh_token' => 'examplerefreshtoken',
            'access_token_expires_in' => 123,
            'token_type' => 'bearer',
            'user_id' => 1,
            'integration_server_id' => 2
        ]);

        UserIntegration::create([
            'access_token' => 'exampletaccesstoken',
            'refresh_token' => 'examplerefreshtoken',
            'access_token_expires_in' => 123,
            'token_type' => 'bearer',
            'user_id' => 2,
            'integration_server_id' => 2
        ]);

        UserIntegration::create([
            'access_token' => 'exampletaccesstoken',
            'refresh_token' => 'examplerefreshtoken',
            'access_token_expires_in' => 123,
            'token_type' => 'bearer',
            'user_id' => 1,
            'integration_server_id' => 1
        ]);


        factory(UserIntegration::class, 60)->create([
            'user_id' => 1,
            'integration_server_id' => 1
        ]);

        factory(UserIntegration::class, 60)->create([
            'user_id' => 2,
            'integration_server_id' => 2
        ]);

        factory(UserIntegration::class, 60)->create([
            'user_id' => 3,
            'integration_server_id' => 3
        ]);
    }
}