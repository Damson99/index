<?php
class Basket{
    private $dbo=null;
    function __construct($dbo){
        $this->dbo=$dbo;
        $this->dbo->query('SET NAMES utf8');
        $this->dbo->query('SET CHARACTER_SET utf8_unicode_ci');
        if(!isset($_SESSION['basket'])){
            $_SESSION['basket']=array();
        }
    }
    function add(){
        if(!isset($_GET['id'])){
            return INVALID_ID;
        }
        if(($id=(int)$_GET['id']) < 1){
            return INVALID_ID;
        }
        $query="SELECT `Cena` FROM Bransoletki WHERE `Id`='$id'";
        if(($cena=$this->getQuerySingleResult($query))===false){
            return INVALID_ID;
        }
        
        if(isset($_SESSION['basket'][$id])){
            $_SESSION['bakset'][$id]->cena=$cena;
            $_SESSION['basket'][$id]->ile++;
        }else{
            $_SESSION['basket'][$id]=new BasketItem($id,$cena,1);
        }
        return ACTION_OK;
    }
    function show($title,$allowModify=true){
        if(count($_SESSION['basket'])==0){
            $komunikat="Koszyk jest pusty";
        }else{
            $ids=implode(',',array_keys($_SESSION['basket']));
            $query="SELECT `Id`,`Nazwa`,`Cena` FROM Bransoletki WHERE `Id` IN(".$ids.") ORDER BY `Nazwa`";
            if($jewellery=$this->dbo->query($query)){
                $basket=$_SESSION['basket'];
                $komunikat=false;
            }else{
                $komunikat="Koszyk jest chwilowo niedostępny";
            }
        }
        include 'templates/basket.php';
    }
    function delete(){
        if(!isset($_GET['id']) || ($id=intval($_GET['id'])) < 1){
            $komunikat="Błąd, przepraszamy";
        }else{
            unset($_SESSION['basket'][$id]);
        }
    }
    function showAdressForm(){
        $reg=new Registration($this->dbo);
        return $reg->showAdressForm();
    }
    function registerAdress(){
        $reg=new Registration($this->dbo);
        $reg->registerAdress();
    }
    /*function checkout(){
        foreach($_SESSION['basket'] as $id=>$item){
                $item->ile=(int)$_POST[$id];
        }
        if(isset($_POST['messsage'])){
            $message=$_POST['messsage'];
        }
        include "templates/noLoginOrder.php";
    }*/
    function saveOrder(&$orderId){
        if(count($_SESSION['basket']) < 1){
            return EMPTY_BASKET;
        }
        $ids=implode(',',array_keys($_SESSION['basket']));
        $userId=$_SESSION['zalogowany']->id;
        $this->dbo->autocommit(false);
        $query="INSERT INTO Zamowienia VALUES(0,$userId,NOW(),null,0)";
        if(!$this->dbo->query($query)){
            return SERVER_ERROR;
        }
        if(($orderId=$this->dbo->insert_id) < 1){
            return SERVER_ERROR;
        }
        $query="INSERT INTO BransoletkiZamowienia VALUES";
        $message=$item->message;
        foreach($_SESSION['basket'] as $item){
            $id=$item->id;
            $cena=$item->cena;
            $ile=$item->ile;
            $query.="($id,$orderId,$ile,$cena,$message),";
        }
        $query[strlen($query) - 1]=' ';
        if(!$this->dbo->query($query)){
            return SERVER_ERROR;
        }
        if($this->dbo->affected_rows != count($_SESSION['basket'])){
            return SERVER_ERROR;
        }
        $this->dbo->commit();
        $_SESSION['basket']=array();
        return ACTION_OK;   
    }
    function getQuerySingleResult($query){
        if(!$this->dbo) return false;
        if(!$result=$this->dbo->query($query)){
            return false;
        }
        if($row=$result->fetch_row()){
            return $row[0];
        }else{
            return false;
        }
    }
}
?>