<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$webMiddlewares = config('file-object-manager.web-route-middlewares', []);
$webPrefix = config('file-object-manager.web-route-prefix', '/file-object-manager/components');
$apiMiddlewares = config('file-object-manager.api-route-middlewares', []);
$apiPrefix = config('file-object-manager.api-route-prefix', '/file-object-manager/api');


/**
 * Web routes
 */
Route::middleware($webMiddlewares)
    ->prefix($webPrefix)
    ->group(function () {
        Route::get('/list', function (Request $request) {
            $filters = $request->get('filters', config('file-object-manager.default-query-list-options.filters', []));
            $page = $request->get('page', config('file-object-manager.default-query-list-options.page', 0));
            $limit = $request->get('limit', config('file-object-manager.default-query-list-options.limit', 15));

            $component = new \RedFlag\FileObjectManager\Components\FileObjectListComponent();

            $component->page = $page;
            $component->limit = $limit;
            $component->filters = $filters;

            return \Illuminate\Support\Facades\Blade::renderComponent($component);
        });

        Route::get('/manager', function (Request $request) {
            $component = new \RedFlag\FileObjectManager\Components\FileObjectManagerComponent();

            return \Illuminate\Support\Facades\Blade::renderComponent($component);
        });
    });

/**
 * API routes
 */
Route::middleware($apiMiddlewares)
    ->prefix($apiPrefix)
    ->group(function () {
        Route::post('/get-upload-link', function (Request $request) {
            $res = [];

            $fileName = $request->get('filename');
            $path = \RedFlag\FileObjectManager\Facades\FomStorage::getPath($fileName);
            $extension = '.' . ltrim($request->get('ext'), '.');

            $fileAttributes = [
                'name' => $fileName,
                'type' => strtoupper(explode('/', $request->get('contentType'))[0]),
                'path' => $path,
                'extension' => $extension,
                'size' => $request->get('size'),
                'school_id' => 1,
                'driver' => config('file-object-manager.storage_driver'),
            ];

            $createdFile = \RedFlag\FileObjectManager\Facades\FileObjectManager::createOne($fileAttributes);

            $uploadInfo = \RedFlag\FileObjectManager\Facades\FomStorage::generateUploadLink($fileName);

            $res['upload_info'] = $uploadInfo;
            $res['file_info'] = $createdFile;

            return $res;
        });


        /**
         * Insecure path
         *
         * TODO: add authentication method
         */
        Route::post('/upload', function (Request $request) {
            $file = $request->file('file');
            $fullPath = $request->get('path');
            $fileName = last(explode('/', $fullPath));
            $path = rtrim($fullPath, '/' . $fileName);

            $file->storeAs($path, $fileName, [
                'disk' => 'local'
            ]);

            return response(null, 204);
        });

        Route::post('/delete-file', function (Request $request) {
            $id = $request->get('id');
            $file = \RedFlag\FileObjectManager\Facades\FileObjectManager::getOne($id);
            $path = $file->getPath();
            $driver = $file->getDriver();
            \RedFlag\FileObjectManager\Facades\FomStorage::driver($driver)->removeFile($path);
            \RedFlag\FileObjectManager\Facades\FileObjectManager::deleteOne($id);

            return [];
        });
    });
