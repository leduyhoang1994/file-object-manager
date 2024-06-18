<?php

namespace RedFlag\FileObjectManager\StorageManager;

class StorageFactory
{
    /**
     * @throws \Exception
     */
    public static function resolve($driver): string
    {
        switch ($driver) {
            case 'local':
                return LocalStorage::class;
            case 's3':
                return S3Storage::class;
        }

        throw new \Exception('Storage driver not defined');
    }
}
