<?php
class FormInput{
    public $name;
    public $value;
    public $type;
    public $description;
    public $required;
    function __construct($name,$description='',$value='',$type='text'){
        $this->name=$name;
        $this->description=$description;
        $this->value=$value;
        $this->type=$type;
    }
    function getInputHTML(){
        return "<input name='$this->name' description='$this->description' value='$this->value' type='$this->type'>"; 
    }
}