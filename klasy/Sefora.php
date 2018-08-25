<?php
class Sefora {
    private $dbo = null;
    public $zalogowany = null;
    
    function __construct($host,$user,$pass,$db){
        $this->dbo = $this->initDB($host,$user,$pass,$db);
        $this->zalogowany = $this->getActualUser();
        $this->dbo->query('SET NAMES utf8');
        $this->dbo->query('SET CHARACTER_SET utf8_unicode_ci');
    }
    function initDB($host,$user,$pass,$db){
        $dbo=new mysqli($host,$user,$pass,$db);
        if($dbo->connect_errno){
            $msg = "Brak połączenia z bazą: ".$dbo->connect_error;
            throw new Exception($msg);
        }
        return $dbo;
    }
    function getActualUser(){
        if(isset($_SESSION['zalogowany'])){
            return $_SESSION['zalogowany'];
        } else {
            return null;
        }
    }
    function setMessage($komunikat){
        $_SESSION['komunikat'] = $komunikat;
    }
    function getMessage(){
        if(isset($_SESSION['komunikat'])){
            $komunikat=$_SESSION['komunikat'];
            unset($_SESSION['komunikat']);
            return $komunikat;
        }else{
            return null;
        }
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
    function login(){
        if(!$this->dbo) return SERVER_ERROR;
        if($this->zalogowany){
            return NO_LOGIN_REQUIRED;
        }
        if(!isset($_POST['email']) || !isset($_POST['haslo'])){
            return FORM_DATA_MISSING;
        }
        $email = $_POST['email'];
        $pass = $_POST['haslo'];
        $email = strlen($email);
        $pass = strlen($pass);
        if($email < 5 || $email > 50 || $pass < 6 || $pass > 50){
            return LOGIN_FAILED;
        }
        $email=$this->dbo->real_escape_string(strip_tags($email));
        $pass=$this->dbo->real_escape_string(strip_tags($pass));
        $query="SELECT `Id`,`Haslo`,`Imie`,`Nazwisko` FROM Klienci WHERE `Email`='$email'";
        if(!$result=$this->dbo->query($query)){
            return SERVER_ERROR;
        }
        if($result->num_rows != 1){
            return LOGIN_FAILED;
        }else{
            $row=$result->fetch_row();
            $pass_db=$row[1];
            if(crypt($pass,$pass_db) != $pass_db){
                return LOGIN_FAILED;
            }else{
                $nazwa=$row[2].' '.$row[3];
                $_SESSION['zalogowany'] = new User($row[0],$nazwa);
                if(isset($_SESSION['przywileje'])){
                $_SESSION['przywileje']=array();
                }   
                $query="SELECT PrzywilejeId FROM Klienci_Przywileje WHERE UserId="."$row[0]";
                if($result=$this->dbo->query($query)){
                    while($row=$result->fetch_row()){
                        $_SESSION['przywileje'][$row[0]]=true;
                    }
                }
                if(isset($SESSION['przywileje'][1])){
                    return LOGIN_OK;
                }else{
                    return $_SESSION['przywileje'][$row[0]]=false;
                }
            }
        }
    }
    function logout(){
        if(isset($_SESSION['zalogowany'])){
            $this->zalogowany = null;
            unset($_SESSION['zalogowany']);
            if(isset($_SESSION['przywileje'])){
                unset($_SESSION['przywileje']);
                if(isset($_COOKIE[session_name()])){
                    setcookie(session_name(),'',time() - 3600);
                }
                session_destroy();
            }
        }
    }
    /*function editAccountForm(){
        if(!$this->dbo) SERVER_ERROR;
        if(isset($_SESSION['zalogowany'])){
            $user=$_SESSION['zalogowany']->id;
        }
        $query="SELECT * FROM Klienci WHERE `Id`='$user'";
        include 'templates/editForm.php';
        
    }
    function editAccount(){
        if(!$this->dbo) SERVER_ERROR;
        
    }*/
    function deleteAccount(){
        if(!$this->dbo) SERVER_ERROR;
        if(isset($_SESSION['zalogowany'])){
            $user=$_SESSION['zalogowany']->id;
        }
        $query="DELETE FROM Klienci WHERE `Id`=$user";
        if(!$this->dbo->query($query)){
            SERVER_ERROR;
        }else{
            ACTION_OK;
            unset($_SESSION['zalogowany']);
            $this->zalogowany = null;
        }
    }
    function showRegForm(){
        $reg=new Registration($this->dbo);
        return $reg->showRegForm();
    }
    function registerUser(){
        $reg=new Registration($this->dbo);
        return $reg->registerUser();
    }
    function showEditForm(){
        $reg=new Registration($this->dbo);
        return $reg->showEditForm();
    }
    function editUser(){
        $reg=new Registration($this->dbo);
        return $reg->editUser();
    }
    function showSearchResult(){
        if($_POST['bransoletka'] != ''){
            $bransoletka=filter_input(INPUT_POST,'bransoletka',FILTER_SANITIZE_SPECIAL_CHARS);
            $cond="`Nazwa` LIKE '%$bransoletka%'";
        }else{
            $cond='';
            header("Location:index.php");
        }
        $query="SELECT `Nazwa`,`Sex`,`Cena`,`Images` FROM Bransoletki WHERE $cond GROUP BY `Id` ORDER BY `Nazwa`";
        $komunikat=false;
        if(!$result=$this->dbo->query($query)){
            $komunikat="Wyniki wyszukiwania chwilowo są niedostępne";
        }else if($result->num_rows < 1){
            $komunikat="Brak wyników";
        }
        include 'templates/searchResult.php';
    }
    function getNews(){
        
        $query="SELECT `Nazwa`,`Sex`,`Cena`,`Images`,`Id` FROM Bransoletki ORDER BY Id DESC LIMIT 5";
        if(!$result=$this->dbo->query($query)) header("Location:error.html");
        include 'templates/searchResult.php';
    }
    function bransoletFor(){
        $br = new Bransolets($this->dbo);
        if(isset($_GET['brn'])){
            $brn=$_GET['brn'];
        }else{
            $brn='all';
        }
        switch($brn){
            case 'unisex':
                $br->unisex();
                break;
            case 'women':
                $br->women();
                break;
            case 'men':
                $br->men();
                break;
            default:
            case 'all':
                $br->all();
        }
    }
    function showDetails(){
        if(!isset($_GET['id']) || ($id=intval($_GET['id'])) < 1){
            $komunikat="Błąd, przepraszamy";
        }else{
            $query="SELECT * FROM Bransoletki WHERE `Id`=$id";
            if($result=$this->dbo->query($query)){
               if($row=$result->fetch_assoc()){
                   $komunikat=false;
               }else{
                   $komunikat="Błąd, przepraszamy";
               }
            }else{
                $komunikat="Błąd, przepraszamy";
            }
        }
        include 'templates/showDetails.php';
    }
    function toBasket(){
        $basket=new Basket($this->dbo);
        return $basket->add();
    }
    function showBasket(){
        $basket=new Basket($this->dbo);
        $basket->show("Zawartość koszyka",true);
    }
    function modifyBasket(){
        $basket=new Basket($this->dbo);
        $basket->modify();
    }
    function deleteBasket(){
        $basket=new Basket($this->dbo);
        $basket->delete();
    }
    function checkout(){
        if(isset($_SESSION['zalogowany'])){
            $basket=new Basket($this->dbo);
            $basket->show("Podsumowanie zamówienia",false);
        }else{
            include "templates/noLoginOrder.php";
        }
    }
}





