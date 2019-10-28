<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html ng-app="maintDatabaseApp">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<script type="text/javascript" src="inc/js/mootools.js"></script>
		<script type="text/javascript" src="inc/js/function.js"></script>
	
		<link rel="stylesheet" href="css/strona.css" type="text/css" />	
        <link href="inc/bootstrap/bootstrap.css" rel="stylesheet" />
        <link href="inc/bootstrap/bootstrap-theme.css" rel="stylesheet" />
        <link href="inc/content/css/style.css" rel="stylesheet" />
        <link href="inc/content/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
                    
        <script src="inc/angularjs/angular.js" type="text/javascript"></script>
<!--        <script src="inc/bootstrap/bootstrap.js" type="text/javascript"></script>-->
        <script src="inc/content/js/ui-bootstrap-tpls-2.0.0.js" type="text/javascript"></script>
        
        <script src="app.module.js" type="text/javascript"></script>
        <script src="inc/controllers/main.controller.js" type="text/javascript"></script>

	<title>Baza danych UR</title>	
	</head>
	<body ng-controller="mainCtrl">
	<div id="wrap">

		<div id="header">			
			<span id="slogan">Baza danych MAINTENANCE G +</span>								
		</div>
	<?php
	$dane=sql("SELECT ip_komputera, data_logowania FROM historia_logowania  WHERE id_usr LIKE ".$_SESSION['dane_uzytkownika']['ID_UsrDat']."  ORDER BY data_logowania DESC LIMIT 1");
    $row = mysql_fetch_array($dane,MYSQL_ASSOC);
	
	?>	
		
	
	<div id="header-logo">
	<!-- <span class="red">Automotive</span> -->
<!--	<span id="logo"><span class="greengreen">MAINTENANCE GLIWICE + </span></span>-->
    <div class="menuContainer">            
        <ul class="mainList">
            <?php include('menu_inc.php');?>
        </ul>
    </div>
	<span class="zalogowany">Zalogowany jako: <?php echo $_SESSION['dane_uzytkownika']['UsrNazw'].' '.$_SESSION['dane_uzytkownika']['UsrImie']?> | <a href="?pid=33">zmiana hasła </a>| <a href="login.php?logout=1">wyloguj</a><br/>
	Ostatnie logowanie:  <?php echo $row['data_logowania'].' z '.$row['ip_komputera'];?>
	</span>
	</div>
<!--
    <div id="sidebar floatFix">							
		<span class="menuName">Menu</span>
        <div class="menuContainer">            
            <ul class="mainList">
                <?php //include('menu_inc.php');?>
            </ul>
        </div>	
    </div>
-->
	<div id="main">
		<?php 
		    if (isset($_GET['pid'])){ 
				if($_GET['pid'] == 'a'){
				
				}else{
					include('inc/forms/'.$_GET['pid'].'_zap.php');
				}
			}else{
			if (ChkUsr("tpmPr")){
		echo "<script  type=\"text/javascript\">
		var UserForm = new StickyWin.Ajax({
		url: 'inc/forms/powiadomienie_przeglad.php?id=".$_SESSION['dane_uzytkownika']['ID_UsrDat']."',
		wrapWithUi: true,
		caption: 'Powiadomienie o przeglądach',
		destroyOnClose: true,
		draggable: true,
		uiOptions:{
			width: '400px',
			buttons: [{
			text: 'OK',
			onClick: function(){
				window.location.href='aplikacja.php?pid=a'
			}
			}]}
		}).update();
	
	</script>";}
			}
			//dispTab($_SESSION);
		?>
	</div>			
				
    <!-- wrap ends here -->
	</div>

	<div class="footer">
	
		<p>	
		© 2017 <strong>Tenneco Gliwice</strong> &#160;&#160;	
		
	
		</p>
		
	</div>	
	<div id="informator" class="ajax-loading_inf">
	<center>
	<div>Proszę czekać!<br/>Trwa generowanie raportu ...</div>
	</center>
	</div>
	</body>
</html>