<?php

namespace RedFlag\FileObjectManager\Facades;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Facade;
use RedFlag\FileObjectManager\Models\FileObjectInterface;
use RedFlag\FileObjectManager\StorageManager\StorageFactory;
use RedFlag\FileObjectManager\StorageManager\StorageInterface;

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
