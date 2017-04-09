<?php
class SimpleObj{
    private $key;
    private $value;
    private $name;

    public function getKey(){
        return $this->key;
    }
    public function getValue(){
        return $this->value;
    }
    public function getName(){
        return $this->name;
    }
    public function setKey($newKey){
        $this->key = $newKey;
    }
    public function setValue($newValue){
        $this->value = $newValue;
    }
    public function setName($newName){
        $this->name = $newName;
    }
}
?>