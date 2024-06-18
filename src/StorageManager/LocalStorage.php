<?php

namespace RedFlag\FileObjectManager\StorageManager;

use Illuminate\Support\Facades\Storage;

class LocalStorage implements StorageInterface
{
    public function getPath($fileName = '')
    {
        $defaultPath = config('file-object-manager.storage_default_path')();

        return $defaultPath . $fileName;
    }

    public function removeFile($path)
    {
        return Storage::disk('local')->delete($path);
    }

    public function generateUploadLink($fileName)
    {
        return [
            'method' => 'POST',
            'url' => url(config('file-object-manager.api-route-prefix') . '/upload'),
            'fields' => [
                'path' => $this->getPath($fileName),
            ],
            'headers' => []
        ];
    }
}
