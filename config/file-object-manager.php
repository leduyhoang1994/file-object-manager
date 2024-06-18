<?php

// config for RedFlag/FileObjectManager
return [
    /**
     * File Object Model
     */
    'file-object-model' => \RedFlag\FileObjectManager\Models\FileObject::class,

    /**
     * File Object table name
     */
    'file-object-table' => 'file-objects',

    'web-route-middlewares' => [],

    'web-route-prefix' => '/file-object-manager/components',

    'api-route-middlewares' => [],

    'api-route-prefix' => '/file-object-manager/api',

    'default-query-list-options' => [
        'filters' => [],
        'page' => 1,
        'limit' => 20,
    ],

    'views' => [
        'list' => 'file-object-manager::components.file-object-list-component',
    ],

    'storage_driver' => 's3', // s3, local

    'storage_default_path' => function () {
        return '/'.date('Y').'/'.date('m').'/'.date('d').'/';
    },
];
