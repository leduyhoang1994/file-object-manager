import {mergeDeep} from "./helper";
import './uploader';
import './selector';

window.FileObjectManager = (function () {
    let container;
    let listContainer;
    let options = {
        useSelector: true,
        useUploader: true,
        selectors: {
            list: '#file-object-list',
            manager: '#file-object-manager',
            listJson: '.file-object-list-json',
            selectCurrents: '.fom-select-currents',
            deselectCurrents: '.fom-deselect-currents',
            deselectAll: '.fom-deselect-all',
            selectingStatus: '.fom-selecting-status',
            refreshList: '.fom-refresh-list',
        },
        list: {
            pagination: {
                page: 1,
                limit: 15
            },
            selectMode: 'SINGLE',
            maxSelectedItems: 0,
        },
        routes: {
            components: {
                list: '/file-object-manager/components/list',
                manager: '/file-object-manager/components/manager',
            }
        },
        uploader: {
            // companionUrl: 'http://localhost:8033',
            // companionAllowedHosts: [
            //     'http://localhost:8033'
            // ],
            // getUploadLinkUrl: '/file-object-manager/api/get-upload-link',
        },
        events: {
            onSelectedChange: function(dataList, selectedIds) {

            }
        }
    };
    const currentPagination = {
        page: options.list.pagination.page,
        limit: options.list.pagination.limit,
    };
    const states = {
        list: 'LOADING',
    };
    let listSelector = ListSelector(options);
    let uploader = null;
    let jsonData = [];

    async function loadList(page, limit) {
        listContainer = document.querySelector(options.selectors.list);
        listContainer.classList.toggle('with-selector', options.useSelector);

        const url = `${options.routes.components.list}?page=${page}&limit=${limit}`;
        currentPagination.page = page;
        currentPagination.limit = limit;

        toggleLoadingList(true);
        const response = await fetch(url);
        listContainer.innerHTML =  await response.text();
        toggleLoadingList(false);
        jsonData = JSON.parse(listContainer.querySelector(options.selectors.listJson).innerText);

        listSelector.setData(jsonData);
        options.useSelector && renderSelected();
        options.useSelector && registerSelectorButtons();
        listSelector.setOnSelectedChange((dataList, selectedIds) => {
            renderSelected();
            options.events.onSelectedChange && options.events.onSelectedChange(dataList, selectedIds);
        });
        listSelector.setSelectMode(options.list.selectMode);
    }

    async function loadManager() {
        const url = `${options.routes.components.manager}`;

        const response = await fetch(url);
        container.innerHTML = await response.text();
    }

    function renderSelected() {
        const selectedIds = listSelector.getSelectedIds();

        listContainer.querySelectorAll('.file-object').forEach((f) => f.classList.remove("selected"));

        selectedIds.forEach((id) => {
            listContainer.querySelector(`#file-object-${id}`)?.classList.add("selected");
        });

        if (listSelector.limitedSelections()) {
            listSelector.getDataList().filter(d => !selectedIds.includes(d.id)).forEach((d) => {
                listContainer.querySelector(`#file-object-${d.id}`)?.classList.add("disabled");
            });
        } else {
            listSelector.getDataList().filter(d => !selectedIds.includes(d.id)).forEach((d) => {
                listContainer.querySelector(`#file-object-${d.id}`)?.classList.remove("disabled");
            });
        }

        if (options.useSelector) {
            listContainer.querySelectorAll(options.selectors.selectingStatus).forEach((d) => {
                let maxSelecting = '';

                if (listSelector.isSelectMultiple() && listSelector.hasLimitSelection()) {
                    maxSelecting = `of ${listSelector.maxSelectedItems()}`;
                }

                d.innerHTML = `Selecting ${selectedIds.length} ${maxSelecting} item(s)`;
            });
        }

        renderDisabled();
    }

    function renderDisabled() {
        listSelector.getDataList().filter(d => d.is_disabled === true).forEach((d) => {
            listContainer.querySelector(`#file-object-${d.id}`)?.classList.add("disabled");
        });
    }

    async function reloadList() {
        await loadList(currentPagination.page, currentPagination.limit);
    }

    function toggleLoadingList(show) {
        if (show) {
            listContainer.innerHTML = 'Loading File Objects . . .';
            states.list = 'LOADING';
        }
    }

    async function loadManagerUI() {
        await loadManager();
        options.useUploader && initUploader();

        $('.tab-a').click(function(){
            toggleTab($(this).attr('data-id'));
        });
        await loadList(options.list.pagination.page, options.list.pagination.limit);
    }

    function initUploader() {
        console.log('Init uploader');
        uploader = window.FomUploader(options.uploader);
    }

    function registerSelectorButtons() {
        document.querySelectorAll(options.selectors.selectCurrents).forEach(box => {
            box.addEventListener('click', () => {
                listSelector.selects(listSelector.getDataList().map((d) => d.id));
            });
        });
        document.querySelectorAll(options.selectors.deselectAll).forEach(box => {
            box.addEventListener('click', () => {
                listSelector.deselectAll();
            });
        });
        document.querySelectorAll(options.selectors.deselectCurrents).forEach(box => {
            box.addEventListener('click', () => {
                listSelector.deselects(listSelector.getDataList().map((d) => d.id));
            });
        });
        document.querySelectorAll(options.selectors.refreshList).forEach(box => {
            box.addEventListener('click', async () => {
                await reloadList();
            });
        });
        listContainer.querySelectorAll('.file-object').forEach((f) => {
            f.addEventListener('click', (e) => {
                e.preventDefault();
                FileObjectManager.listSelector().select(f.getAttribute('data-file-object-id'));
            });
        });
    }

    function toggleTab(tab) {
        switch (tab) {
            case 'upload':
                $("#nav-upload-tab").click();
                break;
            case 'list':
                $("#nav-choose-tab").click();
                break;
        }
        $(".tab").removeClass('tab-active');
        $(".tab[data-id='"+tab+"']").addClass("tab-active");

        $(".tab-a").removeClass('active-a');
        $(".tab-a[data-id='"+tab+"']").addClass('active-a');
    }

    return {
        init: async function (selector, opt = {}) {
            mergeDeep(options, opt);
            container = document.querySelector(selector || options.selectors.manager);
            await loadManagerUI();
        },
        reloadList,
        loadList,
        listSelector: () => listSelector,
        showListAndSelect: async (id) => {
            toggleTab('list');
            await reloadList();
            listSelector.select(id);
        },
    };
})();

