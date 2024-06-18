<?php

namespace RedFlag\FileObjectManager\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Casts\Attribute;

interface FileObjectInterface
{
    public function getOne($id): self;

    public function getList($filters = [], $page = 0, $limit = null): LengthAwarePaginator;

    public function createOne($attributes) : self;

    public function deleteOne($id): void;

    public function getId();

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getDriver(): string;

    public function setDriver(string $driver): void;

    public function getPath(): string;

    public function setPath(string $path): void;

    public function getExt(): string;

    public function setExt(string $ext): void;

    public function getSize(): int;

    public function setSize(int $size): void;

    public function getType(): string;

    public function setType(string $type): void;

    public function getDisabled(): bool;

    public function setDisabled(bool $disabled): void;
}
