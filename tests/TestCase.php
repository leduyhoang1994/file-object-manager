<?php

namespace RedFlag\FileObjectManager\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use RedFlag\FileObjectManager\FileObjectManagerServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'RedFlag\\FileObjectManager\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FileObjectManagerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_file-object-manager_table.php.stub';
        $migration->up();
        */
    }
}
