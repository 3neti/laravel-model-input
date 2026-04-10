<?php

namespace LBHurtado\ModelInput\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LBHurtado\ModelInput\Tests\Models\User;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'LBHurtado\\ModelInput\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        $this->loadConfig();
        $this->loginTestUser();
    }

    protected function getPackageProviders($app): array
    {
        return [
            \LBHurtado\ModelInput\ModelInputServiceProvider::class,
            \Propaganistas\LaravelPhone\PhoneServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('auth.defaults.guard', 'web');
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    protected function loginTestUser(): void
    {
        $user = User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
            ]
        );

        $this->actingAs($user, 'web');
    }

    protected function loadConfig(): void
    {
        $this->app['config']->set(
            'model-input',
            require __DIR__.'/../config/model-input.php'
        );
    }
}