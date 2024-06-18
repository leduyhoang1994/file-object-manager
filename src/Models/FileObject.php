<?php

namespace RedFlag\FileObjectManager\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class FileObject extends Model implements FileObjectInterface
{
    protected $guarded = [];

    public function getTable()
    {
        return config('file-object-manager.file-object-table');
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function setDriver(string $driver): void
    {
        $this->driver = $driver;
    }

    public function getFullPath(): string
    {
        return "https://uni3-storage.onschool.edu.vn" . $this->getPath();
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getExt(): string
    {
        return $this->ext;
    }

    public function setExt(string $ext): void
    {
        $this->ext = $ext;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getDisabled(): bool
    {
        return $this->is_disabled === true;
    }

    public function setDisabled(bool $disabled): void
    {
        $this->is_disabled = $disabled;
    }

    public function getOne($id): FileObjectInterface
    {
        return new self(self::query()->find($id)->toArray());
    }

    public function getList($filters = [], $page = 1, $limit = null): LengthAwarePaginator
    {
        if (!$limit) {
            $limit = config('file-object-manager.default-query-list-options.limit', 15);
        }

        return self::query()->orderBy('id', 'desc')->paginate(perPage: $limit, page: $page);
    }

    public function createOne($attributes): FileObjectInterface
    {
        return new self(self::query()->create($attributes)->toArray());
    }

    public function deleteOne($id): void
    {
        self::query()->where('id', $id)->delete();
    }
}
