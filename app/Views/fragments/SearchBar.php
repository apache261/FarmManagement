
<div class="search-bar-container pt-2 mt-2 mb-2 pb-2">
    <div class="search-bar columns ">
        <div class="column col-6 col-md-12 col-mr-auto col-ml-auto ">
            <div class="input-group">
                <input class="form-input input-lg" id="search-keyy" style="height:2.5rem" type="text" onkeyup="doSearch(this)" placeholder="Keyword">
                <button class="btn btn-primary input-group-btn btn-lg" id="btn-search" style="height: 2.5rem;"><i class="icon icon-search"></i></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function doSearch() {
        showBtnLoading('#btn-search');
        var key = document.getElementById('search-keyy').value;
        console.log(key);
        if (key != '' && key.length > 1) {
            setTimeout(function(){ updateTableOnSearch(key); }, 1000);
            
        } else {
            fetchData();
            hideBtnLoading('#btn-search');
        }
    }




    function updateTableOnSearch(key) {
        $.ajax({
            url: '<?php echo base_url(); ?>/ajax/' + key,
            type: "POST",
            dataType: "JSON",
            headers: {
                "Authorization": "Bearer " + getCookie("token")
            },
            error: function(xhr, status, error) {
                if (xhr.status == 401) {
                    console.log("UNAUTHORIZED");
                    logout();
                }
                hideBtnLoading('#btn-search');
            },
            success: function(data) {
                hideFeedsTable();
                var products = data['products'];
                table.setData(products);
                hideBtnLoading('#btn-search');
            }
        });
    }
</script>