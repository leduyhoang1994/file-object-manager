<?php

namespace RedFlag\FileObjectManager\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileObjectUploadComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('file-object-manager::components.file-object-upload-component');
    }
}
