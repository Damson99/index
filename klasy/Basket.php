<?php
class Basket{
    private $dbo=null;
    function __construct($dbo){
        $this->dbo=$dbo;
        if(!isset($_SESSION['basket'])){
            $_SESSION['basket']=array();
        }
    }
    function add(){
        if(!isset($_GET['id'])){
            return FORM_DATA_MISSING;
        }
        if(($id=(int)$_GET['id']) < 1){
            return INVALID_ID;
        }
        $query="SELECT `Cena` FROM Bransoletki WHERE `Id`=$id";
        if(($cena=$this->dbo->getQuerySingleResult($query))===false){
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
            $this->dbo->query('SET NAMES utf8');
            $this->dbo->query('SET CHARACTER_SET utf8_unicode_ci');
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
    function modify(){
        foreach($_SESSION['basket'] as $id=>$item){
            if(!isset($_POST['id'])){
                unset($_SESSION['basket'][$id]);
            }else if($_POST[$id] < 1){
                unset($_SESSION['basket'][$id]);
            }else{
                $item->ile=(int)$_POST[$id];
            }
        }
    }
    function delete(){
        unset($_SESSION['basket'][$id]);
    }
    function save(&$orderId){
        if(count($_SESSION['basket']) < 1){
            return EMPTY_BASKET;
        }
        if(!isset($_SESSION['zalogowany'])){
            return LOGIN_REQUIRED;
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
        foreach($_SESSION['basket'] as $item){
            $id=$item->id;
            $ile=$item->ile;
            $cena=$item->cena;
            $query.="($id,$orderId,$ile,$cena),";
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
}
?>