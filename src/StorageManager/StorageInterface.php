<?php

namespace RedFlag\FileObjectManager\StorageManager;

interface StorageInterface
{
    public function getPath($fileName);

    public function generateUploadLink($fileName);

    public function removeFile($path);
}
