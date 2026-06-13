    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Udema a modern educational site template">
    <meta name="author" content="Ansonika">
    <title><?php echo $title_page; ?></title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="<?php echo base_url('/template/img/favicon.ico'); ?>" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="<?php echo base_url('/template/img/apple-touch-icon-57x57-precomposed.png'); ?>">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?php echo base_url('/template/img/apple-touch-icon-72x72-precomposed.png'); ?>">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo base_url('/template/img/apple-touch-icon-114x114-precomposed.png'); ?>">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo base_url('/template/img/apple-touch-icon-144x144-precomposed.png'); ?>">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    
    <link href="<?php echo base_url('/template/css/style.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('/template/css/vendors.css');?>" rel="stylesheet">
    
	<link href="<?php echo base_url('/template/css/icon_fonts/css/all_icons.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('/template/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('/template/css/toastr.min.css');?>" rel="stylesheet">
    <!-- YOUR CUSTOM CSS -->
    <link href="<?php echo base_url('/template/css/custom.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('/template/css/blog.css');?>" rel="stylesheet">
    <?php if(isset($css) && $css):
		echo $css;
	endif;?>

    