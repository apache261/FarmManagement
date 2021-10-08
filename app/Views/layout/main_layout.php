<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title><?= $title ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="<?php echo base_url() ?>/css/spectre.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>/css/spectre-icons.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>/css/semantic.min.css">
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>/css/alertify.min.css">

	<script type="text/javascript" src="<?php echo base_url();?>/js/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>/js/jquery.serializejson.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>/js/alertify.min.js"></script>
	

	<link href="<?php echo base_url(); ?>/css/tabulator.css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url();?>/js/tabulator.min.js"></script>
</head>

<body>
	
	<script type="text/javascript">
		function frmToJSON(id) {
			var obj = $(id).serializeJSON();
			var jsonString = JSON.stringify(obj);
			return jsonString;
		}

		function popError(message) {
			alertify.set('notifier', 'position', 'top-center');
			alertify.error(message);
		}
		function popWarn(message) {
			alertify.set('notifier', 'position', 'top-center');
			alertify.warning(message);
		}

		function popSuccess(message) {
			alertify.set('notifier', 'position', 'top-center');
			alertify.success(message);
		}

		function showModal(id) {
			id.classList.add('active');
		}

		function hideModal(id) {
			id.classList.remove('active');
		}
		function showItem(id) {
			id.classList.remove('d-hide');
		}

		function hideItem(id) {
			id.classList.add('d-hide');
		}

		function showBtnLoading(id) {
			$(id).addClass("loading");
		}

		function hideBtnLoading(id) {
			$(id).removeClass("loading");
		}

		function disableBtn(id) {
			$(id).addClass('disabled');
		}

		function enableBtn(id) {
			$(id).removeClass('disabled');
		}

		function resetForm(id) {
			document.getElementById(id).reset();
		}

		function resetForm1(id) {
			$(id).trigger("reset");
		}

		function logout() {
			$.ajax({
				url: '<?php echo base_url(); ?>/logout',
				type: 'POST',
				dataType: 'JSON',
				error: function(xhr, status, error) {
					popError("Error Occured");
				},
				success: function(response) {
					setCookie("token", response.token, 1);
					popError("You have been Logout");
					setTimeout(function(){window.location.replace('<?php echo base_url();?>/login')}, 1000);
				}
			})
		}

		function confirmLogout(){
			alertify.confirm('Confirm Logout', 'Do you want to Logout?', function(){ logout(); }
                , function(){});
		}

		function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
			var expires = "expires=" + d.toUTCString();
			document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
		}
		function getCookie(cname){
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' '){
				c = c.substring(1);
			}

			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}
	</script>
	<?= $this->renderSection('content') ?>

</body>

</html>