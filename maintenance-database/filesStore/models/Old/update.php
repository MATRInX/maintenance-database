<?php
	$query = "SELECT `id` FROM `przynaleznosc` WHERE `opis` = '".$arr1[$i]."'";
	$res = mysql_query($query);
	$id_przyn = mysql_fetch_array($res)[0];
	
	$query = "UPDATE `maszyny` SET `id_przynaleznosc` = '".$id_przyn."' WHERE `NR_4D` = '".$arr2[$i]."'";
	mysql_query($query);

?>