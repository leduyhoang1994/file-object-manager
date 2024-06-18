<?php

namespace RedFlag\FileObjectManager\StorageManager;

use Illuminate\Support\Facades\Storage;

class S3Storage implements StorageInterface
{
    protected function getDefaultBucket() {
        return config('filesystems.disks.s3.bucket');
    }

    public function getPath($fileName = '', $bucket = null)
    {
        $bucket = $bucket ?? $this->getDefaultBucket();
        $defaultPath = config('file-object-manager.storage_default_path')();

        return '/' . $bucket . $defaultPath . $fileName;
    }

    public function generateUploadLink($fileName, $bucket = null)
    {
        /** @var \Aws\S3\S3Client $client */
        $client = \Illuminate\Support\Facades\Storage::cloud()->getClient();

        $bucket = $bucket ?? $this->getDefaultBucket();
        $client->listBuckets();

        // Set defaults for form input fields.
        $formInputs = ['acl' => 'public-read'];
        $path = config('file-object-manager.storage_default_path')();

        // Construct an array of conditions for policy.
        $options = [
            ['acl' => 'public-read'],
            ['bucket' => $bucket],
            ['starts-with', '$key', $path],
        ];

        // Set an expiration time (optional).
        $expires = '+2 hours';

        $postObject = new \Aws\S3\PostObjectV4(
            $client,
            $bucket,
            $formInputs,
            $options,
            $expires
        );

        $postObject->setFormInput('key', $path . $fileName);

        // Get attributes for the HTML form, for example, action, method, enctype.
        $formAttributes = $postObject->getFormAttributes();

        // Get attributes for the HTML form values.
        $formInputs = $postObject->getFormInputs();

        return [
            'method' => $formAttributes['method'],
            'url' => $formAttributes['action'],
            'fields' => $formInputs,
            'headers' => []
        ];
    }

    public function removeFile($path)
    {
        Storage::disk('s3')->delete($path);
    }
}
