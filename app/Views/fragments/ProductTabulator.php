
<div id="tbl-data" class=" " ></div>


<div class="modal modal-sm" id="confirmDeleteModal">
    <a href="javascript:hideConfirmDelete()" class="modal-overlay" aria-label="Close"></a>
    <div class="modal-container">
        <div class="modal-header ">
            <a href="javascript:hideConfirmDelete()" class="btn btn-clear btn-error float-right" aria-label="Close"></a>
            <div class="modal-title h5 text-center">Delete this Item?</div>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <div class="columns mt-2">
                <div class="column col-5 col-ml-auto col-md-12  " id=""><a class="btn btn-error text-light btn-lg " id="btn-del-yes" style="width: 100%;border-radius:10px;">YES</a></div>
                <div class="column col-5 col-mr-auto col-md-12  " id=""><a href="javascript:hideConfirmDelete()" class="btn btn-link text-light btn-lg text-dark" style="width: 100%;border-radius:10px; border:1px solid #000;">CANCEL</a></div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-sm" id="confirmSoldModal">
    <a href="javascript:hideConfirmSold()" class="modal-overlay" aria-label="Close"></a>
    <div class="modal-container">
        <div class="modal-header ">
            <a href="javascript:hideConfirmSold()" class="btn btn-clear btn-error float-right" aria-label="Close"></a>
            <div class="modal-title h5 text-center" id="sold-title">Mark As Sold?</div>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <div class="columns mt-2">
                <div class="column col-5 col-ml-auto col-md-12  " id=""><a class="btn btn-success text-light btn-lg " id="btn-sold-yes" style="width: 100%;border-radius:10px;">YES</a></div>
                <div class="column col-5 col-mr-auto col-md-12  " id=""><a href="javascript:hideConfirmSold()" class="btn btn-link text-light btn-lg text-dark" style="width: 100%;border-radius:10px; border:1px solid #000;">CANCEL</a></div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var confirmDeleteModal  = document.getElementById('confirmDeleteModal');
    var confirmSoldModal    = document.getElementById('confirmSoldModal');
    var productContainer    = document.getElementById('tbl-data');
    //Build Tabulator
    var table = new Tabulator("#tbl-data", {
        layout: "fitColumns",
        placeholder: "No Data Set",
        height: "350px",
        pagination: "local",
        paginationSize: 6,
        index: "id",
        paginationSizeSelector: [3, 6, 8, 10],
        columns: [
            {
                title: "Action",
                field: "id",
                sorter: "number",
                frozen: true,
                width: 150,
                hozAlign: "center",
                formatter: function(cell, formatterParams) {
                    return showActionBtn(cell.getValue());
                }
            },
            {
                title: "Feed",
                field: "id",
                sorter: "number",
                frozen: true,
                width: 150,
                hozAlign: "center",
                formatter: function(cell, formatterParams) {
                    return showFeed(cell.getValue());
                }
            },
            {
                title: "ID",
                field: "id",
                sorter: "string",
                width: 100,
                hozAlign: "center"
            },
            {
                title: "Type",
                field: "type",
                sorter: "number",
                width: 100,
                formatter: function(cell, formatterParams) {
                    return showType(cell.getValue());
                }
            },
            {
                title: "Age",
                field: "days",
                sorter: "number",
                hozAlign: "center",
                formatter: function(cell, formatterParams) {
                    return interpretDays(cell.getValue());
                }
            },
            {
                title: "Birthday",
                field: "bday",
                sorter: "date"
            },
            {
                title: "Kgs.",
                field: "weight",
                sorter: "number"
            },
            {
                title: "Pregnant",
                field: "pregnant",
                hozAlign: "center",
                sorter: "number",
                formatter: function(cell, formatterParams) {
                    return pregnant(cell.getValue());
                }
            },
            {
                title: "Due",
                field: "due",
                sorter: "date"
            },
            {
                title: "Sold",
                field: "sold",
                sorter: "number",
                formatter: function(cell, formatterParams) {
                    return pregnant(cell.getValue());
                }
            },
        ],
    });

    function fetchData() {
        console.log(getCookie("token"));
        $.ajax({
            url: "<?php echo base_url(); ?>/products",
            type: "POST",
            headers: {
                "Authorization": "Bearer " + getCookie("token")
            },
            error: function(xhr, status, error) {
                popError(xhr.responseJSON['messages']['error']);
                if (xhr.status == 401) {
                    console.log("UNAUTHORIZED");
                    logout();
                }
            },
            success: function(data) {
                var products = data['products'];
                table.setData(products);
            }
        })
    }

    fetchData();
    function showProductTable(){
        showItem(productContainer);
    }
    function hideProductTable(){
        hideItem(productContainer);
    }

    function showActionBtn(value) {
        var me = `<a class="btn btn-link" onclick ="fetchSingle(` + value + `)"><i class="icon icon-edit text-success"></i></a><a class="btn btn-link warning ml-2" onclick ="showConfirmDelete(` + value + `)"><i class="icon icon-delete text-error "></i></a><a class="btn btn-link" onclick ="showConfirmSold(` + value + `)"><i class="icon icon-flag text-primary"></i></a>`;
        return me;
    }
    function showFeed(value){
        var me = `<a class="btn btn-link" onclick ="showAddFeedsModal(` + value + `)"><i class="icon icon-plus text-success"></i></a><a class="btn btn-link" onclick ="pushFeedsRecord(` + value + `)"><i class="icon icon-resize-vert text-success"></i></a>`;
        return me;
    }

    function pregnant(value) {
        var me = "";

        if (value == 1) {
            me = `<i class="icon icon-check text-success"></i>`;
        } else {
            me = `<i class="icon icon-cross text-error"></i>`;
        }
        return me;
    }

    function showType(value) {
        if (value == 0) {
            return "PIG";
        } else if (value == 1) {
            return "COW";
        }
        return "";
    }

    function interpretDays(value) {
        var val = 0;
        var extension = "";
        if (value > 30) {
            val = Math.round(value / 30);
            if (val > 1) {
                extension = "Months";
            } else {
                extension = "Month";
            }
        } else if (value > 365) {
            val = Math.round(value / 365);
            if (val > 1) {
                extension = "Years";
            } else {
                extension = "Year";
            }
        } else {
            val = value;
            if (val > 1) {
                extension = "Days";
            } else {
                extension = "Day";
            }
        }
        return val + " " + extension;
    }
    function showProdTable(){
        $('#tbl-data').removeClass('d-hide');
    }
    function hideProdTable(){
        $('#tbl-data').addClass('d-hide');
    }
    function showConfirmDelete(id) {
        showModal(confirmDeleteModal);
        $("#btn-del-yes").attr('href', "javascript:deleteItem(" + id + ")");
    }

    function hideConfirmDelete() {
        hideModal(confirmDeleteModal);
    }


    function showConfirmSold(id) {
        var row = table.getRow(id);
        var rowData = row.getData();
        if (rowData.sold == 1) {
            $('#sold-title').text("Unsold item?");
            $("#btn-sold-yes").attr('href', "javascript:soldItem(" + 1 + "," + rowData.id + ")");
        } else {
            $('#sold-title').text("Mark as Sold?");
            $("#btn-sold-yes").attr('href', "javascript:soldItem(" + 2 + "," + rowData.id + ")");
        }
        showModal(confirmSoldModal);

    }

    function hideConfirmSold() {
        hideModal(confirmSoldModal);
    }

    function soldItem(action, id) {
        var ac = action == 1 ? "unsold" : "sold";
        console.log(action);
        showBtnLoading('#btn-sold-yes');
        $.ajax({
            url: '<?php echo base_url(); ?>/market/' + ac + '/' + id,
            type: 'POST',
            headers: {
                "Authorization": "Bearer " + getCookie("token")
            },
            error: function(xhr, status, error) {
                popError(xhr.responseJSON['messages']['error']);
                hideBtnLoading('#btn-sold-yes');
                if (xhr.status == 401) {
                    console.log("UNAUTHORIZED");
                    logout();
                }
            },
            success: function(data) {

                popSuccess(data["messages"]["success"]);
                hideBtnLoading('#btn-sold-yes');
                hideConfirmSold();
                fetchData();
            }

        });
    }

    function deleteItem(id) {
        showBtnLoading('#btn-del-yes');
        $.ajax({
            url: '<?php echo base_url(); ?>/delete/' + id,
            type: 'POST',
            headers: {
                "Authorization": "Bearer " + getCookie("token")
            },
            error: function(xhr, status, error) {
                hideBtnLoading('#btn-del-yes');
                popError(xhr.responseJSON['messages']['error']);
                if (xhr.status == 401) {
                    console.log("UNAUTHORIZED");
                    logout();
                }
            },
            success: function(data) {

                popSuccess(data["messages"]["success"]);
                hideBtnLoading('#btn-del-yes');
                hideConfirmDelete();
                fetchData();
            }

        });
    }
</script>