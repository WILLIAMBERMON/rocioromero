<!DOCTYPE html>
<html lang="es">

<head>
<?php include APPPATH . "views/template/header.php"; ?>  

</head>

<body>
		
	<div id="page">
	<?php include APPPATH . "views/template/sidebar.php"; ?>  
	
	<!-- /header -->
	
	<main id="viewcont">
		<?php include APPPATH . "views/".$view.".php"; ?> 
		
	</main>
	<!-- /main -->

	<footer>
	<?php include APPPATH . "views/template/footer.php"; ?>  
	</footer>
	<!--/footer-->
	</div>
	<!-- page -->
	
	<!-- COMMON SCRIPTS -->
	
    
	<script src="<?php echo base_url('/template/js/jquery-3.7.0.min.js'); ?>"></script>
	<script src="<?php echo base_url('/template/js/popper.min.js'); ?>"></script>
	<script src="<?php echo base_url('/template/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('/template/js/common_scripts.js'); ?>"></script>
    <script src="<?php echo base_url('/template/js/main.js'); ?>"></script>
	<script src="<?php echo base_url('/template/js/toastr.min.js'); ?>"></script>
	<script src="<?php echo base_url('/template/assets/validate.js'); ?>"></script>
	
	
	<?php if(isset($js) && $js):
		echo $js;
	endif;?>
	<!-- Modal -->
	<div id="modaltemplate"></div>
	<script>
			
	function openmodal(modal){
		$('body').removeClass('modal-open');
  	var idmodal = modal.getAttribute("data-bs-target").substring(1);
  $('.modal-backdrop').remove();
  
 setTimeout(function(){
    $("#"+idmodal).modal('toggle');
}, 500);
		var clase=$('#'+idmodal).attr('class');
		var newllave = newllavew();
		var contentmodal = $('#'+idmodal).html();
		//contentmodal.replace(idmodal, newllave);
		$('#modaltemplate').html('<div class="'+clase+'" id="'+newllave+'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">'+contentmodal+'</div>');
		$('#'+newllave).modal();
		$('#'+newllave).modal('show');
		
	}

	function newllavew(){
		var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHJKMNPQRTUVWXYZ2346789";
	var contraseña = "";
	for (i=0; i<10; i++) contraseña +=caracteres.charAt(Math.floor(Math.random()*caracteres.length)); 
	return contraseña;
	}

	</script>
</body>
</html>