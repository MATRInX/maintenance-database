<?php
function get_by_id($tab, $con){
	
	$query = "SELECT * FROM ".$tab." WHERE ".$con;
	$res = mysql_query($query);
	
  if (!($res)) {
			return null;
	}
	$array = array();
	while ($row = mysql_fetch_object( $res )) {	
					$array[] = $row;
	}
	mysql_free_result( $res );
	return $array[0];
	

}
function koduj($string)
{
	return urlencode($string);
}

function dekoduj($string)
{
    return stripslashes(urldecode($string));
}

/*
function koduj ($str) {
    return base64_encode($str);
    }

function dekoduj ($str) {
    return base64_decode($str);
    }

*/
   function do_utf($text){
	  $wyszukaj = array("Ą","ą","Ć","ć","Ę","ę","Ł","ł","Ń","ń","Ó","ó","Ś","ś","Ź","ź","Ź","ż");
      $zastąp = array("&#260;","&#261;","&#262;","&#263;","&#280;","&#281;","&#321;","&#322;","&#323;","&#324;","&#211;","&#243;","&#346;","&#347;","&#377;","&#378;","&#379;","&#380;");  
      return str_replace($wyszukaj,$zastąp,$text);
	}
function ShowLogin($komunikat=""){
	echo '<div style="width:350px;padding:10px;margin:auto;"><h1>Logowanie</h1>';
	echo $komunikat.'<br>';
	echo "<form action='login.php' method=post id='logowanie' style='text-align:center'>";
	echo "Login: <input type=text name=login class='required input_normal validate-alpha'><br>";
	echo "Hasło: <input type=password name=haslo class='required input_normal'><br>";
	echo "<center style='margin-top:5px;'><input type=submit value='Zaloguj!'></center>";
	echo "</form>";
	echo "<script>new FormValidator.Inline('logowanie');</script>"; // walidacja formularza mootools
	echo '<div style="text-align:center">Jeśli nie jesteś zarejestrowany,<br/> zgłoś się do administratora.</div>
	</div>';
}

function ChkUsr ($Need){
	$test = explode(".", $_SESSION['dane_uzytkownika']['UsrRights']);
    foreach($test as $Ind1=>$Val1){
		if ($Need==$Val1){
			return TRUE;	
		}
	}
	return FALSE;
}

function ChkUsrUpr ($Need, $Upr){
	$test = explode(".", $Upr);
    foreach($test as $Ind1=>$Val1){
		if ($Need==$Val1){
			return TRUE;	
		}
	}
	return FALSE;
}


function utworz_option($zapytanie,$wybierz,$wartosc=-1){
	if ($wybierz == 1){
		$wynik = '<option selected value="wybierz">Wybierz opcję</option>';
	}else{
		$wynik = '';
	}
	$res = sql($zapytanie);
	while($row = mysql_fetch_array($res, MYSQL_NUM)){
		$wynik .='<option value="'.$row[0].'"';
		if ($row[0] == $wartosc) $wynik .=' selected ';
		$wynik .='>'.$row[1].'</option>';
	}
	
	return $wynik;
}

function createOptionSelShiftNum(){    
    $shiftNumber = getShiftNumber();    
    $optionHTMLcode =  '<option selected value="wybierz">Wybierz opcję</option>';
    $shifts = getShiftNamesAndNumbers();   
    $shiftsArrayLength = 3;
    $SHIFT_NUMBER = 0;
    $SHIFT_NAME = 1;
    for($i = 0; $i<$shiftsArrayLength; $i++){
        $optionValue = $i+1;
        $optionHTMLcode .= '<option value='
                        .$optionValue.($shiftNumber == $shifts[$i][$SHIFT_NUMBER] ? ' selected': '').'> '
                        .$shifts[$i][$SHIFT_NAME].'</option>';
    }
    return $optionHTMLcode;
}

function getShiftNumber(){
    $actualHour = date("H");
    $hourToCompare = intval($actualHour);
    $shiftNumber = shiftHourCheck($hourToCompare);
    return $shiftNumber;
}

function shiftHourCheck($hourToCheck){
    if(($hourToCheck>= 6) && ($hourToCheck< 14))
        return 1;
    else if(($hourToCheck>= 14) && ($hourToCheck< 22))
        return 2;
    else if(($hourToCheck>= 22) || ($hourToCheck< 6))
        return 3;
    else return 0;
}

function getShiftNamesAndNumbers(){
    $MySQKquery = "SELECT * FROM `zmiana`";
    // Get data about shifts from database
    $res = sql($MySQKquery);
    $mainArrayIndex = 0;
    while($row = mysql_fetch_array($res, MYSQL_NUM)){
        $shiftArray[$mainArrayIndex][0] = $row[0];
        $shiftArray[$mainArrayIndex][1] = $row[1];
        $mainArrayIndex++;
	}
    return $shiftArray;
}

function showPHPAlert($textToShowInAlert){
    echo '<script language="javascript">';
    echo 'alert("'.$textToShowInAlert.'")';
    echo '</script>';
}

function utworz_option_sel($zapytanie,$wybierz,$selected=null){
	
		if ($wybierz == 1){
			$wynik = '<option value="wybierz">Wybierz opcję</option>';
		}else{
			$wynik = '';
		}
	
	$res = sql($zapytanie);
	while($row = mysql_fetch_array($res, MYSQL_NUM)){
		$wynik .='<option value="'.$row[0].'"';
		if ($row[0] == $selected){
			$wynik .=' selected="selected" ';
			}
		$wynik .='>'.$row[1].'</option>';
	}
	
	return $wynik;
}

function utworz_checkbox($zapytanie, $nazwa, $check = false){
	$res = sql($zapytanie);
	$wynik = '';
	while ($row = mysql_fetch_array($res, MYSQL_NUM)){
		//dispTab($row);
		$checked = $check==true?"checked":"";
		$wynik.= '<label class="labelReportsCriteria"><input type="checkbox" name="'.$nazwa.'_'.$row[0].'" '.$checked.'> '.$row[1].'</label><br>';
	}
	return $wynik;
}

function utworz_checkbox_ind($zapytanie, $nazwa){
	$res = sql($zapytanie);
	$wynik = '';
	while ($row = mysql_fetch_assoc($res)){
	$i=0;
	foreach ($row as $Ind=>$Val){
	        if($i == 0){
				$disabled = 'style="display:none"'; 
			}else{
				$disabled = '';
			}
			$wynik.= '<div class="cb_Wyn" '.$disabled.'><label class="labelReportsCriteria"><input type="checkbox" name="'.$nazwa.'_'.$i.'" checked/> '.$Ind.' </label></div>';
			$i++;	
		}
	}
	return $wynik;
}

function utworz_rekord_tabeli($dane,$naglowek){

	if (1 == $naglowek){
		$dane_kopia = $dane;
			$naglowek_tabeli='<tr>';
		foreach($dane_kopia as $Ind1=>$Val1){
			$naglowek_tabeli.='<td class="'.$Ind1.'"><b>'.str_replace("_", " ", $Ind1).'</b></td>';
		}
        $naglowek_tabeli.='</tr>';
    }
	$rekord_tabeli='<tr>';
	$i=0;
	foreach($dane as $Ind1=>$Val1){
	$i++;
	if($i==1){$name=$Val1;}
	 $rekord_tabeli.='<td id="td_'.$name.'" onClick="dodaj_wpisy(this)"  name="'.$name.'" class="'.$Ind1.'">'.$Val1.'</td>';
	}
    return $naglowek_tabeli.$rekord_tabeli.='</tr><tr><td onClick="schowaj_wpisy(this)" id="'.$name.'" colspan="'.$i.'" style="display: none;"> </td></tr>';
    //return $naglowek_tabeli.$rekord_tabeli.='</tr><tr><td onClick="this.empty()" id="'.$name.'" colspan="'.$i.'"> </td></tr>';
}

function utworz_rekord_tabeli_ATPM($dane,$naglowek){
	if (1 == $naglowek){
		$dane_kopia = $dane;
			$naglowek_tabeli='<tr>';
		foreach($dane_kopia as $Ind1=>$Val1){
			$naglowek_tabeli.='<td class="'.$Ind1.'"><b>'.str_replace("_", " ", $Ind1).'</b></td>';
		}
        $naglowek_tabeli.='</tr>';
    }
	$rekord_tabeli='<tr>';
	$i=0;
	foreach($dane as $Ind1=>$Val1){
	$i++;
	if($i==1){$name=$Val1;}
	 $rekord_tabeli.='<td id="td_'.$name.'" onClick="dodaj_wpisy_ATPM(this)"  name="'.$name.'" class="'.$Ind1.'">'.$Val1.'</td>';
	}
    return $naglowek_tabeli.$rekord_tabeli.='</tr><tr><td onClick="this.empty()" id="'.$name.'" colspan="'.$i.'"> </td></tr>';
}

function utworz_rekord_tabeli_ATPM_color($dane,$naglowek,$color){
	if (1 == $naglowek){
		$dane_kopia = $dane;
			$naglowek_tabeli='<tr>';
		foreach($dane_kopia as $Ind1=>$Val1){
			$naglowek_tabeli.='<td class="'.$Ind1.'"><b>'.str_replace("_", " ", $Ind1).'</b></td>';
		}
        $naglowek_tabeli.='</tr>';
    }
	$rekord_tabeli='<tr>';
	$i=0;
	foreach($dane as $Ind1=>$Val1){
	$i++;
	if($i==1){$name=$Val1;}
	 $rekord_tabeli.='<td bgcolor="'.$color.'" id="td_'.$name.'" onClick="dodaj_wpisy_ATPM(this)"  name="'.$name.'" class="'.$Ind1.'">'.$Val1.'</td>';
	}
    return $naglowek_tabeli.$rekord_tabeli.='</tr><tr><td onClick="this.empty()" id="'.$name.'" colspan="'.$i.'"> </td></tr>';
}

function utworz_rekord_tabeli_ArchTPM($dane,$naglowek,$path){
	//dispTab($dane);
	if (1 == $naglowek){
		$dane_kopia = $dane;
			$naglowek_tabeli='<tr>';
		foreach($dane_kopia as $Ind1=>$Val1){
			$naglowek_tabeli.='<td class="'.$Ind1.'"><b>'.str_replace("_", " ", $Ind1).'</b></td>';
		}
        $naglowek_tabeli.='</tr>';
    }
	$rekord_tabeli='<tr>';
	$i=0;
	foreach($dane as $Ind1=>$Val1){
	$i++;
	if($i==1){$name=$Val1;}
	 $rekord_tabeli.='<td id="td_'.$name.'" onClick="dodaj_wpisy_ArchTPM(this, 1, \''.$path.'\')"  name="'.$name.'" class="'.$Ind1.'">'.$Val1.'</td>';
	}
    return $naglowek_tabeli.$rekord_tabeli.='</tr><tr><td onClick="this.empty()" id="'.$name.'" colspan="'.$i.'"> </td></tr>';
}

function utworz_rekord_tabeli_ATPM2($dane,$naglowek,$nr){

	if (1 == $naglowek){
		$dane_kopia = $dane;
			$naglowek_tabeli='<tr>';
		foreach($dane_kopia as $Ind1=>$Val1){
			$naglowek_tabeli.='<td class="'.$Ind1.'"><b>'.str_replace("_", " ", $Ind1).'</b></td>';
		}
        $naglowek_tabeli.='</tr>';
    }
	$rekord_tabeli='<tr>';
	$i=0;
	foreach($dane as $Ind1=>$Val1){
	$i++;
	if($i==1){$name=$Val1;}
	 $rekord_tabeli.='<td id="td_'.$name.'" onClick="dodaj_wpisy_ATPM2(this, '.$nr.')"  name="'.$name.'" class="'.$Ind1.'">'.$Val1.'</td>';
	}
    return $naglowek_tabeli.$rekord_tabeli.='</tr><tr><td onClick="this.empty()" id="'.$name.'" colspan="'.$i.'"> </td></tr>';
}

function utworz_rekord_tabeli_PrTPM($dane,$naglowek,$color){
	switch ($color){
		default:
			$TrColor="white";
		break;
		case 1:
			$TrColor="green";
		break;
		case 2:
			$TrColor="red";
		break;
		case 3: 
			$TrColor="orange";
		break;
		case 4:
			$TrColor="grey";
		break;
		case 5:
			$TrColor="silver";
		break;
	}
	if (1 == $naglowek){
		$dane_kopia = $dane;
			$naglowek_tabeli='<tr>';
		foreach($dane_kopia as $Ind1=>$Val1){
			$naglowek_tabeli.='<td class="'.$Ind1.'"><b>'.str_replace("_", " ", $Ind1).'</b></td>';
		}
        $naglowek_tabeli.='</tr>';
    }
	$rekord_tabeli='<tr bgcolor="'.$TrColor.'">';
	$i=0;
	foreach($dane as $Ind1=>$Val1){
	$i++;
	if($i==1){$name=$Val1;}
	 $rekord_tabeli.='<td id="td_'.$name.'">'.$Val1.'</td>';	
	}
    return $naglowek_tabeli.$rekord_tabeli.='</tr><tr><td onClick="this.empty()" id="'.$name.'" colspan="'.$i.'"> </td></tr>';
}

function utworz_rekord_tabeli_BD($dane,$naglowek){

	if (1 == $naglowek){
		$dane_kopia = $dane;
			$naglowek_tabeli='<tr>';
		foreach($dane_kopia as $Ind1=>$Val1){
			$naglowek_tabeli.='<td><b>'.str_replace("_", " ", $Ind1).'</b></td>';
		}
        $naglowek_tabeli.='</tr>';
    }
	$rekord_tabeli='<tr>';
	$i=0;
	foreach($dane as $Ind1=>$Val1){
	$i++;
	if($i==1){$name=$Val1;}
	
	 $rekord_tabeli.='<td>'.$Val1.'</td>';
		
		
	}
    return $naglowek_tabeli.$rekord_tabeli.='</tr><tr><td onClick="this.empty()" id="'.$name.'" colspan="'.$i.'"> </td></tr>';
}

function utworz_rekord_tabeli_BD_HTML($dane,$naglowek){

	if (1 == $naglowek){
		$dane_kopia = $dane;
			$naglowek_tabeli='<tr style="border:1px solid black;">';
		foreach($dane_kopia as $Ind1=>$Val1){
			$naglowek_tabeli.='<td><b>'.str_replace("_", " ", $Ind1).'</b></td>';
		}
        $naglowek_tabeli.='</tr>';
    }

	$rekord_tabeli='<tr style="border:1px solid black;">';
	$i=0;
	foreach($dane as $Ind1=>$Val1){
	$i++;
	if($i==1){$name=$Val1;}
	 
	 $rekord_tabeli.='<td>'.$Val1.'</td>';
		
	}
    return $naglowek_tabeli.$rekord_tabeli;
}

function utworz_rekord_tabeli_pod($dane,$naglowek){
	
	if (1 == $naglowek){
		$dane_kopia = $dane;
			$naglowek_tabeli='<tr>';
		foreach($dane_kopia as $Ind1=>$Val1){
			$naglowek_tabeli.='<td><b>'.str_replace("_", " ", $Ind1).'</b></td>';
		}
        $naglowek_tabeli.='</tr>';
    }
	$rekord_tabeli='<tr>';

	foreach($dane as $Ind1=>$Val1){
	
	 $rekord_tabeli.='<td>'.$Val1.'</td>';
	}
    return $naglowek_tabeli.$rekord_tabeli.='</tr>';
}

function utworz_rekord_tabeli_pod_color($dane,$naglowek,$color){
	if (1 == $naglowek){
		$dane_kopia = $dane;
			$naglowek_tabeli='<tr>';
		foreach($dane_kopia as $Ind1=>$Val1){
			$naglowek_tabeli.='<td><b>'.str_replace("_", " ", $Ind1).'</b></td>';
		}
        $naglowek_tabeli.='</tr>';
    }
	$rekord_tabeli='<tr bgcolor="'.$color.'">';

	foreach($dane as $Ind1=>$Val1){
	
	 $rekord_tabeli.='<td>'.$Val1.'</td>';
	}
	return $rekord_tabeli;
}

function utworz_rekord_tabeli_pod_tr($dane){
	
	$rekord_tabeli='';

	foreach($dane as $Ind1=>$Val1){
		$rekord_tabeli.='<tr>';
		$rekord_tabeli.='<td>'.($Ind1+1).'</td>';
		$rekord_tabeli.='<td>'.$Val1.'</td>';
		$rekord_tabeli.='</tr>';
	}
    return $rekord_tabeli;
}

function utworz_rekord_tabeli_pod_p($dane){
	
	$rekord_tabeli='';

	foreach($dane as $Ind1=>$Val1){
		$rekord_tabeli.='';
		$rekord_tabeli.=($Ind1+1).': ';
		$rekord_tabeli.=$Val1;
		$rekord_tabeli.='<br>';
	}
    return $rekord_tabeli;
}

function utworz_tabl_ind($rqTab, $str){
	$wynik = array();
	foreach($rqTab as $Ind=>$Val){
		if ($tab01=explode("_", $Ind)){
			if ($tab01[0]==$str) $wynik[]=$tab01[1];
		}
	}

	return $wynik;
}

function utworz_tabl_wart($rqTab, $str){
	foreach($rqTab as $Ind=>$Val){
		if ($tab01=explode("_", $Ind)){
			if ($tab01[0]==$str) $wynik[$Ind]=$Val;
		}
	}
	return $wynik;
}

function utworz_warunek_zapytania($Kolumna, $tabInd){
	$size=count($tabInd);
	if ($size>0)$wynik="AND ("; else $wynik="";// zalozenie ze pierwsza w zapytaniu jest data i jest zawsze
	for ($i=0; $i<=($size-1); $i++){
		$wynik.=$Kolumna."=".$tabInd[$i];
		if ($i!=$size-1) $wynik.=" OR ";
		if ($i==$size-1) $wynik.=")";
	}
	return $wynik;
}

function timeDecToMin($CzasDec) {
	$min=sprintf("%02.0f", round(($CzasDec-floor($CzasDec))*60.0));
	return floor($CzasDec).'.'.$min;
}

function jquery2iso($in)
{
  $CONV = array();
  $CONV['c4']['85'] = 'ą';
  $CONV['c4']['84'] = 'Ą';
  $CONV['c4']['87'] = 'ć';
  $CONV['c4']['86'] = 'Ć';
  $CONV['c4']['99'] = 'ę';
  $CONV['c4']['98'] = 'Ę';
  $CONV['c5']['82'] = 'ł';
  $CONV['c5']['81'] = 'Ł';
  $CONV['c4']['84'] = 'ń';
  $CONV['c4']['83'] = 'Ń';
  $CONV['c3']['b3'] = 'ó';
  $CONV['c3']['93'] = 'Ó';
  $CONV['c5']['9b'] = 'ś';
  $CONV['c5']['9a'] = 'Ś';
  $CONV['c5']['ba'] = 'ź';
  $CONV['c5']['b9'] = 'Ź';
  $CONV['c5']['bc'] = 'ż';
  $CONV['c5']['bb'] = 'Ż';

  $i=0;
  $out = '';
  while($i<strlen($in))
  {
    if(array_key_exists(bin2hex($in[$i]), $CONV))
    {
      $out .= $CONV[bin2hex($in[$i])][bin2hex($in[$i+1])];
      $i += 2;
    }
    else
    {
      $out .= $in[$i];
      $i += 1;
    }
  }

  return $out;
}

function wyswietl_czynnosci_przegladu_NOK($IDPrz){
	$daneNOK=sql("SELECT * from `tpm2_przeglady` WHERE `ID`='$IDPrz'");
	$wynik='<table>';
	while ($row=mysql_fetch_array($daneNOK, MYSQL_ASSOC)){
	//dispTab($row);
	$daneListaSz=sql("SELECT `PolaPrzeg` FROM `tpm2_szablony` WHERE `ID`='$row[ID_Szablonu]'");
	$rowListaSz=mysql_fetch_assoc($daneListaSz);
	$daneListaR=sql("SELECT `PolaPrzeg` FROM `tpm2_szablony_r` WHERE `ID`='$row[ID_Rozszerzenia]'");
	$rowListaR=mysql_fetch_assoc($daneListaR);
	$rowNOK=mysql_fetch_assoc(sql("SELECT `PolaPrzeg` FROM `tpm2_przeglady` WHERE `ID_Karty`=$row[ID_Karty] AND `Wykonywany`='2' AND `ID_Maszyny`='0'"));
	//dispTab($rowNOK);
	$ileSz=count(explode('||', $rowListaSz['PolaPrzeg']));
	$PolaNok=explode('||', $rowNOK['PolaPrzeg']);
	if ($rowListaR['PolaPrzeg']=='') $ileR=0; else $ileR=1;
	//echo '<br> jest rozszerzenie?: '.$ileR;
	if ($ileR==0){
		$PolaOpis=explode('||', ($rowListaSz['PolaPrzeg']));
	}
	else{
		$PolaOpis=explode('||', ($rowListaSz['PolaPrzeg'].'||'.$rowListaR['PolaPrzeg']));
	}
	$i=1;
	foreach ($PolaOpis as $Ind=>$Val){
		if ($Ind<=($ileSz-1)) $color='white'; else $color='grey';
		$Dane['LP']=$Ind+1;
		$Dane['Opis NOK']=$PolaNok[$Ind];
		$Dane['Czynność']=$PolaOpis[$Ind];
		//dispTab($dane);
		$wynik.=utworz_rekord_tabeli_pod_color($Dane, $i, $color);
		$i++;
	}
}
$wynik.='</table>';
return $wynik;
}

function wyswietl_czynnosci_przegladu_wyk($IDWyk){
	$zap1=sql("SELECT mas.`NAZWA_MASZYNY`, tpm2P.`ID_Szablonu`, tpm2P.`ID_Rozszerzenia`, tpm2P.`Data_Przegladu`, CONCAT(usr.`UsrImie`,' ', usr.`UsrNazw`) as 'Zlecający' 
		FROM `tpm2_przeglady` as tpm2P, `maszyny` as mas, `usrdat` as usr
		WHERE tpm2P.`ID`='$IDWyk'
		AND usr.`ID_UsrDat`=tpm2P.`ID_Zlecajacy`
		");
	// $IDWyk - id z tablicy tpm2_przeglady
	$Ind=mysql_fetch_assoc($zap1); // tu są indeksy szablonu i rozszerzenia
	$zapPolaSz=mysql_fetch_assoc(sql("SELECT `PolaPrzeg` from `tpm2_szablony` WHERE `ID`='$Ind[ID_Szablonu]'"));
	$ileSz=count(explode('||',$zapPolaSz['PolaPrzeg']));
	// sprawdzenie czy rozszerzenie nie puste
	$zapPolaR=mysql_fetch_assoc(sql("SELECT `PolaPrzeg` from `tpm2_szablony_r` WHERE `ID`='$Ind[ID_Rozszerzenia]'"));
	if ($zapPolaR['PolaPrzeg']=='') $ileR=0; else $ileR=1;
	
	if ($ileR!=0){
	$zap="SELECT CONCAT(tpmSz.`PolaPrzeg`,'||',tpmR.`PolaPrzeg`) AS 'PolaPrzeg' 
		FROM `tpm2_szablony` as tpmSz, `tpm2_szablony_r` as tpmR 
		WHERE tpmSz.`ID`='$Ind[ID_Szablonu]'
		AND tpmR.`ID`='$Ind[ID_Rozszerzenia]'
		";
	} else {
	$zap="SELECT `PolaPrzeg` from `tpm2_szablony` WHERE `ID`='$Ind[ID_Szablonu]'";
	}
	
	$danePola=sql($zap);
	$PolaTab=mysql_fetch_assoc($danePola);
	$Pola=explode('||', $PolaTab['PolaPrzeg']);
	$dataToday=date("Y-m-d");
	$datIDKarty=sql("SELECT `ID_Karty` from `tpm2_przeglady` where `ID`='$IDWyk'");
	$row=mysql_fetch_array($datIDKarty);
	$IDKarty=$row['ID_Karty'];
	echo "ID karty".$IDKarty;
	$datPrzeg=sql("SELECT * from `tpm2_przeglady` WHERE `ID_Karty`='$IDKarty'");
    
    
	while ($row=mysql_fetch_array($datPrzeg)){
		$PolaDatID=explode('||', $row['PolaPrzeg']);
		foreach($PolaDatID as $IndPD=>$ValPD){
			if ($ValPD==1){
				$PolaDat[$IndPD]=$row['Data_Przegladu'];
				$cb_checked[$IndPD]='checked="checked" disabled';
			}
			
		}
	}
	foreach ($Pola as $IndP=>$ValP){
		if ($IndP<$ileSz) $color[$IndP]="white"; else $color[$IndP]="grey";
	}
    //echo print_r($PolaDat);
    //dispTab($PolaDat);
$wynik='<table> 
<tr><td>LP</td><td>Nazwa czynności</td><td class="nok">OK/NOK</td><td class="ok">UWAGI</td><td>Data wyk</td></tr>';

foreach ($Pola as $Ind=>$Val){
	//echo $PolaDat[$Ind];
	$wynik.='<tr bgcolor="'.$color[$Ind].'"><td>'.($Ind+1).'</td><td>'.$Val.'</td><td><center><input type="checkbox" name="cb_'.($Ind+1).'" onClick="ustawDate(this)" '.$cb_checked[$Ind].'/></center>puste</td><td>puste</td><td><input value="'.$PolaDat[$Ind].'" type="text" size="11" name="td_'.($Ind+1).'" id="td_'.($Ind+1).'" disabled />puste</td></tr>';
}
$wynik.='</table>';
return $wynik;
}

function wyswietl_czynnosci_szablonu($IDSz){
	$datSzab=sql("SELECT * from `tpm2_szablony` WHERE `ID`='$IDSz'");
	if (!($row=mysql_fetch_assoc($datSzab))) echo '<br> brak danych';
	else{
		$czynnosci=explode('||', $row['PolaPrzeg']);
		$wynik='<table>';
		foreach ($czynnosci as $Ind=>$Val){
			$wynik.='<tr><td>'.($Ind+1).'&nbsp;</td><td>'.$Val.'&nbsp;</td><td>&nbsp;</td></tr>';
		}
		$wynik.='</table>';
		return $wynik;
	}
}


function wyswietl_etap_przegladu($data){
	//dispTab($data);
	$Czynnosc = array (
		1 => "Wydrukowano kartę przeglądu",
		2 => "Zgłoszono NOK",
		3 => "Odrzucono NOK",
		4 => "Zatwierdzono NOK",
		5 => "Zakończono"
	);
	echo '';
	echo '<tr bgcolor="#D8D8D8"><td>'.$data['Data_Przegladu'].'</td><td>'.$Czynnosc[$data['Wykonywany']].'</td></tr>';
	if ($data['Wykonywany']==1) wyswietl_czynnosci_etapu($data);
	if ($data['Wykonywany']==2) echo 'NOK';
}

function wyswietl_czynnosci_etapu($data){
	$IDSzR=mysql_fetch_assoc(sql("SELECT `ID_Szablonu`, `ID_Rozszerzenia` from `tpm2_przeglady` WHERE `ID_Karty`='$data[ID_Karty]' AND `ID_Maszyny`>0"));	
	$zap="SELECT CONCAT(tpmSz.`PolaPrzeg`,'||',tpmR.`PolaPrzeg`) AS 'PolaPrzeg' 
		FROM `tpm2_szablony` as tpmSz, `tpm2_szablony_r` as tpmR 
		WHERE tpmSz.`ID`='$IDSzR[ID_Szablonu]'
		AND tpmR.`ID`='$IDSzR[ID_Rozszerzenia]'
		";
	$dataZap=sql($zap);
	while ($rowCz=mysql_fetch_assoc($dataZap)){
		$Zaznaczone=explode('||', $data['PolaPrzeg']);
		$Nazwy=explode('||', $rowCz['PolaPrzeg']);
		$i=0;
		foreach ($Zaznaczone as $Ind=>$Val){
			echo '<br>'.($Ind+1).'. '.$Nazwy[$Ind]; 
			if ($Val==1) echo '<strong> OK</strong>';
		}
	}
	
}
//diagnostyka

function dispTab($Tab)
{
	echo'<br>Tablica:<pre>';
	print_r($Tab);
	echo'</pre>';
}
?>

<script>
function ustawDate(arg){
	var data='<?php echo $dataToday; ?>';
	array=arg.name.split('_');
	number=(array[1]);
	nazwa='td_'+number;
	if (arg.getProperty('checked')==true){
		$(nazwa).setProperty('value', data);
		}
	else {
		$(nazwa).setProperty('value', '');
	}
}
</script>