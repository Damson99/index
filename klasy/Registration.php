<?php
class Registration{
    private $dbo=null;
    
    function __construct($dbo){
        $this->dbo=$dbo;
        $this->dbo->query('SET NAMES utf8');
        $this->dbo->query('SET CHARACTER_SET utf8_unicode_ci');
    }
    function showRegForm(){
        include 'loginSupport/regForm.php';
    }
    function registerUser(){
        $email=$_POST['email'];
        $haslo=$_POST['haslo'];
        $haslo2=$_POST['haslo2'];
        $imie=$_POST['imie'];
        $nazwisko=$_POST['nazwisko'];
        
        $emailLength=strlen($email);
        $hasloLength=strlen($haslo);
        $haslo2Length=strlen($haslo2);
        $imieLength=strlen($imie);
        $nazwiskoLength=strlen($nazwisko);
        if($emailLength < 5 || $emailLength > 50 || $hasloLength < 6 || $hasloLength > 50 || $haslo2Length < 6 || $haslo2Length > 50 || $imieLength < 3 || $imieLength > 30 || $nazwiskoLength < 3 || $nazwiskoLength > 30){
            return LOGIN_FAILED;
        }
        $email=$this->dbo->real_escape_string($email);
        $haslo=$this->dbo->real_escape_string($haslo);
        $haslo2=$this->dbo->real_escape_string($haslo2);
        $imie=$this->dbo->real_escape_string($imie);
        $nazwisko=$this->dbo->real_escape_string($nazwisko);
        if($email=='' || $haslo=='' || $haslo2=='' || $imie=='' || $nazwisko==''){
            $emptyFields=true;
        }
        $query="SELECT COUNT(*) FROM Klienci WHERE Email='$email'";
        if($this->getQuerySingleResult($query) > 0){
            return USER_NAME_ALREADY_EXISTS;
        }
        if($haslo != $haslo2){
            return PASSWORDS_DO_NOT_MATCH;
        }
        $salt='5o3_5$f';
        $blowfish='3S1$5_3';
        $haslo=crypt($haslo,$salt.$blowfish);
        $query="INSERT INTO Klienci VALUES (0,'$email','$haslo','$imie','$nazwisko')";
        if($this->dbo->query($query)){
            $query="SELECT `Id`,`Imie`,`Nazwisko` FROM Klienci WHERE `Email`='$email'";
            if(!$result=$this->dbo->query($query)){
                return SERVER_ERROR;
            }
            if($result->num_rows <> 1){
                return ACTION_FAILED;
            }else{
                $row=$result->fetch_row();
                $nazwa=$row[1].' '.$row[2];
                $_SESSION['zalogowany'] = new User($row[0],$nazwa);
                $this->zalogowany=new User($row[0],$nazwa); 
            }
        }else{
            return ACTION_FAILED;
        }
        $userId=$_SESSION['zalogowany']->id;
        $query="INSERT INTO adresy VALUES('$userId','','','','')";
        if(!$result=$this->dbo->query($query)){
            return SERVER_ERROR;
        }else{
            return ACTION_OK;
        }
        include 'loginSupport/register.php';
    }
    function showAdressForm(){
        if(isset($_SESSION['zalogowany'])){
            $userId=$_SESSION['zalogowany']->id;
            $query="SELECT * FROM Adresy WHERE Id='$userId'";
            if(!$result=$this->dbo->query($query)){
                return SERVER_ERROR;
            }
            if(!$rowForm=$result->fetch_row()){
                return SERVER_ERROR;
            }
            include 'loginSupport/regFormUpdate.php';
        }
    }
    function registerAdress(){
        if(isset($_SESSION['zalogowany'])){
            $id=$_SESSION['zalogowany']->id;
        }else{
            return NO_LOGIN_REQUIRED;
        }
        $adres=$_POST['adres'];
        $miejscowosc=$_POST['miejscowosc'];
        $kod=$_POST['kod'];
        $kraj=$_POST['kraj'];
        if($adres=='' || $miejscowosc==''||$kod==''||$kraj==''){
                return FORM_DATA_MISSING;
        }
        
        $adresLength=strlen($adres);
        $miejscowoscLength=strlen($miejscowosc);
        $kodLength=strlen($kod);
        $krajLength=strlen($kraj);
        
        if($adresLength < 4 || $adresLength > 81||$miejscowoscLength < 4 || $miejscowoscLength > 60|| $kodLength < 5 || $kodLength > 7|| $krajLength < 3 || $krajLength > 40){
            return LOGIN_FAILED;
        }
        $adres=$this->dbo->real_escape_string($adres);
        $miejscowosc=$this->dbo->real_escape_string($miejscowosc);
        $kod=$this->dbo->real_escape_string($kod);
        $kraj=$this->dbo->real_escape_string($kraj);
        
        $query="UPDATE Adresy SET `Adres`='$adres',`Miejscowosc`='$miejscowosc',`Kod`='$kod',`Kraj`='$kraj' WHERE `Id`='$id'";
        if(!$this->dbo->query($query)){
            return SERVER_ERROR;
        }else{
            return ACTION_OK;
        }
    }
    function changePassForm(){
        if(!$this->dbo) SERVER_ERROR;
        if(!isset($_SESSION['zalogowany'])){
            header("Location:index.php?action=braceletFor&brn=all");
        }
        include 'templates/editForm.php';
    }
    function checkPass(){
        if(isset($_SESSION['zalogowany'])){
            $user=$_SESSION['zalogowany']->id;
        }
        if(isset($_POST['oldPass'])){
            $oldPass=$_POST['oldPass'];
        }else{
            return FORM_DATA_MISSING;
        }
        if(isset($_POST['newPass'])){
            $newPass=$_POST['newPass'];
        }else{
            return FORM_DATA_MISSING;
        }
        if($newPass==''||$oldPass==''){
            return FORM_DATA_MISSING;
        }
        $oldPassLength = strlen($oldPass);
        $newPassLength = strlen($newPass);
        if($oldPassLength<6||$oldPassLength>50||$newPassLength<6||$newPassLength>50){
            return LOGIN_FAILED;
        }
        $oldPass=$this->dbo->real_escape_string(strip_tags($oldPass));
        $newPass=$this->dbo->real_escape_string(strip_tags($newPass));
        $query="SELECT `Haslo` FROM Klienci WHERE `Id`='$user'";
        if(!$result=$this->dbo->query($query)){
            return SERVER_ERROR;
        }
        if($result->num_rows <> 1){
            return LOGIN_FAILED;
        }else{
            $row=$result->fetch_row();
            $pass_db=$row[0];
            $salt='5o3_5$f';
            $blowfish='3S1$5_3';
            $hashedPass=crypt($oldPass,$salt.$blowfish);
            if($hashedPass !== $pass_db){
                return INVALID_PASS;
            }else{
                $newHashedPass=crypt($newPass,$salt.$blowfish);
                $query1="UPDATE Klienci SET `Haslo`='$newHashedPass' WHERE `Id`='$user'";
                if(!$result1=$this->dbo->query($query1)){
                    return SERVER_ERROR;
                }
                return ACTION_OK;
            }
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
}