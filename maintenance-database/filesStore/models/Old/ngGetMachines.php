<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
ini_set('display_errors', 1);

require_once './ngLoginCheck.php';

// Create connection with database
$conn = mysqli_connect($hn, $un, $pw, $db);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//----------------------------------------------------------------------------
// download all currencies in our exchange
//----------------------------------------------------------------------------
// mysql query
$sql = 'SELECT '
     . 'ID_MASZYNY, NAZWA_MASZYNY, id_przynaleznosc '
     . 'FROM '
     . 'maszyny '
     . 'WHERE '
     . 'deleted=0 ORDER BY NR_4D ASC LIMIT 1000';

// Assure to properly use of polish signs
mysqli_query($conn, "SET NAMES 'utf8'");
// send query to database and get results
$result = mysqli_query($conn, $sql);

// Loop for create array with data from database
$num_machines = mysqli_num_rows($result);
if (mysqli_num_rows($result) > 0) {     
    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {
        // Filling currecny array with data from database
        $machines[$i] = array(
            "id" => addslashes($row["ID_MASZYNY"]),
            "name" => addslashes($row["NAZWA_MASZYNY"]),
            "lineId" => addslashes($row["id_przynaleznosc"])
        );
        $i++;        
    }
}

// Prepare output for client side
$output = '';
// Currencies
$output .= '{"machines":[';
                for($pos = 0; $pos<$num_machines; $pos++){
                    // Pobieram każdy z wierszy
                    if($pos>0)  $output .= ',';
        $output .= '{"id": '.$machines[$pos]["id"].','              // id
                .   '"name": "'.$machines[$pos]["name"].'",'       // surname
                .   '"lineId": '.$machines[$pos]["lineId"].'}';     // surname
                }
$output .=          ']}';

// Close mysql connection
mysqli_close($conn);

// Send data to client
echo($output);