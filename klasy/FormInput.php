<?php
class FormInput{
    public $name;
    public $value;
    public $type;
    public $description;
    public $required;
    function __construct($name,$description='',$value='',$type='text',$required=true){
        $this->name=$name;
        $this->description=$description;
        $this->value=$value;
        $this->type=$type;
        $this->required=$required;
    }
    function getInputHTML(){
        return "<input type='$this->type' name='$this->name' value='$this->value'>"; 
    }
}