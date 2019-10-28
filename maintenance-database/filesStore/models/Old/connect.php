<?php
function connection() {
	global $conn;
	if($conn) {
		return $conn;
		} else {
		$conn =mysql_connect('','root','tenmaint123');
		mysql_set_charset('utf8',$conn);
		if (!$conn || !mysql_select_db('tenmaint',$conn)) {
		return 0;
		echo 'błąd połączenia z bazą';
		}else {
		return $conn;
		echo 'połączenie ok';
		
		}
	}
}


function sql($query) {

	if (!($conn=connection()))
        {
	return 0;	
	}
        else
        {
		$result = mysql_query($query,$conn);
		if(!$result)
                {
		print ("wystąpił błąd <br/> [\"$query\"]<br />[".mysql_error()."]");
		}
                else
                {
		return $result;
		}
	}
}
?>
