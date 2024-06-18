<?php

namespace RedFlag\FileObjectManager\Components;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use RedFlag\FileObjectManager\Facades\FileObjectManager;

class FileObjectListComponent extends Component
{
    public int $page = 0;
    public int $limit = 0;
    public array $filters = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->page = config('file-object-manager.default-query-list-options.page', 1);
        $this->limit = config('file-object-manager.default-query-list-options.limit', 15);
        $this->filters = config('file-object-manager.default-query-list-options.filters', []);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $fileObjects = FileObjectManager::getList([], $this->page, $this->limit);

//        $fileObjects->items()[rand(0, count($fileObjects->items()) - 1)]['is_disabled'] = true;

        return view(config('file-object-manager.views.list'), compact('fileObjects'));
    }
}
