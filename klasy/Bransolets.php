<?php
class Bransolets{
    private $dbo=null;
    function __construct($dbo){
        $this->dbo=$dbo;
        $this->dbo->query('SET NAMES utf8');
        $this->dbo->query('SET CHARACTER_SET utf8_unicode_ci');
    }
    function all(){
        $query="SELECT `Nazwa`,`Sex`,`Cena`,`Images`,`Id` FROM Bransoletki";
        if(!$result=$this->dbo->query($query)) include 'error.html';
        include 'templates/searchResult.php';
    }
    function women(){
        $query="SELECT `Nazwa`,`Sex`,`Cena`,`Images`,`Id` FROM Bransoletki WHERE Sex='d'";
        if(!$result=$this->dbo->query($query)) include 'error.html';
        include 'templates/searchResult.php';
    }
    function men(){
        $query="SELECT `Nazwa`,`Sex`,`Cena`,`Images`,`Id` FROM Bransoletki WHERE Sex='m'";
        if(!$result=$this->dbo->query($query)) include 'error.html';
        include 'templates/searchResult.php';
    }
    function unisex(){
        $query="SELECT `Nazwa`,`Sex`,`Cena`,`Images`,`Id` FROM Bransoletki WHERE Sex='u'";
        if(!$result=$this->dbo->query($query)) include 'error.html';
        include 'templates/searchResult.php';
    }
}