<!DOCTYPE html>
<html lang="es">

<head>
<?php include APPPATH . "views/template_admin/header.php"; ?>  

</head>

<body class="fixed-nav sticky-footer" id="page-top">
		
	
	<?php include APPPATH . "views/template_admin/sidebar.php"; ?>  
	<div class="content-wrapper">
	<div class="container-fluid">
		<?php include APPPATH . "views/".$view.".php"; ?> 

		<div class="modal fade" id="modal-visualizar_documento">
					<div class="modal-dialog modal-xl">
						<div class="modal-content bg-secondary">
							<div class="modal-header btn-danger">
								<h6 class="modal-title text-white">Visualizar Documento</h6>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body" id="modalbody-visualizar_documento">

							</div>
							<div class="modal-footer btn-danger">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>

	</div>		
		
	<footer class="sticky-footer">
	<?php include APPPATH . "views/template_admin/footer.php"; ?>  
	</footer>
	<!--/footer-->
	</div>
	<!-- page -->
	
	<!-- COMMON SCRIPTS -->
	
     <!-- Bootstrap core JavaScript-->
	 <script src="<?php echo base_url('/template_admin/vendor/jquery/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('/template_admin/vendor/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
	
    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('/template_admin/vendor/jquery-easing/jquery.easing.min.js');?>"></script>
    <!-- Page level plugin JavaScript-->
    <script src="<?php echo base_url('/template_admin/vendor/chart.js/Chart.js');?>"></script>
    <script src="<?php echo base_url('/template_admin/vendor/datatables/jquery.dataTables.js');?>"></script>
    <script src="<?php echo base_url('/template_admin/vendor/datatables/dataTables.bootstrap4.js');?>"></script>
	<script src="<?php echo base_url('/template_admin/vendor/jquery.selectbox-0.2.js');?>"></script>
	<script src="<?php echo base_url('/template_admin/vendor/retina-replace.min.js');?>"></script>
	<script src="<?php echo base_url('/template_admin/vendor/jquery.magnific-popup.min.js');?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('/template_admin/js/admin.js');?>"></script>
	<script src="<?php echo base_url('/template_admin/vendor/dist/js/adminlte.min.js');?>"></script>
	<script src="<?php echo base_url('/template_admin/adminlte/dist/js/adminlte.min.js');?>"></script>
	<!-- Custom scripts for this page-->
    <script src="<?php echo base_url('/template_admin/js/admin-charts.js');?>"></script>
	<script src="<?php echo base_url('/template/js/toastr.min.js'); ?>"></script>
	<!-- DATATABLES -->
	<script src="<?php echo base_url('template_admin/js/datatable.js'); ?>"></script>
	<script src="<?php echo base_url('template_admin/vendor/datatables/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
	<script src="<?php echo base_url('template_admin/vendor/datatables/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
	<script src="<?php echo base_url('template_admin/vendor/datatables/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
	<script src="<?php echo base_url('template_admin/vendor/datatables/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
	<script src="<?php echo base_url('template_admin/vendor/datatables/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
	<script src="<?php echo base_url('template_admin/vendor/jszip/jszip.min.js'); ?>"></script>
	<script src="<?php echo base_url('template_admin/vendor/pdfmake/pdfmake.min.js'); ?>"></script>
	<script src="<?php echo base_url('template_admin/vendor/pdfmake/vfs_fonts.js'); ?>"></script>
	<script src="<?php echo base_url('template_admin/vendor/datatables/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
	<script src="<?php echo base_url('template_admin/vendor/datatables/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
	<!--SELECT2-->
	<script src="<?php echo base_url('template_admin/adminlte/plugins/select2/js/select2.full.min.js'); ?>"></script>
	<!--SWITCH-->
	<script src="<?php echo base_url('template_admin/adminlte/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>"></script>
	<!--BS4 TOGGLE-->
	<script src="<?php echo base_url('/template_admin/vendor/bootstrap4-toggle/js/bootstrap4-toggle.min.js');?>"></script>
	<!--bs-custom-file-input-->	
	<script src="<?php echo base_url('/template_admin/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js');?>"></script>
	<script src="<?php echo base_url('/template_admin/kartik/js/plugins/buffer.min.js');?>"></script>
	<script src="<?php echo base_url('/template_admin/kartik/js/plugins/filetype.min.js');?>"></script>
	<script src="<?php echo base_url('/template_admin/kartik/js/plugins/piexif.min.js');?>"></script>
	<script src="<?php echo base_url('/template_admin/kartik/js/plugins/sortable.min.js');?>"></script>
	<script src="<?php echo base_url('/template_admin/kartik/js/fileinput.min.js');?>"></script>
	<script src="<?php echo base_url('/template_admin/kartik/js/locales/LANG.js');?>"></script>
	<!-- Summernote -->
	<script src="<?php echo base_url('/template_admin/adminlte/plugins/summernote/summernote-bs4.min.js');?>"></script>

	<script src="<?php echo base_url('/template_admin/js/verarchivo.js');?>"></script>


	<script>
  $(function () {
    //Initialize Select2 Elements
    $('#responsable').select2({
      dropdownParent: $('.modal-responsable')
    });

	bsCustomFileInput.init();

	//$("#input-id").fileinput();
	//$("#input-id").fileinput({'showUpload':false, 'previewFileType':'any'});
	$("#url_respuesta").fileinput({
    language: "es",
    allowedFileExtensions: ["jpg", "png", "gif","pdf","doc","docx"],
    browseLabel: "Cargar ..."
});
	
  })

  
 
  </script>
	<?php if(isset($js) && $js):
		echo $js;
	endif;?>
	<!-- Modal -->
</body>
</html>