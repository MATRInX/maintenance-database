<?php
class Tooling{
        private $hashNo;
        private $toolNo;
        private $oldToolNo;
        private $process;
        private $location;
        private $path;
        private $attention;
        private $isCollapsed;
        private $addDate;
        private $lastEditDate;

        function __construct($toolingObject){
            $this->hashNo = $toolingObject->hashNo;
            $this->toolNo = $toolingObject->toolNo;
            $this->oldToolNo = $toolingObject->oldToolNo;
            $this->process = $toolingObject->process;
            $this->location = $toolingObject->location;
            $this->path = $toolingObject->path;
            $this->attention = $toolingObject->attention;
            $this->isCollapsed = $toolingObject->isCollapsed;
            $this->addDate = $toolingObject->addDate;
            $this->lastEditDate = $toolingObject->lastEditDate;
        }

        public function getHashNo(){
            return $this->hashNo;
        }
        public function setHashNo($newHashNo){
            $this->hashNo = $newHashNo;
        }
        
        public function getToolNo(){
            return $this->toolNo;
        }
        public function setToolNo($newToolNo){
            $this->toolNo = $newToolNo;
        }

        public function getOldToolNo(){
            return $this->oldToolNo;
        }
        public function setOldToolNo($newOldToolNo){
            $this->oldToolNo = $newToolNo;
        }

        public function getProcess(){
            return $this->process;
        }
        public function setProcess($newProcess){
            $this->process = $newProcess;
        }

        public function getLocation(){
            return $this->location;
        }
        public function setLocation($newLocation){
            $this->location = $newLocation;
        }

        public function getPath(){
            return $this->path;
        }
        public function setPath($newPath){
            $this->path - $newPath;
        }

        public function getAttention(){
            return $this->attention;
        }
        public function setAttention($newAttention){
            $this->attention = $newAttention;
        }

        public function getIsCollapsed(){
            return $this->isCollapsed;
        }
        public function setIsCollapsed($newIsCollapsed){
            $this->isCollapsed = $newIsCollapsed;
        }

        public function getAddDate(){
            return $this->addDate;
        }
        public function setAddDate($newAddDate){
            $this->addDate = $newAddDate;
        }

        public function getLastEditDate(){
            return $this->lastEditDate;
        }
        public function setLastEditDate($newLastEditDate){
            $this->lastEditDate = $newLastEditDate;
        }
}
?>