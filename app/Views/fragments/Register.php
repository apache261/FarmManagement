<div class="modal " id="adNewUser">
    <a href="javascipt:void()" class="modal-overlay" aria-label="Close"></a>
    <div class="modal-container">
        <div class="modal-header ">
            <a href="javascript:hideRegisterModal()" class="btn btn-clear btn-error float-right" aria-label="Close"></a>
            <div class="modal-title h5 text-center" id="title-new-user">New User</div>
        </div>
        <div class="modal-body ">

            <div class="content">
                <form id="user-frm">
                    <div class="columns">

                        <div class="column col-6 col-md-12">
                            <!-- Email -->
                            <div class="form-group " id="frm-user-email">
                                <label class="form-label" for="user-email">Email</label>
                                <input class="form-input" type="text" id="user-email" name="email" placeholder="">
                                <div class="form-input-hint " id="email-user-msg"></div>
                            </div>
                        </div>
                        <div class="column col-6 col-md-12">
                            <!-- Pass -->
                            <div class="form-group" id="frm-user-pass">
                                <label class="form-label" for="user-pass">Password</label>
                                <input class="form-input" id="user-pass" name="password" type="password">
                                <div class="form-input-hint " id="pass-user-msg"></div>
                            </div>

                        </div>
                    </div>
                </form>
                <br />
                <div class="columns mt-2">
                    <div class="column col-3  hide-md"></div>
                    <div class="column col-3 col-md-12  " id="add-prod-btn"><a href="javascript:register()" class="btn btn-primary text-light btn-lg " id="user-btn-register" style="width: 100%;border-radius:10px;">ADD</a></div>
                    <div class="column col-1 col-md-12 mt-2 mb-2"></div>
                    <div class="column col-3 col-md-12  " id="add-prod-btn"><a href="javascript:hideAddFeedsModal()" id="feed-btn-cancel" class="btn btn-link text-light btn-lg text-dark" style="width: 100%;border-radius:10px; border:1px solid #000;">CANCEL</a></div>
                    <div class="column col-2  hide-md"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">

        </div>
    </div>
</div>
<script type="text/javascript">
    var modalRegister = document.getElementById('adNewUser');



    function showRegisterModal() {
        showModal(modalRegister);
    }

    function hideRegisterModal() {
        hideModal(modalRegister);
    }

    function updateRegisterErrorField(arrError) {
        if ('email' in arrError) {
            $('#frm-user-email').addClass('has-error');
            $('#email-user-msg').text(arrError['email']);
        }
        if ('password' in arrError) {
            $('#frm-user-pass').addClass('has-error');
            $('#pass-user-msg').text(arrError['password']);
        }
    }

    function removeRegisterErrorField() {
        $('#frm-user-email').removeClass('has-error');
        $('#frm-user-email').removeClass('has-error');
    }
    function register(){
        showBtnLoading('#user-btn-register');
        removeRegisterErrorField();
        $.ajax({
                url: '<?php echo base_url();?>/register',
                type: 'POST',
                dataType: 'JSON',
                contentType: 'application/json',
                data: frmToJSON('#user-frm'),
                headers: {
                    "Authorization": "Bearer " + getCookie("token")
                },
                error: function(xhr, status, error) {
                    hideBtnLoading('#user-btn-register');
                    var errData = xhr.responseJSON;
                  if(xhr.status == 201){
                    popSuccess("Success");
                    hideRegisterModal();
                    resetForm('#user-frm');
                  }else{
                    updateRegisterErrorField(errData['messages']);
                    if (xhr.status == 401) {
                        console.log("UNAUTHORIZED");
                        logout();
                    }
                }
                    

                },
                success: function(response) {
                    console.log('Success');
                    popSuccess("Success");
                    hideRegisterModal();
                    resetForm('#user-frm');
                    hideBtnLoading('#user-btn-register');
                }
            });
    }
</script>