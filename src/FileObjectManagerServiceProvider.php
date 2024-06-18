<?php

namespace RedFlag\FileObjectManager;

use RedFlag\FileObjectManager\Commands\FileObjectManagerCommand;
use RedFlag\FileObjectManager\Components\FileObjectListComponent;
use RedFlag\FileObjectManager\Components\FileObjectManagerComponent;
use RedFlag\FileObjectManager\Components\FileObjectUploadComponent;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FileObjectManagerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('file-object-manager')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_file_object_manager_table')
            ->hasCommand(FileObjectManagerCommand::class)
            ->hasViewComponents('fom',
                FileObjectListComponent::class,
                FileObjectManagerComponent::class,
                FileObjectUploadComponent::class
            )
            ->hasAssets()
            ->hasRoute('file-object-manager');

        $this->publishes([
            $this->package->basePath('/../companion') => base_path('companion'),
        ], "{$this->packageView($this->package->viewNamespace)}-companion");
    }
}
