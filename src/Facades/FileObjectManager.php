<?php

namespace RedFlag\FileObjectManager\Facades;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Facade;
use RedFlag\FileObjectManager\Models\FileObjectInterface;

/**
 * @see \RedFlag\FileObjectManager\FileObjectManager
 * @method static LengthAwarePaginator getList($filter, $page, $limit)
 * @method static FileObjectInterface getOne($id)
 * @method static FileObjectInterface createOne($attributes)
 * @method static FileObjectInterface deleteOne($id)
 */
class FileObjectManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \RedFlag\FileObjectManager\FileObjectManager::class;
    }
}
