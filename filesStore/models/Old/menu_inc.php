<?php
//dispTab($_SESSION);
if (ChkUsr("pb")) echo '<li class="menuReports"><a href="?pid=1">Raporty</a></li>';
//if (ChkUsr("zn")) echo '<li><a href="?pid=4">Przeglądy</a></li>';
if (ChkUsr("zn")) echo '<li class="menuAddBreakdown"><a href="?pid=2">Dodaj zgłoszenie</a></li>';
if (ChkUsr("ad")) echo '<li class="menuAdministration"><a href="#" id="menuAdm">Administracja</a>					
						<!--div id="submenuAdm"-->
                        
                        <ul>
						<li><a href="?pid=10">Użytkownicy</a></li>
						<li><a href="?pid=11">Maszyny</a></li>
						<li><a href="?pid=14">Typ Pracy</a></li>
						<li><a href="?pid=15">Lokalizacja</a></li>
						<li><a href="?pid=12">Lista przyczyn awarii</a></li>
						<li><a href="?pid=13">Archiwizacja BD </a></li>
						<li><a href="?pid=32">Historia zalogowania </a></li>
                                                <li><a href="http://bazaurnew/phpmyadmin/index.php?db=tenmaint">mysql</a></li>
                        </ul>
                        </li>
						<!--/div-->
						';

echo '<li class="menuTPM"><a href="#" id="menuTPM">TPM 2</a>
    
    <ul>
	<!--div id="submenuTPM"-->';

	if (ChkUsr("tpmAd")) echo '<li><a href="?pid=50">Nowy szablon TPM</a></li>';
	if (ChkUsr("tpmAd")) echo '<li><a href="?pid=51">Pokaż wszystkie szablony</a></li>';
	if (ChkUsr("tpmAd")) echo '<li><a href="?pid=100">Archiwum przeglądów</a></li>';
	if (ChkUsr("zn")) echo '<li><a href="?pid=52">Pokaż wszystkie przeglądy</a></li>';	
	if (ChkUsr("tpmZl")) echo '<li><a href="?pid=70">Pokaż moje szablony</a></li>';
	if (ChkUsr("tpmPr")) echo '<li><a href="?pid=90">Pokaż przeglądy do wykonania</a></li>';
	if (ChkUsr("tpmAd")) echo '<li><a href="?pid=101">Pokaż przeglądy zaplanowane</a></li>';
	if (ChkUsr("tpmAd")) echo '<li><a href="?pid=102">Pokaż usunięte szablony</a></li>';

echo '</ul></li>';
echo '<!--/div-->';

if (ChkUsr("ana")) echo '<li class="menuAnalysys"><a href="#" id="menuAna">Analizy</a>
						<!--div id="submenuAna"-->
                        
                        <ul>
							<li><a href="?pid=17&action=dost">Dostępność</a></li>
							<li><a href="?pid=17&action=mttf">MTTF</a></li>
						</ul>
                        </li>
						<!--/div-->
						';						
//<li><a href="?pid=17&action=ust">Ustawienia</a></li>
//if (ChkUsr("zn")) echo '<li><a href="?pid=3">Maszyna</a></li>';		
//if (ChkUsr("zn")) echo '<li><a href="?pid=999">konwersja tablicy awarie</a></li>';					
//if (ChkUsr("ad")) {
//echo'<div id="powiadomienia">
//<h1>POWIADOMIENIA</h1>';
//$dane=sql("SELECT * 
//		FROM `przyczyna wzor`
//		WHERE `DODAC` LIKE 1
//		");
//
//if (mysql_fetch_array($dane)) echo '<b>Dodano nową propozycję przyczyny awarii.</b><br/>';
//
//echo'</div>';
//}
?>
<style>
#powiadomienia{
padding-top: 10px;
}
#submenuAdm{
padding-left: 10px;
}
#submenuAna{
padding-left: 10px;
}
#submenuTPM{
padding-left: 10px;
}
</style>
<script>
<?php //if (ChkUsr("ad")) echo 'new MenuSlider (\'menuAdm\', \'submenuAdm\');'; ?>
<?php //if (ChkUsr("ana")) echo 'new MenuSlider (\'menuAna\', \'submenuAna\');'; ?>
<?php //echo 'new MenuSlider (\'menuTPM\', \'submenuTPM\');';?>
</script>
