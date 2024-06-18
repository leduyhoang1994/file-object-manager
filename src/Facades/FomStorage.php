<?php

namespace RedFlag\FileObjectManager\Facades;

use Illuminate\Support\Facades\Facade;
use RedFlag\FileObjectManager\StorageManager\StorageFactory;

/**
 * @method static string generateUploadLink($fileName)
 * @method static string getPath($fileName = '')
 * @method static bool removeFile($path)
 */
class FomStorage extends Facade
{
    /**
     * @throws \Exception
     */
    protected static function getFacadeAccessor(): string
    {
        $driver = config('file-object-manager.storage_driver', 'disk');

        return StorageFactory::resolve($driver);
    }

    public static function driver($driver)
    {
        $storage = StorageFactory::resolve($driver);

        return new $storage();
    }
}
