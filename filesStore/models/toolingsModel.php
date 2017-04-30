<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once "./login.php";

// Connection to database
$conn = new mysqli($hn, $un, $pw, $db);
// Get parameters from request
$params = json_decode(file_get_contents('php://input'));
$dirtyRequestType = $params->query;
$dirtyRequestData = $params->data;

$returnValue = NULL;

if($conn->connect_error){
    SafeFunction::mysql_fatal_error($conn->connect_error);
}
else{
    $safeObj = new SafeFunction($conn);
    // Clear request type
    $requestType;
    $queryData;
    if(isset($dirtyRequestType)){
        $requestType = $safeObj->clear_text($dirtyRequestType);
    }
    // Create tooling object
    $toolObj = new ToolingData($conn);
    // Check request type
    switch($requestType){
        case 'checkHashId':
            // Clear request data
            $requestData = NULL;
            $requestData['key'] = $safeObj->clear_text($dirtyRequestData[0]->key);
            $requestData['value'] = $safeObj->clear_text($dirtyRequestData[0]->value);
            if($requestData['key'] =="hashId"){
                $returnValue['idIsUnique'] = $toolObj->checkHashId($requestData['value']);
            }
            else{
                $returnValue['idIsUnique'] = "Wrong hash Id number";
            }
            break;
        case 'getToolingLocations':
            $returnValue['locations'] = $toolObj->getToolingLocations();
            break;
        case 'getProcessTypes':
            $returnValue['process'] = $toolObj->getProcessTypes();
            break;
        case 'getMassReferences':
            $returnValue['reference'] = $toolObj->getMassReferences();
            break;
        case 'getM20vReferences':
            $returnValue['reference'] = $toolObj->getM20vReferences();
            break;
        case 'getToolingList':
            $returnValue['toolingList'] = $toolObj->getToolingList();
            break;
        case 'getModalLists':
            $returnValue['modalLists'] = $toolObj->getModalLists();
            break;
        case 'getM20VListWithRunner':
            $returnValue['m20vRunnerList'] = $toolObj->getM20VListWithRunner();
            break;
        case 'addTooling':
            // Clear request data
            $requestData['hashNo'] = $safeObj->clear_text($dirtyRequestData->hashNo);
            $requestData['toolNo'] = $safeObj->clear_text($dirtyRequestData->toolNo);
            $requestData['oldToolNo'] = $safeObj->clear_text($dirtyRequestData->oldToolNo);
            $requestData['location'] = $safeObj->clear_text($dirtyRequestData->location);
            $requestData['process'] = $safeObj->clear_text($dirtyRequestData->process);
            $requestData['path'] = $safeObj->clear_text($dirtyRequestData->path);
            $requestData['attention'] = $safeObj->clear_text($dirtyRequestData->attention);
            $requestData['isCollapsed'] = $safeObj->clear_text($dirtyRequestData->isCollapsed);
            $requestData['addDate'] = $safeObj->clear_text($dirtyRequestData->addDate);
            $requestData['lastEditDate'] = $safeObj->clear_text($dirtyRequestData->addDate);
            $requestData['mass'] = $safeObj->clear_text($dirtyRequestData->mass);
            $requestData['m20v'] = $safeObj->clear_text($dirtyRequestData->m20v);
            $requestData['status'] = $safeObj->clear_text($dirtyRequestData->status);
            $requestData['numberoftoolings'] = $safeObj->clear_text($dirtyRequestData->numberoftoolings);

            $returnValue['feedback'] = $toolObj->addToolingToDB($requestData);
            break;
        case 'editTooling':
            // Clear request data
            $requestData['hashNo'] = $safeObj->clear_text($dirtyRequestData->hashNo);
            $requestData['toolNo'] = $safeObj->clear_text($dirtyRequestData->toolNo);
            $requestData['oldToolNo'] = $safeObj->clear_text($dirtyRequestData->oldToolNo);
            $requestData['location'] = $safeObj->clear_text($dirtyRequestData->location);
            $requestData['process'] = $safeObj->clear_text($dirtyRequestData->process);
            $requestData['path'] = $safeObj->clear_text($dirtyRequestData->path);
            $requestData['attention'] = $safeObj->clear_text($dirtyRequestData->attention);
            $requestData['isCollapsed'] = $safeObj->clear_text($dirtyRequestData->isCollapsed);
            $requestData['addDate'] = $safeObj->clear_text($dirtyRequestData->addDate);
            $requestData['lastEditDate'] = $safeObj->clear_text($dirtyRequestData->addDate);
            $requestData['mass'] = $safeObj->clear_text($dirtyRequestData->mass);
            $requestData['m20v'] = $safeObj->clear_text($dirtyRequestData->m20v);
            $requestData['status'] = $safeObj->clear_text($dirtyRequestData->status);
            $requestData['numberoftoolings'] = $safeObj->clear_text($dirtyRequestData->numberoftoolings);

            $returnValue['feedback'] = $toolObj->updateToolingtoDB($requestData);            
            break;
        case 'deleteTooling':
            $idToDelete = $safeObj->clear_text($dirtyRequestData->idToDelete);

            $returnValue['feedback'] = $toolObj->deleteToolingWithId($idToDelete);
            break;
        case 'getRepairList':            
            $returnValue['repairList'] = $toolObj->getRepairList();
            break;
        case 'addRepair':
            $requestData['hashId'] = $safeObj->clear_text($dirtyRequestData->hashId);
            $requestData['partdesc'] = $safeObj->clear_text($dirtyRequestData->partdesc);
            $requestData['failuredesc'] = $safeObj->clear_text($dirtyRequestData->failuredesc);
            $requestData['repairdesc'] = $safeObj->clear_text($dirtyRequestData->repairdesc);
            $requestData['breakdownDate'] = $safeObj->clear_text($dirtyRequestData->breakdownDate);
            $requestData['repairDate'] = $safeObj->clear_text($dirtyRequestData->repairDate);
            $requestData['estimatedRepairDate'] = $safeObj->clear_text($dirtyRequestData->estimatedRepairDate);
            $requestData['lastedit'] = $safeObj->clear_text($dirtyRequestData->lastedit);
            $requestData['status'] = $safeObj->clear_text($dirtyRequestData->status);
            //$requestData['pickupDate'] = $safeObj->clear_text($dirtyRequestData->pickupDate);

            $returnValue['feedback'] = $toolObj->addRepair($requestData);
            break;
        case 'updateRepair':
            $requestData['id'] = $safeObj->clear_text($dirtyRequestData->id);
            $requestData['hashId'] = $safeObj->clear_text($dirtyRequestData->hashId);
            $requestData['partdesc'] = $safeObj->clear_text($dirtyRequestData->partdesc);
            $requestData['failuredesc'] = $safeObj->clear_text($dirtyRequestData->failuredesc);
            $requestData['repairdesc'] = $safeObj->clear_text($dirtyRequestData->repairdesc);
            $requestData['breakdownDate'] = $safeObj->clear_text($dirtyRequestData->breakdownDate);
            $requestData['repairDate'] = $safeObj->clear_text($dirtyRequestData->repairDate);
            $requestData['estimatedRepairDate'] = $safeObj->clear_text($dirtyRequestData->estimatedRepairDate);
            $requestData['lastedit'] = $safeObj->clear_text($dirtyRequestData->lastedit);
            $requestData['status'] = $safeObj->clear_text($dirtyRequestData->status);
            $requestData['pickupDate'] = $safeObj->clear_text($dirtyRequestData->pickupDate);

            $returnValue['feedback'] = $toolObj->updateRepair($requestData);
            break;
        case 'finishRepair':
            $requestData['id'] = $safeObj->clear_text($dirtyRequestData->id);
            $requestData['hashId'] = $safeObj->clear_text($dirtyRequestData->hashId);
            $requestData['partdesc'] = $safeObj->clear_text($dirtyRequestData->partdesc);
            $requestData['failuredesc'] = $safeObj->clear_text($dirtyRequestData->failuredesc);
            $requestData['repairdesc'] = $safeObj->clear_text($dirtyRequestData->repairdesc);
            $requestData['breakdownDate'] = $safeObj->clear_text($dirtyRequestData->breakdownDate);
            $requestData['repairDate'] = $safeObj->clear_text($dirtyRequestData->repairDate);
            $requestData['estimatedRepairDate'] = $safeObj->clear_text($dirtyRequestData->estimatedRepairDate);
            $requestData['lastedit'] = $safeObj->clear_text($dirtyRequestData->lastedit);
            $requestData['status'] = $safeObj->clear_text($dirtyRequestData->status);
            $requestData['pickupDate'] = $safeObj->clear_text($dirtyRequestData->pickupDate);

            $returnValue['feedback'] = $toolObj->finishRepair($requestData);
            break;
        case 'pickupRepair':            
            $requestData['id'] = $safeObj->clear_text($dirtyRequestData->id);
            $requestData['hashId'] = $safeObj->clear_text($dirtyRequestData->hashId);
            $requestData['partdesc'] = $safeObj->clear_text($dirtyRequestData->partdesc);
            $requestData['failuredesc'] = $safeObj->clear_text($dirtyRequestData->failuredesc);
            $requestData['repairdesc'] = $safeObj->clear_text($dirtyRequestData->repairdesc);
            $requestData['breakdownDate'] = $safeObj->clear_text($dirtyRequestData->breakdownDate);
            $requestData['repairDate'] = $safeObj->clear_text($dirtyRequestData->repairDate);
            $requestData['estimatedRepairDate'] = $safeObj->clear_text($dirtyRequestData->estimatedRepairDate);
            $requestData['lastedit'] = $safeObj->clear_text($dirtyRequestData->lastedit);
            $requestData['status'] = $safeObj->clear_text($dirtyRequestData->status);
            $requestData['pickupDate'] = $safeObj->clear_text($dirtyRequestData->pickupDate);
            
            $returnValue['feedback'] = $toolObj->pickupRepair($requestData);
            break;
        case 'addNewMass':
            $requestData = $safeObj->clear_text($dirtyRequestData);

            $returnValue['feedback'] = $toolObj->addNewMass($requestData);
            break;
        case 'addNewM20v':
            $requestData = $safeObj->clear_text($dirtyRequestData);

            $returnValue['feedback'] = $toolObj->addNewM20v($requestData);
            break;
        case 'addNewLocation':
            $requestData = $safeObj->clear_text($dirtyRequestData);

            $returnValue['feedback'] = $toolObj->addNewLocation($requestData);
            break;
        case 'addNewProcess':
            $requestData = $safeObj->clear_text($dirtyRequestData);

            $returnValue['feedback'] = $toolObj->addNewProcess($requestData);
            break;
    }
}
$conn->close();
echo json_encode($returnValue);
?>