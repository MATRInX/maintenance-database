<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once "./login.php";

// Connection to database
$conn = new mysqli($hn, $un, $pw, $db);
// Get parameters from request
$params = json_decode(file_get_contents('php://input'));
$dirtyQueryType = $params->query;
$dirtyQueryData = $params->data;

$returnValue = NULL;

if($conn->connect_error){
    SafeFunction::mysql_fatal_error($conn->connect_error);
}
else{
    $safeObj = new SafeFunction($conn);
    // Clear request type and data
    $queryType;
    $queryData;
    if(isset($dirtyQueryType)){
        $queryType = $safeObj->clear_text($dirtyQueryType);
        $parameterNumber = count($dirtyQueryData);
        for($i=0; $i<$parameterNumber; $i++){
            $dirtyQueryData[$i]->key = $safeObj->clear_text($dirtyQueryData[$i]->key);
            $dirtyQueryData[$i]->value = $safeObj->clear_text($dirtyQueryData[$i]->value);
        }
        $queryData = $dirtyQueryData;
    }
    // Create user
    $user = new UserData($conn);
    // Check request type
    switch($queryType){
        case 'getUserFullName':
            $returnValue['userFullName'] = $user->getUserFullName();
            break;
        case 'checkLoginStatus':
            $returnValue['logoutStatus'] = $user->checkLoginStatus();
            break;
        case 'getUserRights':
            $returnValue['userRights'] = $user->getUserRights();
            break;
        case 'logoutUser':
            $returnValue['logoutStatus'] = $user->logoutUser();
            break;
        case 'loginSubmit':
            // Check right query data
            $login = ($queryData[0]->key === 'login' ? $queryData[0]->value : NULL);
            $password = ($queryData[1]->key === 'password' ? $queryData[1]->value : NULL);
            if(isset($login) && isset($password)){
                $returnValue['logoutStatus'] = $user->loginSubmit($login, $password);
            }
            else{
                // Wrong query data
            }
            break;
    }
}
$conn->close();
echo json_encode($returnValue);
?>