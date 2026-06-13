<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Ansonika">
  <title><?php echo $title_page; ?></title>

	
  <!-- Favicons-->
  <link rel="shortcut icon" href="<?php echo base_url('/template/img/favicon.ico'); ?>" type="image/x-icon">
  <link rel="apple-touch-icon" type="image/x-icon" href="<?php echo base_url('/template/img/apple-touch-icon-57x57-precomposed.png'); ?>">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?php echo base_url('/template/img/apple-touch-icon-72x72-precomposed.png'); ?>">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo base_url('/template/img/apple-touch-icon-114x114-precomposed.png'); ?>">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo base_url('/template/img/apple-touch-icon-144x144-precomposed.png'); ?>">

  <!-- GOOGLE WEB FONT -->
  <link href="<?php echo base_url('/template_admin/css/fonts.googleapis.com_css_family=Poppins_300,400,500,600,700,800');?>" rel="stylesheet">
	
  <!-- Bootstrap core CSS-->
  <link href="<?php echo base_url('/template_admin/vendor/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('/template_admin/kartik/css/bootstrap-icons.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('/template_admin/adminlte/dist/css/adminlte.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('/template_admin/vendor/dist/css/adminlte.min.css');?>" rel="stylesheet">
  <!-- Main styles -->
  <link href="<?php echo base_url('/template_admin/css/admin.css');?>" rel="stylesheet">
  <!-- Icon fonts-->
  <link href="<?php echo base_url('/template_admin/vendor/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css">
  <!-- Plugin styles -->
  <link href="<?php echo base_url('/template_admin/vendor/datatables/dataTables.bootstrap4.css');?>" rel="stylesheet">
  <!-- Your custom styles -->
  <link href="<?php echo base_url('/template_admin/css/custom.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('/template/css/toastr.min.css');?>" rel="stylesheet">
	
  <!-- DATATABLES -->
  <link href="<?php echo base_url('/template_admin/vendor/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('/template_admin/vendor/datatables/datatables-responsive/css/responsive.bootstrap4.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('/template_admin/vendor/datatables/datatables-buttons/css/buttons.bootstrap4.min.css');?>" rel="stylesheet">
  <!--SELECT2-->
  <link href="<?php echo base_url('/template_admin/adminlte/plugins/select2/css/select2.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('/template_admin/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css');?>" rel="stylesheet">

  <!--ICHECK-->
  <link href="<?php echo base_url('/template_admin/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css');?>" rel="stylesheet">
  <!--SWITCH-->
  <link href="<?php echo base_url('/template_admin/adminlte/plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css');?>" rel="stylesheet">
  <!--BS4 TOGGLE-->
  <link href="<?php echo base_url('/template_admin/vendor/bootstrap4-toggle/css/bootstrap4-toggle.min.css');?>" rel="stylesheet">
  <!-- summernote -->
  <link href="<?php echo base_url('/template_admin/adminlte/plugins/summernote/summernote-bs4.min.css');?>" rel="stylesheet">

  <link href="<?php echo base_url('/template_admin/kartik/css/fileinput.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('/template_admin/kartik/css/fileinput-rtl.min.css');?>" rel="stylesheet">
  
  
  <style>
    thead,tfoot {
    background: #aa1916;
    color: white;
}
.select2-selection__choice{
  background: #aa1916 !important;
  color: white !important;
}
@media (min-width: 992px) {
    body.sidenav-toggled .content-wrapper {
        margin-left: 55px !important;
    }
}
carousel-indicators li {
  background-color: red !important;}

  .table td, .table th {
    padding: 4px !important; 
    vertical-align:middle !important;}

    .form-control {
      padding: 4px !important; 
    height: calc(1.8rem + 2px) !important; }

  </style>
  <?php if(isset($css) && $css):
		echo $css;
	endif;?>