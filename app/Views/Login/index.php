<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>



<div class="container" style="margin: 20vh auto;">
    <div class="columns">
        <div class="column col-4  hide-md col-lg-3"></div>
        <div class="column col-3 col-md-12 col-lg-6">
          <div class="card">
              <div class="card-image">
                <!-- <img src="img/osx-el-capitan.jpg" class="img-responsive"> -->
            </div>
            <div class="card-header">
                <div class="card-title h3 text-center">Login</div>
                <div class="card-subtitle text-dark text-bold text-center">Farm Management System</div>
            </div>
            <div class="card-body">
                <form id="login-frm">
                <div class="form-group" id="email-login">
                  <label class="form-label" for="input-username">Username</label>
                  <input class="form-input input-lg" type="text" id="input-username" name = "email" placeholder="Username">
                  <div class="form-input-hint " id="email-fail-msg"></div>
              </div>
              <div class="form-group" id="pass-login">
                  <label class="form-label" for="input-password">Password</label>
                  <input class="form-input input-lg" type="password" id="input-password" name="password" placeholder="Password">
                  <div class="form-input-hint " id="pass-fail-msg"></div>
              </div>
              <br>
              <div class="columns">
                 
                   <div class="column col-4 col-md-8 col-sm-12 col-mr-auto col-ml-auto" ><a href="javascript:login()" class="btn btn-primary btn-lg" id="login-btn" style=" width:100%; border-radius: 5px;">Login</a></div>
              </div>

                </form>
          </div>
          <div class="card-footer">
           <div class=" text-center p-2" id="auth-fail-msg"></div>
        </div>
    </div>

</div>
<div class="column col-4 hide-md col-lg-3"></div>

</div>

</div>


<script type="text/javascript">



function login(){
    $('#auth-fail-msg').removeClass('bg-error');
    $('#auth-fail-msg').text('');
	showBtnLoading('#login-btn');
    disableBtn('#login-btn');
    $.ajax({
        url:'<?php echo base_url();?>/login',
        type:'POST',
        data:frmToJSON('#login-frm'),
        dataType: 'JSON',
        contentType: 'application/json',
        error: function(xhr, status, error){
            removeLoginErrorField();//lear error messages
            if(xhr.status != 500){
            var res = xhr.responseJSON;
            updateLoginErrorField(res['messages']);
            }else{
                alert('Server Failure. Check Database')
            }
            hideBtnLoading('#login-btn'); // remove loading Button
            enableBtn('#login-btn'); // reenable Button
        },
        success: function(response){
            console.log("success");
            removeLoginErrorField(); // clear error messages
            setCookie("token", response.token, 1); // set JWT token on TOKEN COOKIE
            hideBtnLoading('#login-btn'); // remove loading Button
            enableBtn('#login-btn'); // reenable Button
            $('#auth-fail-msg').addClass('bg-success'); // green success
            $('#auth-fail-msg').text(response['message']); // success message
            setTimeout(function(){window.location.replace(response.redirect);},3000);
        }
    })
}

    function updateLoginErrorField(arrError) {
            if ('email' in arrError) {
                $('#email-login').addClass('has-error');
                $('#email-fail-msg').text(arrError['email']);
            }
            if ('password' in arrError) {
                $('#pass-login').addClass('has-error');
                $('#pass-fail-msg').text(arrError['password']);
            }
            if ('error' in arrError) {
                $('#auth-fail-msg').addClass('bg-error');
                $('#auth-fail-msg').text(arrError['error']);
            }
        }

        function removeLoginErrorField() {
            $('#email-login').removeClass('has-error');
            $('#pass-login').removeClass('has-error');
            $('#pass-fail-msg').text('');
            $('#email-fail-msg').text('');
        }
</script>



<?= $this->endSection() ?>