<?php
class UserData{
    private $userId;
    private $userRightsLevel;
    private $conn;

    function __construct($conn){
        $this->conn = $conn;
        if($_SESSION['zalogowany']){
            // User logged in - let's find his ID
            $this->userId = $_SESSION['dane_uzytkownika']['ID_UsrDat'];
        }
        else{
            // User not logged - ID = -1
            $this->userId = -1;
        }
    }

    public function checkLoginStatus(){
        if($_SESSION['zalogowany']){
            return true;
        }
        else{
            return false;
        }
    }

    public function getUserRights(){
        $returnValue = 'basic';
        $userID = $this->userId;
        //SELECT user_levels.user_level_name FROM user_levels, usrdat WHERE user_levels.user_level_id=usrdat.user_level AND usrdat.ID_UsrDat=10
        $query = "SELECT user_levels.user_level_name "
                ."FROM user_levels, usrdat "
                ."WHERE user_levels.user_level_id=usrdat.user_level AND usrdat.ID_UsrDat=$userID";
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
        }
        else{
            if($result->num_rows > 0){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $returnValue = $row['user_level_name'];
            }
        }
        return $returnValue;
    }

    public function getUserFullName(){
        if($_SESSION['zalogowany']){
            $returnValue = $_SESSION['dane_uzytkownika']['UsrImie']." ".$_SESSION['dane_uzytkownika']['UsrNazw'];
            return $returnValue;
        }
        else{
            return 'Anonymous';
        }
    }

    public function getUserFullNameWithId($userId){
        $returnValue = 'Anonimowy';
        $query = "SELECT * FROM usrdat";
        $result = $this->sendQuery($query);
        $users = NULL;
        if($result !== NULL){
            if($result !== true){
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $users[$i] = array(
                        'ID_UsrDat' => intval($row['ID_UsrDat']),
                        'UsrImie' => $row['UsrImie'],
                        'UsrNazw' => $row['UsrNazw']
                    );
                    $i++;
                }
                for($i=0; $i<count($users); $i++){
                    if($users[$i]['ID_UsrDat'] == $userId){
                        $returnValue = $users[$i]['UsrImie']." ".$users[$i]['UsrNazw'];
                        break;
                    }
                }
            }
        }
        return $returnValue;
    }

    public function loginSubmit($login, $password){
        $returnValue = false;
        // MySQL query for check if login and password are ok
        $query = "SELECT * FROM usrdat WHERE UsrLogin='$login' AND UsrPass='$password' LIMIT 1";
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
        }
        else{
            if($result->num_rows > 0){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $_SESSION['zalogowany']=true;  // ustawiamy zmienna na true
                $_SESSION['dane_uzytkownika']=$row;
                $returnValue = true;
            }
        }
        // If yes, set good SESSION data
        return $returnValue;
    }

    public function logoutUser(){
        if($_SESSION['zalogowany']){
            session_destroy();
            return true;
        }else{
            return false;
        }
    }

    public function getUserId(){
        return $this->userId;
    }

    private function sendQuery($query){
        $returnValue = NULL;
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if($this->conn->affected_rows === -1){
            // There is some errors
            SafeFunction::mysql_fatal_error($result->error);
            // When there is some error from query
            $returnValue = false;
        }
        else{
            if($this->conn->affected_rows > 0){
                // There are some results so i return them
                $returnValue = $result;
            }
            else{
                // no records were updated for an UPDATE statement, 
                // no rows matched the WHERE clause in the query or that 
                // no query has yet been executed
                // query finish with no data so I return true
                $returnValue = true;
            }
        }
        return $returnValue;
    }
}
?>