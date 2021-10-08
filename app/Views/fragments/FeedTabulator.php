
<div class="d-invisible" style="margin-left:40px; margin-bottom:5px" id="button-feed">
    <button class="btn btn-primary  " onclick="hideFeedsTable()"><i class="icon icon-back"></i></button>
    <button class="btn btn-success " onclick="immediateAddFeeds()"><i class="icon icon-plus"></i></button>
</div>

<div id="tbl-feed" class="d-hide"></div>
<div class="modal " id="addFeedModal">
    <a href="javascipt:void()" class="modal-overlay" aria-label="Close"></a>
    <div class="modal-container">
        <div class="modal-header ">
            <a href="javascript:hideAddFeedsModal()" class="btn btn-clear btn-error float-right" aria-label="Close"></a>
            <div class="modal-title h5 text-center" id="frm-feed-title">New Vitamin/Feeds</div>
        </div>
        <div class="modal-body ">

            <div class="content">
                <form id="feeds-frm">
                    <div class="columns">

                        <div class="column col-6 col-md-12">
                            <!-- ID NUMBER -->
                            <div class="form-group" id = "feed-frm-owner">
                                <label class="form-label" for="in-prod-id">ID</label>
                                <input class="form-input"  placeholder="owner id"  id="in-feed-mirror" disabled>
                                <input type="hidden" name="owner" id="in-feed-id">
                            </div>
                            <!-- name of Vitamin/feeds -->
                            <div class="form-group " id = "feed-frm-name">
                                <label class="form-label" for="feed-name">Name</label>
                                <input class="form-input" type="text" id="feed-name" name="name" placeholder="">
                            </div>
                        </div>
                        <div class="column col-6 col-md-12">
                            <!-- Type -->
                            <div class="form-group" id = "feed-frm-type">
                                <label class="form-label" for="feed-type">Type</label>
                                <select class="form-select" id="feed-type" name="type">
                                    <option value="0">Feeds</option>
                                    <option value="1">Vitamin</option>
                                </select>
                            </div>
                            <!-- Administered -->
                            <div class="form-group" id = "feed-frm-admin">
                                <label class="form-label" for="feed-type">Given</label>
                                <input class="form-input" id="feed-given" name="administered" type="date" onKeyDown="return false">
                            </div>
                        </div>
                    </div>
                </form>
                <br />
                <div class="columns mt-2">
                    <div class="column col-3  hide-md"></div>
                    <div class="column col-3 col-md-12  " id="add-prod-btn"><a href="" class="btn btn-primary text-light btn-lg " id="feed-btn-send" style="width: 100%;border-radius:10px;">ADD</a></div>
                    <div class="column col-1 col-md-12 mt-2 mb-2"></div>
                    <div class="column col-3 col-md-12  " id="add-prod-btn"><a href="javascript:hideAddFeedsModal()" id="feed-btn-cancel" class="btn btn-link text-light btn-lg text-dark" style="width: 100%;border-radius:10px; border:1px solid #000;">CLEAR</a></div>
                    <div class="column col-2  hide-md"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">

        </div>
    </div>
</div>

<div class="modal modal-sm" id="confirmFeedsDeleteModal">
    <a href="#" class="modal-overlay" aria-label="Close"></a>
    <div class="modal-container">
        <div class="modal-header ">
            <a href="javascript:hideDeleteFeedModal()" class="btn btn-clear btn-error float-right" aria-label="Close"></a>
            <div class="modal-title h5 text-center">Delete this Item?</div>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <div class="columns mt-2">
                <div class="column col-5 col-ml-auto col-md-12  " id=""><a class="btn btn-error text-light btn-lg " id="feed-btn-yes" style="width: 100%;border-radius:10px;">YES</a></div>
                <div class="column col-5 col-mr-auto col-md-12  " id=""><a href="javascript:hideDeleteFeedModal()" class="btn btn-link text-light btn-lg text-dark" style="width: 100%;border-radius:10px; border:1px solid #000;">CANCEL</a></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        var feedAddModal            = document.getElementById('addFeedModal');
        var feedsContainer          = document.getElementById('tbl-feed');
        var feedDeleteModal          = document.getElementById('confirmFeedsDeleteModal');
        var feedButtons             = document.getElementById('button-feed');
        var currentProductID         = 0;
    var feedtable = new Tabulator("#tbl-feed", {
        layout: "fitColumns",
        placeholder: "No Data Set",
        height: "350px",
        pagination: "local",
        paginationSize: 6,
        index: "id",
        paginationSizeSelector: [3, 6, 8, 10],
        columns: [{
                title: "Action",
                field: "id",
                sorter: "number",
                frozen: true,
                width: 150,
                hozAlign: "center",
                formatter: function(cell, formatterParams) {
                    return feedActionBtn(cell.getValue());
                }
            },
            {
                title: "Product",
                field: "owner",
                sorter: "number",
                width: 100,
            },
            {
                title: "Name",
                field: "name",
                sorter: "string",
                hozAlign: "center"
            },
            {
                title: "Type",
                field: "type",
                sorter: "number",
                hozAlign: "center",
                formatter: function(cell,formatterParams){return interpretFeedsType(cell.getValue());
                }
            },
            {
                title: "Administer",
                field: "administered",
                sorter: "date",
                hozAlign: "center"
            },
        ],
    });

    function feedActionBtn(value) {
        var me = `<a class="btn btn-link" onclick ="editFeedItem(` + value + `)"><i class="icon icon-edit text-success"></i></a><a class="btn btn-link" onclick ="showDeleteFeedModal(` + value + `)"><i class="icon icon-delete text-error"></i></a>`;
        return me;
    }
    function returnToProductTable(){
        hideFeedsTable();
        showProductTable();
    }
    function showFeedsTable(){
        showItem(feedsContainer);
        feedButtons.classList.remove('d-invisible')
    }
    function hideFeedsTable(){
        hideItem(feedsContainer);
        feedButtons.classList.add('d-invisible')
        showProductTable();
    }

    function hideDeleteFeedModal(){
        hideModal(feedDeleteModal);
    }
    function showDeleteFeedModal(id){
        showModal(feedDeleteModal);
        var url = `javascript:deleteFeedsItem(`+id+`)`;
        $('#feed-btn-yes').attr("href",url);
    }
    function showEditFeedsModal(){

    }
    function interpretFeedsType(value){
        if(value == 0){
            return '<span class="label label-success">Feeds</span>';
        }
        return' <span class="label label-primary">Vitamin</span>';
    }
    function immediateAddFeeds(){
        showAddFeedsModal(currentProductID);
    }
    function showAddFeedsModal(id){
        revertFeedAddModal();
        $('#in-feed-id').val(id);
        $('#in-feed-mirror').val(id);
      showModal(feedAddModal);
      var url       = `javascript:addFeedRecord(`+id+`)`;
      $('#feed-btn-send').attr("href",url);
    }
    function hideAddFeedsModal(){
      hideModal(feedAddModal);
    }
    function pushFeedsRecord(ownerid, refresh = 1) {
        currentProductID = ownerid; // update the CURRENT Owner
        $.ajax({
            url: "<?php echo base_url(); ?>/feed/pull/" + ownerid,
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
                var products = data['feeds'];
                feedtable.setData(products); // push result to feeds table
                if(refresh == 1){
                    hideProductTable(); // hide the product table
                showFeedsTable();
                }
               
                
            }
        })
    }
    function editFeedItem(id){
        var row = feedtable.getRow(id);
        var data    = row.getData();
        insertValueFeedModal(data);
        var url         =  `javascript:addFeedRecord(`+ data.id +`,` + `"update"` + `)`; 
        $('#feed-btn-send').attr('href',url);
        showModal(feedAddModal);
    }
    function insertValueFeedModal(arrData){
        $('#in-feed-mirror').attr('type','hidden');
        $('#in-feed-id').attr('type','text');
        $('#in-feed-id').val(arrData.owner);
        $('#feed-type').val(arrData.type);
        $('#feed-name').val(arrData.name);
        $('#feed-given').val(arrData.administered);
        $('#frm-feed-title').text('Update Record');
        $('#feed-btn-send').text('Update');
        
    }
    function revertFeedAddModal(){
        $('#in-feed-mirror').attr('type','text');
        $('#in-feed-id').attr('type','hidden');
        $('#in-feed-id').val('');
        $('#feed-type').val(0);
        $('#feed-name').val('');
        $('#feed-given').val('');
        $('#frm-feed-title').text('New Vitamin/Feeds');
        $('#feed-btn-send').text('Add');
    }
    
    function deleteFeedsItem(id){
        var endpoint        = '<?php echo base_url();?>/feeds/delete/'+ id;
        showBtnLoading('#feed-btn-yes');
            $.ajax({
                url: endpoint ,
                type: 'POST',
                dataType: 'JSON',
                headers: {
                    "Authorization": "Bearer " + getCookie("token")
                },
                error: function(xhr, status, error) {
                    var errData = xhr.responseJSON;
                    popError('Failed to Delete');
                    var errdata = xhr.responseJSON;
                    if (xhr.status == 401) {
                        console.log("UNAUTHORIZED");
                        logout();
                    }
                    
                    hideBtnLoading('#feed-btn-yes');
                },
                success: function(response) {
                    console.log('Success');
                    popWarn('Deleted');
                    hideBtnLoading('#feed-btn-yes');
                    hideDeleteFeedModal();
                    //add refresh code
                    pushFeedsRecord(currentProductID,0);
                }
            });
    }
    function addFeedRecord(id,action="new") {
        endpoint        = '<?php echo base_url();?>/feeds/create'
        if(action == "update"){
            endpoint        = '<?php echo base_url();?>/feeds/update/'+ id;
        }
        removeErrorFeedsField();
        showBtnLoading('#feed-btn-send');
            $.ajax({
                url: endpoint ,
                type: 'POST',
                dataType: 'JSON',
                contentType: 'application/json',
                data: frmToJSON('#feeds-frm'),
                headers: {
                    "Authorization": "Bearer " + getCookie("token")
                },
                error: function(xhr, status, error) {
                    var errData = xhr.responseJSON;
                   popError('Failed to Add');
                    updateErrorFeedsField(errData['messages']);
                    var errdata = xhr.responseJSON;
                    if (xhr.status == 401) {
                        console.log("UNAUTHORIZED");
                        logout();
                    }
                    hideBtnLoading('#feed-btn-send');
                },
                success: function(response) {
                    console.log('Success');
                  popSuccess('Success');
                    hideBtnLoading('#feed-btn-send');
                    hideAddFeedsModal();
                   
                    //add refresh code

                    pushFeedsRecord(currentProductID,0);
                }
            });
        }

        

        function updateErrorFeedsField(arrError) {
            if ('owner' in arrError) {
                $('#feed-frm-owner').addClass('has-error');
            }
            if ('type' in arrError && 'due' in arrError) {
                $('#feed-frm-type').addClass('has-error');
            }
            if ('name' in arrError) {
                $('#feed-frm-name').addClass('has-error');
            }
            if ('administered' in arrError) {
                $('#feed-frm-admin').addClass('has-error');
            }
        }

        function removeErrorFeedsField() {
            $('#feed-frm-owner').removeClass('has-error');
            $('#feed-frm-type').removeClass('has-error');
            $('#feed-frm-name').removeClass('has-error');
            $('#feed-frm-admin').removeClass('has-error');
        }

</script>