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
    function showRegForm($info){
        $reg=new Registration($this->dbo);
        $reg->showRegForm($info);
    }
    function getInputHTML(){
        $reg=new FormInput($this->dbo);
        $reg->getInputHTML();
    }
    function checkout(){
        foreach($_SESSION['basket'] as $id=>$item){
                $item->ile=(int)$_POST[$id];
        }
        if(isset($_POST['messsage'])){
            $message=$_POST['messsage'];
        }
        include "templates/noLoginOrder.php";
    }/**/
    function userUpdate(){
        if(isset($_SESSION['zalogowany'])){
            $id=$_SESSION['zalogowany']->id;
        }else{
            return NO_LOGIN_REQUIRED;
        }
        $imie=$_POST['imie'];
        $nazwisko=$_POST['nazwisko'];
        $ulica=$_POST['ulica'];
        $nr_domu=$_POST['nr_domu'];
        $nr_mieszkania=$_POST['nr_mieszkania'];
        $miejscowosc=$_POST['miejscowosc'];
        $kod=$_POST['kod'];
        $kraj=$_POST['kraj'];
        if($imie=='' || $nazwisko==''||$ulica==''||$nr_domu==''||$nr_mieszkania==''||$miejscowosc==''||$kod==''||$kraj==''){
                return FORM_DATA_MISSING;
        }
        
        $imieLength=strlen($imie);
        $nazwiskoLength=strlen($nazwisko);
        $ulicaLength=strlen($ulica);
        $nr_domuLength=strlen($nr_domu);
        $nr_mieszkaniaLength=strlen($nr_mieszkania);
        $miejscowoscLength=strlen($miejscowosc);
        $kodLength=strlen($kod);
        $krajLength=strlen($kraj);
        
        if($imieLength < 3 || $imieLength > 30 || $nazwiskoLength < 3 || $nazwiskoLength > 30|| $ulicaLength < 3 || $ulicaLength > 30|| $nr_domuLength < 1 || $nr_domuLength > 5|| $nr_mieszkaniaLength < 1 || $nr_mieszkaniaLength > 5|| $miejscowoscLength < 3 || $miejscowoscLength > 30|| $kodLength < 3 || $kodLength > 30|| $krajLength < 3 || $krajLength > 30){
            return LOGIN_FAILED;
        }
        /*$imie=filter_input(INPUT_POST,$imie,FILTER_SANITIZE_SPECIAL_CHARS);
        $imie=$this->dbo->real_escape_string($imie);
        $nazwisko=filter_input(INPUT_POST,$nazwisko,FILTER_SANITIZE_SPECIAL_CHARS);
        $nazwisko=$this->dbo->real_escape_string($nazwisko);
        $ulica=filter_input(INPUT_POST,$ulica,FILTER_SANITIZE_SPECIAL_CHARS);
        $ulica=$this->dbo->real_escape_string($ulica);
        $nr_domu=filter_input(INPUT_POST,$nr_domu,FILTER_SANITIZE_SPECIAL_CHARS);
        $nr_domu=$this->dbo->real_escape_string($nr_domu);
        $nr_mieszkania=filter_input(INPUT_POST,$nr_mieszkania,FILTER_SANITIZE_SPECIAL_CHARS);
        $nr_mieszkania=$this->dbo->real_escape_string($nr_mieszkania);
        $miejscowosc=filter_input(INPUT_POST,$miejscowosc,FILTER_SANITIZE_SPECIAL_CHARS);
        $miejscowosc=$this->dbo->real_escape_string($miejscowosc);
        $kod=filter_input(INPUT_POST,$kod,FILTER_SANITIZE_SPECIAL_CHARS);
        $kod=$this->dbo->real_escape_string($kod);
        $kraj=filter_input(INPUT_POST,$kraj,FILTER_SANITIZE_SPECIAL_CHARS);
        $kraj=$this->dbo->real_escape_string($kraj);*/
        $query="UPDATE Klienci SET `Imie`='$imie',`Nazwisko`='$nazwisko',`Ulica`='$ulica',`Nr_domu`='$nr_domu',`Nr_mieszkania`='$nr_mieszkania',`Miejscowosc`='$miejscowosc',`Kod`='$kod',`Kraj`='$kraj' WHERE `Id`='$id'";
        if(!$this->dbo->query($query)){
            return SERVER_ERROR;
        }else{
            return ACTION_OK;
        }
    }
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