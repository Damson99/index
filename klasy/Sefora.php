<?php
class Sefora extends SeforaAdmin{
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
        if(!$result=$this->query($query)){
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
        $emailLength = strlen($email);
        $passLength = strlen($pass);
        if($emailLength < 5 || $emailLength > 50 || $passLength < 6 || $passLength > 50){
            return LOGIN_FAILED;
        }
        $email=$this->dbo->real_escape_string(strip_tags($email));
        $pass=$this->dbo->real_escape_string(strip_tags($pass));
        $query="SELECT `Id`,`Haslo`,`Imie` FROM Klienci WHERE `Email`='$email'";
        if(!$result=$this->dbo->query($query)){
            return SERVER_ERROR;
        }
        if($result->num_rows <> 1){
            return LOGIN_FAILED;
        }else{
            $row=$result->fetch_row();
            $pass_db=$row[1];
            $salt='5o3_5$f';
            $blowfish='3S1$5_3';
            $hashedPass=crypt($pass,$salt.$blowfish);
            if($hashedPass !== $pass_db){
                return LOGIN_FAILED;
            }else{
                $nazwa=$row[2];
                $_SESSION['zalogowany'] = new User($row[0],$nazwa);
                $this->zalogowany=new User($row[0],$nazwa);
                if(!isset($_SESSION['przywileje'])){
                    $_SESSION['przywileje']=array();
                }
                $query="SELECT PrzywilejeId FROM Klienci_Przywileje WHERE UserId='$row[0]'";
                if($result=$this->dbo->query($query)){
                    while($row=$result->fetch_row()){
                        $_SESSION['przywileje']=$row[0];
                    }
                }
                return LOGIN_OK;
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
    function deleteAccount(){
        if(!$this->dbo) SERVER_ERROR;
        if(isset($_SESSION['zalogowany'])){
            $user=$_SESSION['zalogowany']->id;
        }
        $query="DELETE FROM Klienci WHERE `Id`=$user";
        if(!$this->dbo->query($query)){
            return SERVER_ERROR;
        }else{
            unset($_SESSION['zalogowany']);
            $this->zalogowany = null;
        }
        return ACTION_OK;
    }
    function showRegForm(){
        $reg=new Registration($this->dbo);
        return $reg->showRegForm();
    }
    function showAdressForm(){
        $reg=new Registration($this->dbo);
        return $reg->showAdressForm();
    }
    function registerUser(){
        $reg=new Registration($this->dbo);
        return $reg->registerUser();
    }
    function changePassForm(){
        $reg=new Registration($this->dbo);
        return $reg->changePassForm();
    }
    function checkPass(){
        $reg=new Registration($this->dbo);
        return $reg->checkPass();
    }
    function getNews($limitNews,$toBack){
        $brn=new Bracelets($this->dbo);
        return $brn->getNews($limitNews,$toBack);
    }
    function showSearchResult(){
        $brn=new Bracelets($this->dbo);
        return $brn->showSearchResult();
    }
    function couple(){
        $br = new Bracelets($this->dbo);
        if(isset($_GET['brn'])){
            $brn=$_GET['brn'];
        }
        switch($brn){
            case 'Infinity':
                $kind="WHERE Para=1 AND Nazwa LIKE '%Infinity%'";
                $br->getCouple($kind,$brn);
                break;
            case 'NeverGiveUp':
                $kind="WHERE Para=1 AND Nazwa LIKE '%Never Give Up%'";
                $br->getCouple($kind,$brn);
                break;
            case 'Inne':
                $kind="WHERE Para=1 AND Nazwa NOT LIKE '%Infinity%' AND Nazwa NOT LIKE '%Never Give Up%'";
                $br->getCouple($kind,$brn);
                break;
        }
    }
    function braceletFor(){
        $br = new Bracelets($this->dbo);
        if(isset($_GET['brn'])){
            $brn=$_GET['brn'];
        }
        $limit=20;
        switch($brn){
            case 'women':
                $sex="WHERE Sex='d'";
                $jewellery='';
                if(isset($_GET['jewellery'])){
                    $women=$_GET['jewellery'];
                    switch($women){
                        case 'bransoletki':
                            $jewellery="AND Nazwa LIKE '%Bransolet%'";
                            break;
                        case 'kolczyki':
                            $jewellery="AND Nazwa LIKE '%Kolczyk%'";
                            break;
                        case 'naszyjniki':
                            $jewellery="AND Nazwa LIKE '%Naszyjnik%'";
                            break;
                    }
                }
                $br->getBracelets($sex,$limit,$jewellery);
                break;
            case 'unisex':
                $sex="WHERE Sex='u'";
                $jewellery='';
                if(isset($_GET['jewellery'])){
                    $women=$_GET['jewellery'];
                    switch($women){
                        case 'bransoletki':
                            $jewellery="AND Nazwa LIKE '%Bransolet%'";
                            break;
                        case 'kolczyki':
                            $jewellery="AND Nazwa LIKE '%Kolczyk%'";
                            break;
                        case 'naszyjniki':
                            $jewellery="AND Nazwa LIKE '%Naszyjnik%'";
                            break;
                    }
                }
                $br->getBracelets($sex,$limit,$jewellery);
                break;
            case 'men':
                $sex="WHERE Sex='m'";
                $jewellery='';
                if(isset($_GET['jewellery'])){
                    $women=$_GET['jewellery'];
                    switch($women){
                        case 'bransoletki':
                            $jewellery="AND Nazwa LIKE '%Bransolet%'";
                            break;
                        case 'naszyjniki':
                            $jewellery="AND Nazwa LIKE '%Naszyjnik%'";
                            break;
                    }
                }
                $br->getBracelets($sex,$limit,$jewellery);
                break;
            case 'boho':
                $sex="";
                $jewellery="AND Nazwa LIKE %BOHO%";
                $br->getBracelets($sex,$limit,$jewellery);
                break;
            case 'breloki':
                $sex="";
                $jewellery="AND Nazwa LIKE %Breloki%";
                $br->getBracelets($sex,$limit,$jewellery);
                break;
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
    function toWishList(){
        $brn=new Bracelets($this->dbo);
        return $brn->toWishList();
    }
    function showWishList(){
        $brn=new Bracelets($this->dbo);
        return $brn->showWishList();
    }
    function deleteWishList(){
        $brn=new Bracelets($this->dbo);
        return $brn->deleteWishList();
    }
    function toBasket(){
        $basket=new Basket($this->dbo);
        return $basket->add();
    }
    function showBasket(){
        $basket=new Basket($this->dbo);
        $basket->show("Zawartość koszyka",true);
    }
    function deleteBasket(){
        $basket=new Basket($this->dbo);
        $basket->delete();
    }
    function checkout(){
        $basket=new Basket($this->dbo);
        $basket->checkout();
    }
    function orderConfirm(){
        $basket=new Basket($this->dbo);
        $basket->orderConfirm();
    }
}