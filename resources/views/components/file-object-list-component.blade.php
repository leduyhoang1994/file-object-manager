<?php
/**
 * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $fileObjects
 */

$lastPage = $fileObjects->currentPage() == 1 ? 1 : $fileObjects->currentPage() - 1;
$nextPage = $fileObjects->currentPage() == $fileObjects->lastPage() ? 1 : $fileObjects->currentPage() + 1;
$limit = $fileObjects->perPage();
?>
<style>
    .file-object.selected .file-checkbox-checked {
        background: var(--bs-primary) !important;
        display: flex !important;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-items: center;
    }

    .file-object.disabled .file-checkbox {
        background: grey !important;
    }

    .with-selector .file-checkbox-container {
        display: flex !important;
    }

    .with-selector .fom-navigation {
        display: block !important;
    }
</style>

<div>
    <div class="file-object-list-json" style="display: none">
        {{ json_encode($fileObjects->items()) }}
    </div>
    <a class="fom-refresh-list" href="javascript:void(0)">Refresh List</a>
    <div class="fom-navigation" style="display: none">
        <a class="fom-select-currents" href="javascript:void(0)">Select Currents</a>
        <a class="fom-deselect-currents" href="javascript:void(0)">Deselect Currents</a>
        <a class="fom-deselect-all" href="javascript:void(0)">Deselect All</a>
    </div>
    <div class="fom-selecting-status">

    </div>
    @foreach($fileObjects as $fileObject)
        <div class="file-object {{$fileObject->getDisabled() ?? "disabled"}}"
             data-file-object-id="{{$fileObject->getId()}}"
             style="display: flex; align-items: center; cursor: pointer" id="file-object-{{$fileObject->getId()}}">
            <div class="file-checkbox-container"
                 style="width: 50px; height: 50px; text-align: center; display: none; align-items: center">
                <div class="file-checkbox"
                     style="width: 30px; height: 30px; background: white; border: grey thin solid">
                    <div class="file-checkbox-checked" style="display: none">
                        x
                    </div>
                </div>
            </div>
            <div style="flex: 1">
                {{$fileObject->getId()}} - {{ $fileObject->getName() }}
            </div>
        </div>
    @endforeach

    <div>
        <div class="prev">
            @if($fileObjects->currentPage() > 1)
                <a href="javascript:void(0)" onclick="FileObjectManager.loadList({{$lastPage}}, {{$limit}})">
                    Previous
                </a>
            @endif
        </div>
        <div class="next">
            @if($fileObjects->currentPage() < $fileObjects->lastPage())
                <a href="javascript:void(0)" onclick="FileObjectManager.loadList({{$nextPage}}, {{$limit}})">
                    Next
                </a>
            @endif
        </div>
    </div>
</div>
