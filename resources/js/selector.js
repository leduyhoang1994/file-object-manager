window.ListSelector = function (options = {}) {
    let selectedIds = [];
    let selectedList = [];
    let onSelectedChange = null;
    let selectMode = options.list.selectMode;
    let dataList = [];

    console.log('Init selector');

    function normalize(dataList) {
        return dataList.map(d => {
            d.id = parseInt(d.id);
            return d;
        });
    }

    function selectedChangeEvent() {
        if (onSelectedChange) {
            onSelectedChange(dataList, selectedIds);
        }

        selectedList = selectedList.filter((d) => selectedIds.includes(d.id));

        selectedIds.forEach((id) => {
            const data = dataList.find(d => d.id === id);
            const exist = selectedList.find(d => d.id === id);

            data && !exist && selectedList.push(data);
        });
    }

    function deselect(id, withEvent = true) {
        id = parseInt(id);

        if (selectedIds.indexOf(id) < 0) {
            return;
        }

        selectedIds.splice(selectedIds.indexOf(id), 1);
        withEvent && selectedChangeEvent();
    }

    function isSelectMultiple() {
        return selectMode === 'MULTIPLE';
    }

    function isSelectSingle() {
        return selectMode === 'SINGLE';
    }

    function setSelectMode(mode) {
        selectMode = mode;
    }

    function limitedSelections() {
        if (!options.list.maxSelectedItems) {
            return false;
        }

        return selectedIds.length >= options.list.maxSelectedItems;
    }

    function select(id, withEvent = true) {
        id = parseInt(id);

        // Remove if existed
        if (selectedIds.includes(id) && isSelectMultiple()) {
            deselect(id, false);
            withEvent && selectedChangeEvent();
            console.log('File is already selected');
            return;
        }

        if (limitedSelections()) {
            console.log('Limit selection');
            return;
        }

        console.log(dataList, id);
        const selectedData = dataList.find((d) => d.id === id);

        if (!selectedData) {
            console.log('Selected file not found');
            return;
        }

        if (selectedData.is_disabled) {
            console.log('File is disabled');
            return;
        }

        // Add to selectedList
        if (isSelectMultiple()) {
            selectedIds.push(id);
            withEvent && selectedChangeEvent();
            return;
        }

        // Select single
        selectedIds = [id];
        withEvent && selectedChangeEvent();
    }

    return {
        pushData: function (...data) {
            data = normalize(dataList);
            data.forEach((d) => {
                if (this.getListIds().includes(d.id)) {
                    return true;
                }

                dataList.push(d);
            });
        },
        setData: function (data) {
            dataList = normalize(data);
        },
        select,
        selects: function (ids) {
            ids = ids.filter(function (item, pos) {
                return ids.indexOf(item) === pos;
            });

            ids.forEach(id => deselect(id, false));
            ids.forEach(id => select(id, false));
            selectedChangeEvent();
        },
        deselectAll: function () {
            selectedIds = [];
            selectedChangeEvent();
        },
        deselects: function (ids) {
            ids = ids.filter(function (item, pos) {
                return ids.indexOf(item) === pos;
            });

            // console.log("To Deselect", ids);
            // console.log("Selected list", this.getSelectedIds());
            ids.forEach(id => deselect(id, false));
            selectedChangeEvent();
        },
        selectAll: function () {
            dataList.forEach((item) => select(item.id, false));
            selectedChangeEvent();
        },
        getSelectedList: () => selectedList,
        getDataList: function () {
            return dataList;
        },
        getListIds: function () {
            return dataList.map(item => item.id);
        },
        setOnSelectedChange: function (f) {
            onSelectedChange = f;
        },
        getSelectedIds: function () {
            return selectedIds;
        },
        limitedSelections,
        hasLimitSelection: () => options.list.maxSelectedItems > 0,
        isSelectMultiple,
        isSelectSingle,
        maxSelectedItems: () => options.list.maxSelectedItems,
        setSelectMode
    };
}
