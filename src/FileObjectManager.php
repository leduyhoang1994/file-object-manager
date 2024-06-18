<?php

namespace RedFlag\FileObjectManager;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use RedFlag\FileObjectManager\Models\FileObjectInterface;

class FileObjectManager
{
    protected FileObjectInterface $model;

    public function __construct()
    {
        $modelType = config('file-object-manager.file-object-model');
        $this->model = new $modelType;
    }

    public function getList($filters = [], $page = 0, $limit = null): LengthAwarePaginator
    {
        return $this->model->getList($filters, $page, $limit);
    }

    public function getOne($id): FileObjectInterface
    {
        return $this->model->getOne($id);
    }

    public function createOne($attributes)
    {
        return $this->model->createOne($attributes);
    }

    public function deleteOne($id): void
    {
        $this->model->deleteOne($id);
    }
}
