<!DOCTYPE html>
<html lang="id">

	<head>
		<title>Sistem Informasi Desa (SID)</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico">
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo base_url()?>rss.xml">
		<link href="<?php echo base_url()?>assets/css/screen.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/style2.css">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/noJS.css">
		<script src="<?php echo base_url()?>assets/js/jquery-1.5.2.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/jquery-ui-1.8.16.custom.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/jquery.formtips.1.2.2.packed.js"></script>
		<script src="<?php echo base_url()?>assets/js/jquery.tipsy.js"></script>
		<script src="<?php echo base_url()?>assets/js/jquery.elastic.js"></script>
		<script src="<?php echo base_url()?>assets/js/jquery.flexbox.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/jquery.easing-1.3.pack.js"></script>
		<script src="<?php echo base_url()?>assets/js/donjoscript/donjoscript2.js"></script>
		<script src="<?php echo base_url()?>assets/js/donjoscript/donjo.ui.dialog.js"></script>
	<style>
	body{
	 background: url(<?php echo base_url()?>assets/files/bg.jpg) no-repeat center center fixed;
	 -webkit-background-size: cover;
	 -moz-background-size: cover;
	 -o-background-size: cover;
	 background-size: cover;
		margin:0px;
		padding:0px;
	}
	#full{
		background: #ccccff repeat-x;
		text-align:center;
		margin:150px 0px 0px 0px;
		padding:10px;
box-shadow:0px 0px 15px #777;
-moz-box-shadow:0px 0px 15px #777;
-webkit-box-shadow:0px 0px 15px #777;
	}
	</style>
	</head>
<body>
<script>
	$(function(){
	<?php if($pass != NULL){ ?>
		modalpin('pin','PENTING! Informasi Username dan Password.','Silakan catat/ingat username dan password ini sebelum login. Username dan password ini hanya akan tampil sekali di tahap instalasi aplikasi SID untuk alasan keamanan. <br>Setelah berhasil masuk aplikasi harap untuk segera mengganti Password yang sekiranya mudah diingat.<br>Username dan password dapat diganti setelah Anda berhasil login ke aplikasi SID.<table class="list"><td width="150">Username</td><td width="5"> : </td><td>admin</td></tr><tr><td>Pssword</td><td width="5"> : </td><td><?php echo $pass; ?></td></tr></table>');
	<?php }?>

	function modalpin(id,title,message,width,height){
	 if (width==null || height==null){
		width='500';
		height='auto';
	 }
	 $('#'+id+'').remove();
	 $('body').append('<div id="'+id+'" title="'+title+'" style="display:none;">'+message+'</div>');
			$('#'+id+'').dialog({
				resizable: false,
				draggable: true,
		 width:width,
		 height:height,
		 autoOpen: true,
			modal: true,
		 dragStart: function(event, ui) {
			$(this).parent().addClass('drag');
		 },
		 dragStop: function(event, ui) {
			$(this).parent().removeClass('drag');
		 }
		});
	 $('#'+id+'').dialog('open');
	 }
	});
</script>
<div id="full">
<h1>BERHASIL!<h1>
<h2>Anda baru saja menginstall aplikasi SID <?= VERSI_SID ?> dengan lancar.<h2>
<a href ="<?php echo site_url();?>siteman" class="uibutton special">Mulai SID </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
</body>
</html>
<?php exec('c:\sid-combine\ncmd.exe speak text "Installation Successed" -5 100');?>
