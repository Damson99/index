<?php
class BasketItem{
    public $id;
    public $cena;
    public $ile;    
    function __construct($id,$cena,$ile){
        $this->id=$id;
        $this->cena=$cena;
        $this->ile=$ile;
    }
}