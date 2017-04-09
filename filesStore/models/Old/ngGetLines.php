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
     . 'ID_INNE, OPIS_INNE '
     . 'FROM '
     . 'inne '
     . 'WHERE '
     . 'deleted=0 LIMIT 1000';

// Assure to properly use of polish signs
mysqli_query($conn, "SET NAMES 'utf8'");
// send query to database and get results
$result = mysqli_query($conn, $sql);

// Loop for create array with data from database
$num_lines = mysqli_num_rows($result);
if (mysqli_num_rows($result) > 0) {     
    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {
        // Filling currecny array with data from database
        $lines[$i] = array(
            "id" => addslashes($row["ID_INNE"]),
            "name" => addslashes($row["OPIS_INNE"])
        );
        $i++;        
    }
}
// Getting membership of each machines
$sql = 'SELECT '
     . 'id, opis '
     . 'FROM '
     . 'przynaleznosc '
     . 'WHERE '
     . 'deleted=0 LIMIT 1000';

// Assure to properly use of polish signs
mysqli_query($conn, "SET NAMES 'utf8'");
// send query to database and get results
$result = mysqli_query($conn, $sql);

// Loop for create array with data from database
$num_memberships = mysqli_num_rows($result);
if (mysqli_num_rows($result) > 0) {     
    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {
        // Filling currecny array with data from database
        $memberships[$i] = array(
            "id" => addslashes($row["id"]),
            "name" => addslashes($row["opis"])
        );
        $i++;        
    }
}


// Prepare output for client side
$output = '';
$membershipId = 0;
// Currencies
$output .= '{"lines":[';
                for($pos = 0; $pos<$num_lines; $pos++){
                    // Pobieram każdy z wierszy
                    if($pos>0)  $output .= ',';
                    $membershipId = 0;
                    for($i = 0; $i<$num_memberships; $i++){
                        if($lines[$pos]["name"] == $memberships[$i]["name"]){
                            $membershipId = $memberships[$i]["id"];
                            break;
                        }
                    }
                    if($membershipId==0){
                        $membershipId = $lines[$pos]["id"];
                    }
        $output .= '{"id": '.$lines[$pos]["id"].','              // id
                .   '"name": "'.$lines[$pos]["name"].'",'      // surname
                .   '"membershipId": '.$membershipId.'}';     // surname
                }
$output .=          ']}';

// Close mysql connection
mysqli_close($conn);

// Send data to client
echo($output);