<?php
class Reference{
    
    private $conn;
    private $refName;
    private $references;
    private $flow;
    private $volume;
    private $volType;
    private $toolings;
    private $toolingsCount;

    function __construct($conn, $newRefName){
        $this->conn = $conn;
        $this->refName = $newRefName;

        // pobranie sumarycznego wolumenu dla danej referencji
        $volAndFlow = $this->getSummaryVolumeForReference($this->refName);
        //print_r($volAndFlow);
        $this->volume = $volAndFlow['volume'];
        $this->flow = $volAndFlow['flow'];
        // ustalenie typu runnera po wolumenie sumarycznym
        $this->volType = $this->getRunnerTypeWithVolume($this->volume);
        // Pobranie listy referencji MASS dla referencji finalowej i odwrotnie
        $this->references = $this->getOtherReferencesForRefName($this->refName);
        // Pobranie typu procesu, numeru hash, numeru narzedzia i statusu dla danej referencji
        $this->toolings = $this->getToolingsDataForRefName($this->refName);
        $this->toolingsCount = count($this->toolings);
    }

    public function getCompleteReference(){
        $returnValue['refName'] = $this->getRefName();
        $returnValue['references'] = $this->getReferences();
        $returnValue['flow'] = $this->getFlow();
        $returnValue['volume'] = $this->getVolume();
        $returnValue['volType'] = $this->getVolType();
        $returnValue['toolings'] = $this->getToolings();
        $returnValue['toolingsCount'] = $this->getToolingsCount();
        //print_r($returnValue);
        return $returnValue;
    }
    public function getRefName(){
        return $this->refName;
    }
    public function getReferences(){
        return $this->references;
    }
    public function getFlow(){
        return $this->flow;
    }
    public function getVolume(){
        return $this->volume;
    }
    public function getVolType(){
        return $this->volType;
    }
    public function getToolings(){
        return $this->toolings;
    }
    public function getToolingsCount(){
        return $this->toolingsCount;
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
    private function getSummaryVolumeForReference($reference){
        $returnValue = NULL;
        $query = "SELECT m20vref, SUM(total) as volume, m20v "
                ."FROM toolshighrunner "
                ."WHERE m20vref='$reference'";
        $result = $this->sendQuery($query);
        if($result !== NULL){
            if($result !== true){
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue = array(
                        'volume' => intval($row['volume']),
                        'flow' => $row['m20v']
                    );
                    $i++;
                }
            }
        }
        return $returnValue;
    }
    private function getRunnerTypeWithVolume($volume){
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
    private function getOtherReferencesForRefName($newRefName){
        $returnValue = [];
        $query = "SELECT DISTINCT massref "
                ."FROM `toolshighrunner` "
                ."WHERE m20vref='$newRefName'";
        $result = $this->sendQuery($query);
        if($result !== NULL){
            if($result !== true){
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$i] = array(
                        'name' => $row['massref']
                    );
                    $i++;
                }
            }
        }
        return $returnValue;
    }
    private function getToolingsDataForRefName($newRefName){
        $returnValue = [];
        $query = "SELECT toolsprocess.name as processType, toolstoolinglist.hashId as hashNo, "
                       ."toolstoolinglist.toolingNo, toolsstatus.name as toolingStatus "
                ."FROM toolstoolinglist, toolsm20vconnection, toolsm20vref, toolsstatus, toolsprocess "
                ."WHERE toolsm20vref.name='$newRefName' AND toolstoolinglist.hashId=toolsm20vconnection.hashId "
                       ."AND toolsm20vconnection.m20vId=toolsm20vref.m20vId AND toolsstatus.id=toolstoolinglist.status "
                       ."AND toolstoolinglist.processId=toolsprocess.processId";
        $result = $this->sendQuery($query);
        if($result !== NULL){
            if($result !== true){
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $returnValue[$i] = array(
                        'processType' => $row['processType'],
                        'hashNo' => $row['hashNo'],
                        'toolingNo' => $row['toolingNo'],
                        'toolingStatus' => $row['toolingStatus']
                    );
                    $i++;
                }
            }
        }
        return $returnValue;
    }
}

?>