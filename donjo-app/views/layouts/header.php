<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Website Desa <?php echo unpenetration($desa['nama_desa']);?></title>

    <!-- Bootstrap -->
    <!--<link href="css/bootstrap.min.css" rel="stylesheet"> -->
<!--
	<link rel="stylesheet" href="<?php echo base_url()?>assets/bs/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/bs/css/style.css"> 
-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- Original -->
		<link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" />
		<link type='text/css' href="<?php echo base_url()?>assets/front/css/first.css" rel='Stylesheet' /> 
		<link type='text/css' href="<?php echo base_url()?>assets/css/font-awesome.min.css" rel='Stylesheet' />
		<link type='text/css' href="<?php echo base_url()?>assets/css/ui-buttons.css" rel='Stylesheet' />
		<link type='text/css' href="<?php echo base_url()?>assets/front/css/colorbox.css" rel='Stylesheet' />

		<script src="<?php echo base_url()?>assets/front/js/stscode.js"></script>
		<script src="<?php echo base_url()?>assets/front/js/jquery.js"></script>
		<script src="<?php echo base_url()?>assets/front/js/layout.js"></script>
		<script src="<?php echo base_url()?>assets/front/js/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				$(".group2").colorbox({rel:'group2', transition:"fade"});
				$(".group3").colorbox({rel:'group3', transition:"fade"});
			});
		</script>	
	</head>
		<div id="maincontainer">
			<div id="topsection">
				<div class="innertube">
					<div id="header">
						<div id="headercontent">
							<div id="menu_vert">
								<div id="menuwrapper">
									<?php $this->load->view('partials/menu.tpl.php');?>
								</div>
							</div>
							<div id="menu_vert2">
								<?php if(count($slide)>0){
									$this->load->view('layouts/slide.php');
								} ?>
							</div>
						</div>
					</div>
					<div id="headleft">
						<div id="divlogo">
							<div id="divlogo-txt">
								<div class="intube">
									<div id="siteTitle">
										<h1><?php echo unpenetration($desa['nama_desa'])?></h1>
										<h2>Kecamatan <?php echo unpenetration($desa['nama_kecamatan'])?><br />
										Kab/Kota <?php echo unpenetration($desa['nama_kabupaten'])?></h2>
										<h3><?php echo unpenetration($desa['alamat_kantor'])?></h3>
									</div>
								</div>
							</div>
						</div>
						<div id="divlogo-img">
							<div class="intube">
								<a href="<?php echo site_url(); ?>first/">
								<img src="<?php echo base_url()?>assets/files/logo/<?php echo $desa['logo']?>" alt="<?php echo $desa['nama_desa']?>"/>
								</a>
							</div>
						</div>
						<br class="clearboth"/>
					</div>
					
					<?php if(count($teks_berjalan)>0){
						$this->load->view('layouts/teks_berjalan.php');
					} ?>
						
					<div id="mainmenu">
						<?php $this->load->view('partials/menu.left.php');?>
					</div>
					
				</div>
			</div>