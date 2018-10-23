<?php 
class User{
    public $id;
    public $nazwa;
    public $przywileje;
    
    function __construct($id,$nazwa){
        $this->id=$id;
        $this->nazwa=$nazwa;
        $this->przywileje=array();
    }
}