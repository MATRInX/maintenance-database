<?php
class ToolingData{
    private $conn;
    private $locations;
    private $process;
    private $mass;
    private $m20v;
    private $repairStatus;
    private $toolingStatus;
    private $repairDefaultStatus;
    private $toolingDefaultStatus;
    private $toolingRepairStatus;
    private $toolingFinishedStatus;

    function __construct($conn){
        $this->conn = $conn;
        $this->getLocationsTable();
        $this->getProcessTable();
        $this->getMassTable();
        $this->getM20vTable();
        $this->getRepairStatusTable();
        $this->getToolingStatusTable();
        $this->repairDefaultStatus = 'W trakcie naprawy';
        $this->toolingDefaultStatus = 'Dostêpne';
        $this->toolingRepairStatus = 'W naprawie';
        $this->toolingFinishedStatus = 'Naprawione';
    }

    public function checkHashId($idToCheck){
        $returnValue = false;
        $Id = $this->getNumberFromHashId($idToCheck);
        // MySQL query for check if login and password are ok
        $query = "SELECT * FROM toolstoolinglist WHERE hashId=$Id";
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
        }
        else{
            if($result->num_rows > 0){
                // It means that ID is not unique
                $returnValue = false;
            }
            else{
                // ID is unique
                $returnValue = true;
            }
        }
        return $returnValue;
    }

    public function getModalLists(){
        $returnValue = NULL;
        $returnValue['locations'] = $this->getAllLocations();
        $returnValue['process'] = $this->getAllProcesses();
        $returnValue['mass'] = $this->getAllMassReferences();
        $returnValue['m20v'] = $this->getAllM20vReferences();
        return $returnValue;
    }
    public function getToolingLocations(){
        return $this->locations;
        //$returnValue = NULL;
        //$query = "SELECT name FROM toolslocations";
        //$result = $this->conn->query($query);
        //if(!$result){
        //    SafeFunction::mysql_fatal_error($result->error);
        //}
        //else{
        //    if($result->num_rows > 0){
        //        // I had all locations
        //        $i = 0;
        //        while($row = mysqli_fetch_assoc($result)){
        //            $returnValue[$i] = array(
        //                'name' => $row['name']
        //            );
        //            $i++;
        //        }
        //    }
        //}
        //return $returnValue;
    }
    public function getProcessTypes(){
        return $this->process;
        //$returnValue = NULL;
        //$query = "SELECT name FROM toolsprocess";
        //$result = $this->conn->query($query);
        //if(!$result){
        //    SafeFunction::mysql_fatal_error($result->error);
        //}
        //else{
        //    if($result->num_rows > 0){
        //        // I had all locations
        //        $i = 0;
        //        while($row = mysqli_fetch_assoc($result)){
        //            $returnValue[$i] = array(
        //                'name' => $row['name']
        //            );
        //            $i++;
        //        }
        //    }
        //}
        //return $returnValue;
    }
    public function getMassReferences(){
        return $this->mass;
        //$returnValue = NULL;
        //$query = "SELECT name FROM toolsmassref";
        //$result = $this->conn->query($query);
        //if(!$result){
        //    SafeFunction::mysql_fatal_error($result->error);
        //}
        //else{
        //    if($result->num_rows > 0){
        //        // I had all locations
        //        $i = 0;
        //        while($row = mysqli_fetch_assoc($result)){
        //            $returnValue[$i] = array(
        //                'name' => $row['name']
        //            );
        //            $i++;
        //        }
        //    }
        //}
        //return $returnValue;
    }
    public function getM20vReferences(){
        return $this->m20v;
        //$returnValue = NULL;
        //$query = "SELECT name FROM toolsm20vref";
        //$result = $this->conn->query($query);
        //if(!$result){
        //    SafeFunction::mysql_fatal_error($result->error);
        //}
        //else{
        //    if($result->num_rows > 0){
        //        // I had all locations
        //        $i = 0;
        //        while($row = mysqli_fetch_assoc($result)){
        //            $returnValue[$i] = array(
        //                'name' => $row['name']
        //            );
        //            $i++;
        //        }
        //    }
        //}
        //return $returnValue;
    }

    private function getLocationsTable(){
        $returnValue = NULL;
        $query = "SELECT * FROM toolslocations";
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
        }
        else{
            if($result->num_rows > 0){
                // I had all locations
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$i] = array(
                        'locationId' => $row['locationId'],
                        'name' => $row['name']
                    );
                    $i++;
                }                
            }
        }
        $this->locations = $returnValue;
    }
    private function getProcessTable(){
        $returnValue = NULL;
        $query = "SELECT * FROM toolsprocess";
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
        }
        else{
            if($result->num_rows > 0){
                // I had all process
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$i] = array(
                        'processId' => $row['processId'],
                        'name' => $row['name']
                    );
                    $i++;
                }                
            }
        }
        $this->process = $returnValue;
    }
    private function getMassTable(){
        $returnValue = NULL;
        $query = "SELECT * FROM toolsmassref";
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
        }
        else{
            if($result->num_rows > 0){
                // I had all mass references
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$i] = array(
                        'massId' => $row['massId'],
                        'name' => $row['name']
                    );
                    $i++;
                }
            }
        }
        $this->mass = $returnValue;
    }
    private function getM20vTable(){
        $returnValue = NULL;
        $query = "SELECT * FROM toolsm20vref";
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
        }
        else{
            if($result->num_rows > 0){
                // I had all m20v references
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$i] = array(
                        'm20vId' => $row['m20vId'],
                        'name' => $row['name']
                    );
                    $i++;
                }
            }
        }
        $this->m20v = $returnValue;
    }
    private function getRepairStatusTable(){
        $returnValue = NULL;
        $query = "SELECT id, name FROM toolsstatus WHERE tablename='toolsrepairhistory'";
        $result = $this->sendQuery($query);
        if($result !== NULL){
            if($result !== true){
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$i] = array(
                        'id' => intval($row['id']),
                        'name' => $row['name']
                    );
                    $i++;
                }
            }            
        }
        $this->repairStatus = $returnValue;
    }
    private function getToolingStatusTable(){
        $returnValue = NULL;
        $query = "SELECT id, name FROM toolsstatus WHERE tablename='toolstoolinglist'";
        $result = $this->sendQuery($query);
        if($result !== NULL){
            if($result !== true){
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$i] = array(
                        'id' => intval($row['id']),
                        'name' => $row['name']
                    );
                    $i++;
                }
            }            
        }
        $this->toolingStatus = $returnValue;
    }

    public function getLocationWithId($requestId){
        $returnValue = '';
        //echo 'request id';
        //echo $requestId;
        //echo 'locations';
        //print_r($this->locations);
        //echo 'array column';
        //print_r(array_column($this->locations, 'locationId'));
        $lookingIndex = array_search($requestId, $this->array_column($this->locations, 'locationId'));
        if($lookingIndex !== FALSE){
            $returnValue = $this->locations[$lookingIndex]['name'];
        }        
        return $returnValue;
    }
    public function getProcessWithId($requestId){
        $returnValue = '';
        $lookingIndex = array_search($requestId, $this->array_column($this->process, 'processId'));
        if($lookingIndex !== FALSE){
            $returnValue = $this->process[$lookingIndex]['name'];
        }        
        return $returnValue;
    }
    public function getMassWithId($requestId){
        $returnValue = [];
        $id = $requestId;
        $query = "SELECT name FROM toolsmassconnection, toolsmassref WHERE toolsmassconnection.massId=toolsmassref.massId AND toolsmassconnection.hashId=$id";
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
        }
        else{
            if($result->num_rows > 0){
                $j = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$j] = array(
                        'name' => $row['name'],
                        'volume' => 0,
                        'refNok' => false,
                        'refOkNotAvailabel' => false,
                        'refOkAvailable' => true
                    );
                    $j++;
                }
            }
            $massCount = count($returnValue);
            for($i = 0; $i<$massCount; $i++){
                $searchMass = $returnValue[$i]['name'];
                $query = "SELECT SUM(total) AS volume FROM toolshighrunner WHERE massref='$searchMass'";
                $result = $this->sendQuery($query);
                if($result !== true){
                    $row = mysqli_fetch_assoc($result);
                    $returnValue[$i]['volume'] = intval($row['volume']);
                }
            }
        }
        return $returnValue;
    }
    public function getM20vWithId($requestId){
        $returnValue = [];
        $id = $requestId;
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $query = "SELECT name FROM toolsm20vconnection, toolsm20vref WHERE toolsm20vconnection.m20vId=toolsm20vref.m20vId AND toolsm20vconnection.hashId=$id";
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
        }
        else{
            if($result->num_rows > 0){
                $j = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$j] = array(
                        'name' => $row['name'],
                        'volume' => 0,
                        'refNok' => false,
                        'refOkNotAvailabel' => false,
                        'refOkAvailable' => true
                    );
                    $j++;
                }
            }
            $m20vCount = count($returnValue);
            for($i = 0; $i<$m20vCount; $i++){
                $searchM20v = $returnValue[$i]['name'];
                $query = "SELECT SUM(total) AS volume FROM toolshighrunner WHERE m20vref='$searchM20v'";
                $result = $this->sendQuery($query);
                if($result !== true){
                    $row = mysqli_fetch_assoc($result);
                    $returnValue[$i]['volume'] = intval($row['volume']);
                }
            }
        }
        return $returnValue;
    }
    public function getMassVolumeSum($massArray){
        $returnValue = NULL;
        $massCount = count($massArray);
        $sum = 0;
        for($i = 0; $i<$massCount; $i++){
            $sum = $sum + $massArray[$i]['volume'];
        }
        $returnValue = $sum;
        return $returnValue;
    }
    public function getM20vVolumeSum($m20vArray){
        $returnValue = NULL;
        $m20vCount = count($m20vArray);
        $sum = 0;
        for($i = 0; $i<$m20vCount; $i++){
            $sum = $sum + $m20vArray[$i]['volume'];
        }
        $returnValue = $sum;
        return $returnValue;
    }
    public function getRepairStatusWithId($requestId){
        $returnValue = '';
        $lookingIndex = array_search($requestId, $this->array_column($this->repairStatus, 'id'));
        if($lookingIndex !== FALSE){
            $returnValue = $this->repairStatus[$lookingIndex]['name'];
        }        
        return $returnValue;
    }
    public function getToolingStatusWithId($requestId){
        $returnValue = '';
        $lookingIndex = array_search($requestId, $this->array_column($this->toolingStatus, 'id'));
        if($lookingIndex !== FALSE){
            $returnValue = $this->toolingStatus[$lookingIndex]['name'];
        }        
        return $returnValue;
    }
    public function getToolingRunnerTypeWithVolume($volume){
        $returnValue = NULL;
        $query = "SELECT * FROM toolshighrunnerlimits";
        $result = $this->sendQuery($query);
        $runnersTypes = NULL;
        if($result !== true){
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                $runnersTypes[$i] = array(
                    'id' => intval($row['id']),
                    'name' => $row['name'],
                    'minlimit' => intval($row['minlimit']),
                    'maxlimit' => intval($row['maxlimit'])
                );
                $i++;
            }
            $runnersTypesCount = count($runnersTypes);
            for($i = 0; $i<$runnersTypesCount; $i++){
                if(($volume <= $runnersTypes[$i]['maxlimit']) && ($volume >= $runnersTypes[$i]['minlimit'])){
                    // thats my type
                    $returnValue = $runnersTypes[$i]['name'];
                    break;
                }
            }
        }
        return $returnValue;
    }
    private function getAllLocations(){
        // Without ID
        $returnValue = NULL;
        $tempValue = $this->array_column($this->locations, 'name');
        $returnValue = $this->createArrayWithName($tempValue);
        return $returnValue;
    }
    private function getAllProcesses(){
        // Without ID
        $returnValue = NULL;
        $tempValue = $this->array_column($this->process, 'name');
        $returnValue = $this->createArrayWithName($tempValue);
        return $returnValue;
    }
    private function getAllMassReferences(){
        // Without ID
        $returnValue = NULL;
        $tempValue = $this->array_column($this->mass, 'name');
        $returnValue = $this->createArrayWithName($tempValue);
        return $returnValue;
    }
    private function getAllM20vReferences(){
        // Without ID
        $returnValue = NULL;
        $tempValue = $this->array_column($this->m20v, 'name');
        $returnValue = $this->createArrayWithName($tempValue);
        return $returnValue;
    }
    private function createArrayWithName($array){
        $returnValue = NULL;
        $arrayCount = count($array);
        for($i=0; $i<$arrayCount; $i++){
            $returnValue[$i] = array(
                'name' => $array[$i]
            );
        }
        return $returnValue;
    }
    public function getLocationId($location){
        $returnValue = 0;
        $lookingIndex = array_search($location, $this->array_column($this->locations, 'name'));
        if($lookingIndex !== FALSE){
            $returnValue = $this->locations[$lookingIndex]['locationId'];
        }        
        return $returnValue;
    }
    public function getProcessId($process){
        $returnValue = 0;
        $lookingIndex = array_search($process, $this->array_column($this->process, 'name'));
        if($lookingIndex !== FALSE){
            $returnValue = $this->process[$lookingIndex]['processId'];
        }
        return $returnValue;
    }
    public function getMassId($mass){
        $returnValue = NULL;
        $lookingIndex = array_search($mass, $this->array_column($this->mass, 'name'));
        if($lookingIndex !== FALSE){
            $returnValue = $this->mass[$lookingIndex]['massId'];
        }        
        return $returnValue;
    }
    public function getM20vId($m20v){
        $returnValue = NULL;
        $lookingIndex = array_search($m20v, $this->array_column($this->m20v, 'name'));
        if($lookingIndex !== FALSE){
            $returnValue = $this->m20v[$lookingIndex]['m20vId'];
        }        
        return $returnValue;
    }
    public function getRepairStatusId($repairStatus){
        $returnValue = 0;
        $lookingIndex = array_search($repairStatus, $this->array_column($this->repairStatus, 'name'));
        if($lookingIndex !== FALSE){
            $returnValue = $this->repairStatus[$lookingIndex]['id'];
        }        
        return $returnValue;
    }
    public function getToolingStatusId($toolingStatus){
        $returnValue = 0;
        $lookingIndex = array_search($toolingStatus, $this->array_column($this->toolingStatus, 'name'));
        if($lookingIndex !== FALSE){
            $returnValue = $this->toolingStatus[$lookingIndex]['id'];
        }        
        return $returnValue;
    }
    public function setToolingStatusWithId($toolingId, $status){
        $returnValue = true;
        $newToolStatus = $this->getToolingStatusId($status);
        $query = "UPDATE "
                ."toolstoolinglist "
                ."SET status=$newToolStatus "
                ."WHERE hashId=$toolingId";
        $result = $this->sendQuery($query);
        $returnValue = $result;
        return $returnValue;
    }
    public function addToolingToDB($tooling){
        $returnValue = true;
        //$tooling = array(
        //    'hashNo' => $row['hashId'],
        //    'toolNo' => $row['toolingNo'],
        //    'oldToolNo' => $row['oldToolingNo'],
        //    'process' => $row['processId'],
        //    'location' => $row['locationId'],
        //    'path' => $row['path'],
        //    'attention' => $row['attention'],
        //    'isCollapsed' => true,
        //    'addDate' => $row['addDate'],
        //    'lastEditDate' => $row['lastEditDate']
        //);
        $hashId = $this->getNumberFromHashId($tooling['hashNo']);
        $toolNo = $tooling['toolNo'];
        $oldToolNo = $tooling['oldToolNo'];
        $location = $this->getLocationId($tooling['location']);
        $process = $this->getProcessId($tooling['process']);        
        //$path = addslashes($tooling['path']);
        $path = $tooling['path'];
        $attention = $tooling['attention'];
        $isDeleted = 0;
        $addDate = date("Y-m-d G:i:s");
        $lastEditDate = '';
        $mass = $tooling['mass'];
        $m20v = $tooling['m20v'];
        $status = $this->getToolingStatusId($this->toolingDefaultStatus); // $tooling['status']
        $numberoftoolings = $tooling['numberoftoolings'];

        $query = "INSERT INTO "
                ."toolstoolinglist "
                ."(hashId, toolingNo, oldToolingNo, locationId, processId, path, attention, isDeleted, addDate, lastEditDate, status, numberoftoolings) "
                ."VALUES "
                ."($hashId, '$toolNo', '$oldToolNo', $location, $process, '$path', '$attention', $isDeleted, '$addDate', '$lastEditDate', $status, $numberoftoolings)";
        //echo $query;
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
            $returnValue = false;
        }
        if($returnValue){
            $returnValue = $this->addMassToDB($mass, $hashId);
        }
        if($returnValue){
            $returnValue = $this->addM20vToDB($m20v, $hashId);
        }
        return $returnValue;
    }
    public function updateToolingtoDB($tooling){
        $returnValue = true;

        $hashId = $this->getNumberFromHashId($tooling['hashNo']);
        $toolNo = $tooling['toolNo'];
        $oldToolNo = $tooling['oldToolNo'];
        $location = $this->getLocationId($tooling['location']);
        $process = $this->getProcessId($tooling['process']);        
        $path = $tooling['path'];
        $attention = $tooling['attention'];
        $isDeleted = 0;
        $addDate = $tooling['addDate'];
        $lastEditDate = date("Y-m-d G:i:s");
        $mass = $tooling['mass'];
        $m20v = $tooling['m20v'];
        $status = $this->getToolingStatusId($tooling['status']); //Dostêpne
        $numberoftoolings = $tooling['numberoftoolings'];

        $query = "UPDATE "
                ."toolstoolinglist "
                ."SET toolingNo='$toolNo', oldToolingNo='$oldToolNo', locationId=$location, processId=$process, "
                ."path='$path', attention='$attention', isDeleted=$isDeleted, addDate='$addDate', lastEditDate='$lastEditDate', "                
                ."status=$status, numberoftoolings=$numberoftoolings "
                ."WHERE hashId=$hashId";

        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
            $returnValue = false;
        }
        if($returnValue){
            $returnValue = $this->addMassToDB($mass, $hashId);
        }
        if($returnValue){
            $returnValue = $this->addM20vToDB($m20v, $hashId);
        }
        return $returnValue;
    }
    public function deleteToolingWithId($id){
        $returnValue = true;
        $idToDelete = $this->getNumberFromHashId($id);
        $lastEditDate = date("Y-m-d G:i:s");
        $query = "UPDATE toolstoolinglist SET isDeleted=1, lastEditDate='$lastEditDate' WHERE hashId = $idToDelete";
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
            $returnValue = false;
        }
        return $returnValue;
    }
    private function addMassToDB($mass, $hashId){        
        $returnValue = true;
        // First delete rows from this hashId
        $query = "DELETE FROM toolsmassconnection WHERE hashId = $hashId";
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
            $returnValue = false;
        }
        else{
            // Query OK
            // Next add new references IDs
            $massNumber = count($mass);
            for($i=0; $i<$massNumber; $i++){
                $massId = $this->getMassId($mass[$i]->name);
                $query = "INSERT INTO toolsmassconnection (hashId, massId) VALUES ($hashId, $massId)";
                mysqli_query($this->conn, "SET NAMES 'utf8'");
                $result = $this->conn->query($query);
                if(!$result){
                    SafeFunction::mysql_fatal_error($result->error);
                    $returnValue = false;
                }
            }
        }
        return $returnValue;
    }
    private function addM20vToDB($m20v, $hashId){
        $returnValue = true;
        // First delete rows from this hashId
        $query = "DELETE FROM toolsm20vconnection WHERE hashId = $hashId";
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
            $returnValue = false;
        }
        else{
            // Query OK
            // Next add new references IDs
            $m20vNumber = count($m20v);
            for($i=0; $i<$m20vNumber; $i++){
                $m20vId = $this->getM20vId($m20v[$i]->name);
                $query = "INSERT INTO toolsm20vconnection (hashId, m20vId) VALUES ($hashId, $m20vId)";
                mysqli_query($this->conn, "SET NAMES 'utf8'");
                $result = $this->conn->query($query);
                if(!$result){
                    SafeFunction::mysql_fatal_error($result->error);
                    $returnValue = false;
                }
            }
        }
        return $returnValue;
    }

    public function addNewMass($mass){
        $returnValue = NULL;
        $query = "INSERT INTO toolsmassref (massId, name) VALUES (NULL, '$mass')";
        $result = $this->sendQuery($query);
        $returnValue = $result;
        return $returnValue;
    }
    public function addNewM20v($m20v){
        $returnValue = NULL;
        $query = "INSERT INTO toolsm20vref (m20vId, name) VALUES (NULL, '$m20v')";
        $result = $this->sendQuery($query);
        $returnValue = $result;
        return $returnValue;
    }
    public function addNewLocation($location){
        $returnValue = NULL;
        $query = "INSERT INTO toolslocations (locationId, name) VALUES (NULL, '$location')";
        $result = $this->sendQuery($query);
        $returnValue = $result;
        return $returnValue;
    }
    public function addNewProcess($process){
        $returnValue = NULL;
        $query = "INSERT INTO toolsprocess (processId, name) VALUES (NULL, '$process')";
        $result = $this->sendQuery($query);
        $returnValue = $result;
        return $returnValue;
    }

    public function getToolingList(){
        $returnValue = NULL;
        $query = "SELECT * FROM toolstoolinglist WHERE isDeleted=0 ORDER BY hashId DESC";
        mysqli_query($this->conn, "SET NAMES 'utf8'");
        $result = $this->conn->query($query);
        if(!$result){
            SafeFunction::mysql_fatal_error($result->error);
        }
        else{
            if($result->num_rows > 0){
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$i] = array(
                        'hashNo' => $row['hashId'],
                        'toolNo' => $row['toolingNo'],
                        'oldToolNo' => $row['oldToolingNo'],
                        'process' => $row['processId'],
                        'location' => $row['locationId'],
                        'path' => $row['path'],
                        'attention' => $row['attention'],
                        'isCollapsed' => true,
                        'repairIsCollapsed' => true,
                        'addDate' => $row['addDate'],
                        'lastEditDate' => $row['lastEditDate'],
                        'status' => $row['status'],
                        'numberoftoolings' => intval($row['numberoftoolings'])
                    );
                    $i++;
                }
            }
        }
        //print_r($returnValue);
        // I had list without locations name, process name and references
        $returnCount = count($returnValue);
        for($i = 0; $i < $returnCount; $i++){
            //$returnValue[$i]['hashNo'] = intval($returnValue[$i]['hashNo']);
            $returnValue[$i]['hashNo'] = "#".$returnValue[$i]['hashNo'];
            $location = $returnValue[$i]['location'];
            $returnValue[$i]['location'] = $this->getLocationWithId($location);
            $process = $returnValue[$i]['process'];
            $returnValue[$i]['process'] = $this->getProcessWithId($process);
            $statusId = $returnValue[$i]['status'];
            $returnValue[$i]['status'] = $this->getToolingStatusWithId($statusId);
            $id = $this->getNumberFromHashId($returnValue[$i]['hashNo']);
            $returnValue[$i]['mass'] = $this->getMassWithId($id);
            $returnValue[$i]['massVolumeSum'] = $this->getMassVolumeSum($returnValue[$i]['mass']);
            $returnValue[$i]['massRunner'] = $this->getToolingRunnerTypeWithVolume($returnValue[$i]['massVolumeSum']);
            $returnValue[$i]['m20v'] = $this->getM20vWithId($id);
            $returnValue[$i]['m20vVolumeSum'] = $this->getM20vVolumeSum($returnValue[$i]['m20v']);
            $returnValue[$i]['m20vRunner'] = $this->getToolingRunnerTypeWithVolume($returnValue[$i]['m20vVolumeSum']);
            $returnValue[$i]['repairList'] = $this->getRepairListWithId($id);
        }       
        //print_r($returnValue);
        return $returnValue;
    }
    private function getNumberFromHashId($hashId){
        $returnValue = null;
        $hashPosition = strpos($hashId, '#');
        if($hashPosition !== false){
            // We faund hash number so we must erase hash sign
            $returnValue = intval(substr($hashId, $hashPosition+1));
        }
        else{
            $returnValue = intval($hashId);
        }
        return $returnValue;
    }
    public function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( !array_key_exists($columnKey, $value)) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( !array_key_exists($indexKey, $value)) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }

    public function getRepairList(){
        $returnValue = NULL;
        $query = "SELECT * FROM toolsrepairhistory";
        $user = new UserData($this->conn);
        $result = $this->sendQuery($query);
        if($result !== NULL){
            if($result !== true){
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$i] = array(
                        'id' => intval($row['id']),
                        'hashId' => $row['hashId'],
                        'partdesc' => $row['partdesc'],
                        'failuredesc' => $row['failuredesc'],
                        'repairdesc' => $row['repairdesc'],
                        'breakdownDate' => $row['breakdownDate'],
                        'repairDate' => $row['repairDate'],
                        'estimatedRepairDate' => $row['estimatedRepairDate'],
                        'lastedit' => $row['lastedit'],
                        'status' => $this->getRepairStatusWithId($row['statusid']),
                        'lastEditor' => $user->getUserFullNameWithId($row['lastEditorId']),
                        'pickupDate' => $row['pickupDate'],
                        'machineArea' => intval($row['machineArea']),
                        'machineId' => intval($row['machineId']),
                        'isCollapsed' => true
                    );
                    $i++;
                }
            }            
        }
        return $returnValue;
    }
    private function getRepairListWithId($hashNo){
        $returnValue = NULL;
        $query = "SELECT * FROM toolsrepairhistory WHERE hashId=$hashNo";
        $user = new UserData($this->conn);
        $result = $this->sendQuery($query);
        if($result !== NULL){
            if($result !== true){
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$i] = array(
                        'id' => intval($row['id']),
                        'hashId' => $row['hashId'],
                        'partdesc' => $row['partdesc'],
                        'failuredesc' => $row['failuredesc'],
                        'repairdesc' => $row['repairdesc'],
                        'breakdownDate' => $row['breakdownDate'],
                        'repairDate' => $row['repairDate'],
                        'estimatedRepairDate' => $row['estimatedRepairDate'],
                        'lastedit' => $row['lastedit'],
                        'status' => $this->getRepairStatusWithId($row['statusid']),
                        'lastEditor' => $user->getUserFullNameWithId($row['lastEditorId']),
                        'pickupDate' => $row['pickupDate'],
                        'machineArea' => $row['machineArea'],
                        'machineId' => $row['machineId'],
                        'isCollapsed' => true
                    );
                    $i++;
                }
            }            
        }
        return $returnValue;
    }
    private function isToolingWithIdInRepair($hashNo){
        $returnValue = NULL;
        $repairStatusId = $this->getRepairStatusId($this->repairDefaultStatus);
        $query = "SELECT * FROM toolsrepairhistory WHERE hashId=$hashNo AND statusid=$repairStatusId";
        $result = $this->sendQuery($query);
        if($result !== true){
            // There are some results
            if(mysqli_num_rows($result) > 0){
                // Tooling still during repair
                $returnValue = true;
            }
            else{
                // Tooling have no active repairs
                $returnValue = false;
            }
        }
        else{
            // Query returns TRUE so there are no rows in results
            $returnValue = false;
        }
        return $returnValue;
    }
    public function addRepair($repairData){
        $returnValue = true;
        $hashId = $this->getNumberFromHashId($repairData['hashId']);
        $partdesc = $repairData['partdesc'];
        $failuredesc = $repairData['failuredesc'];
        $repairdesc = $repairData['repairdesc'];
        $breakdownDate = date("Y-m-d G:i:s");
        $repairDate = '';
        $estimatedRepairDate = $repairData['estimatedRepairDate'];
        $lastedit = '';
        $statusid = $this->getRepairStatusId($repairData['status']);     

        $user = new UserData($this->conn);
        $userId = $user->getUserId();
        $pickupDate = '';

        $query = "INSERT INTO "
                ."toolsrepairhistory "
                ."(id, hashId, partdesc, failuredesc, repairdesc, breakdownDate, repairDate, estimatedRepairDate, lastedit, statusid, lastEditorId, pickupDate) "
                ."VALUES "
                ."(NULL, $hashId, '$partdesc', '$failuredesc', '$repairdesc', '$breakdownDate', '$repairDate', '$estimatedRepairDate', '$lastedit', $statusid, $userId, '$pickupDate')";

        $result = $this->sendQuery($query);
        if($result){
            $result = $this->setToolingStatusWithId($hashId, $this->toolingRepairStatus);
        }
        $returnValue = $result;
        return $returnValue;
    }
    public function updateRepair($repairData){
        $returnValue = true;
        $id = $repairData['id'];
        $hashId = $this->getNumberFromHashId($repairData['hashId']);
        $partdesc = $repairData['partdesc'];
        $failuredesc = $repairData['failuredesc'];
        $repairdesc = $repairData['repairdesc'];
        $breakdownDate = $repairData['breakdownDate'];
        $repairDate = $repairData['repairDate'];
        $estimatedRepairDate = $repairData['estimatedRepairDate'];
        $lastedit = date("Y-m-d G:i:s");
        $statusid = $this->getRepairStatusId($repairData['status']);

        $user = new UserData($this->conn);
        $userId = $user->getUserId();
        $pickupDate = $repairData['pickupDate'];

        $query = "UPDATE "
                ."toolsrepairhistory "
                ."SET hashId=$hashId, partdesc='$partdesc', failuredesc='$failuredesc', repairdesc='$repairdesc', breakdownDate='$breakdownDate', "
                ."repairDate='$repairDate', estimatedRepairDate='$estimatedRepairDate', lastedit='$lastedit', statusid=$statusid, "
                ."lastEditorId=$userId, pickupDate='$pickupDate' "
                ."WHERE id=$id";

        $result = $this->sendQuery($query);
        $returnValue = $result;
        return $returnValue;
    }
    public function finishRepair($repairData){
        $returnValue = true;
        $id = $repairData['id'];
        $hashId = $this->getNumberFromHashId($repairData['hashId']);
        $partdesc = $repairData['partdesc'];
        $failuredesc = $repairData['failuredesc'];
        $repairdesc = $repairData['repairdesc'];
        $breakdownDate = $repairData['breakdownDate'];
        $repairDate = date("Y-m-d G:i:s");
        $estimatedRepairDate = $repairData['estimatedRepairDate'];
        $lastedit = date("Y-m-d G:i:s");
        $statusid = $this->getRepairStatusId($repairData['status']);

        $user = new UserData($this->conn);
        $userId = $user->getUserId();
        $pickupDate = $repairData['pickupDate'];

        $query = "UPDATE "
                ."toolsrepairhistory "
                ."SET hashId=$hashId, partdesc='$partdesc', failuredesc='$failuredesc', repairdesc='$repairdesc', breakdownDate='$breakdownDate', "
                ."repairDate='$repairDate', estimatedRepairDate='$estimatedRepairDate', lastedit='$lastedit', statusid=$statusid, "
                ."lastEditorId=$userId, pickupDate='$pickupDate' "
                ."WHERE id=$id";

        $result = $this->sendQuery($query);
        // Check if there are some other active repairs
        if($result){
            $result = $this->isToolingWithIdInRepair($hashId);
            if($result !== NULL){
                // query did not return TRUE
                if(!$result){
                    // Tooling have no other repairs
                    $result = $this->setToolingStatusWithId($hashId, $this->toolingFinishedStatus);
                }                
            }
        }
        $returnValue = $result;
        return $returnValue;
    }
    public function pickupRepair($repairData){
        $returnValue = true;
        $id = $repairData['id'];
        $hashId = $this->getNumberFromHashId($repairData['hashId']);
        $partdesc = $repairData['partdesc'];
        $failuredesc = $repairData['failuredesc'];
        $repairdesc = $repairData['repairdesc'];
        $breakdownDate = $repairData['breakdownDate'];
        $repairDate = $repairData['repairDate'];
        $estimatedRepairDate = $repairData['estimatedRepairDate'];
        $lastedit = date("Y-m-d G:i:s");
        $statusid = $this->getRepairStatusId($repairData['status']);

        $user = new UserData($this->conn);
        $userId = $user->getUserId();
        $pickupDate = date("Y-m-d G:i:s");

        $query = "UPDATE "
                ."toolsrepairhistory "
                ."SET hashId=$hashId, partdesc='$partdesc', failuredesc='$failuredesc', repairdesc='$repairdesc', breakdownDate='$breakdownDate', "
                ."repairDate='$repairDate', estimatedRepairDate='$estimatedRepairDate', lastedit='$lastedit', statusid=$statusid, "
                ."lastEditorId=$userId, pickupDate='$pickupDate' "
                ."WHERE id=$id";

        $result = $this->sendQuery($query);
        // Check if there are some other active repairs
        if($result){
            $result = $this->isToolingWithIdInRepair($hashId);
            if($result !== NULL){
                // query did not return TRUE
                if(!$result){
                    // Tooling have no other repairs
                    $result = $this->setToolingStatusWithId($hashId, $this->toolingDefaultStatus);
                }                
            }
        }
        $returnValue = $result;
        return $returnValue;
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