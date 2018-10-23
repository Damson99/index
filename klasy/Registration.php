<?php
class Registration{
    private $dbo=null;
    private $fields=array();
    
    function __construct($dbo){
        $this->dbo=$dbo;
        $this->initFields();
    }
    function initFields(){
        if(isset($_GET['action'])){
            $action=$_GET['action'];
        }
        if($action!=='userUpdateForm'){
            $this->fields['email'] = new FormInput('email','Email','','email');
            $this->fields['haslo'] = new FormInput('haslo','Hasło','','password');
            $this->fields['haslo2'] = new FormInput('haslo2','Powtórz hasło','','password');
        }
        $this->fields['imie'] = new FormInput('imie','Imię','','');
        $this->fields['nazwisko'] = new FormInput('nazwisko','Nazwisko','','');
        $this->fields['ulica'] = new FormInput('ulica','Ulica','','');
        $this->fields['nr_domu'] = new FormInput('nr_domu','Numer domu','','');
        $this->fields['nr_mieszkania'] = new FormInput('nr_mieszkania','Numer mieszkania','','');
        $this->fields['miejscowosc'] = new FormInput('miejscowosc','Miejscowość','','');
        $this->fields['kod'] = new FormInput('kod','Kod pocztowy','','');
        $this->fields['kraj'] = new FormInput('kraj','Kraj','','');
    }
    function showRegForm($info){
        foreach($this->fields as $name=>$field){
            $field->value=isset($_SESSION['formData'][$name]) ? $_SESSION['formData'][$name]:'';
        }
        $formData=$this->fields;
        if(isset($_SESSION['formData'])){
            unset($_SESSION['formData']);
        }
        if(isset($_SESSION['zalogowany'])){
            $userId=$_SESSION['zalogowany']->id;
            $query="SELECT * FROM Klienci WHERE Id='$userId'";
            if(!$result=$this->dbo->query($query)){
                return SERVER_ERROR;
            }
            if(!$rowForm=$result->fetch_row()){
                return SERVER_ERROR;
            }
        }
        if($info==='up'){
            include 'loginSupport/regFormUpdate.php';
        }else{
            include 'loginSupport/regForm.php';
        }
    }
    function registerUser(){
        foreach($this->fields as $name=>$val){
            if(!isset($_POST[$name])){
                return FORM_DATA_MISSING;
            }
        }
        /*Wyrażenie regularne sprawdzające długość ciągów i niedozwolone znaki */
        $email=$_POST['email'];
        $haslo=$_POST['haslo'];
        $haslo2=$_POST['haslo2'];
        $imie=$_POST['imie'];
        $nazwisko=$_POST['nazwisko'];
        $ulica=$_POST['ulica'];
        $nr_domu=$_POST['nr_domu'];
        $nr_mieszkania=$_POST['nr_mieszkania'];
        $miejscowosc=$_POST['miejscowosc'];
        $kod=$_POST['kod'];
        $kraj=$_POST['kraj'];
        
        $emailLength=strlen($email);
        $hasloLength=strlen($haslo);
        $haslo2Length=strlen($haslo2);
        $imieLength=strlen($imie);
        $nazwiskoLength=strlen($nazwisko);
        if($emailLength < 5 || $emailLength > 50 || $hasloLength < 6 || $hasloLength > 50 || $haslo2Length < 6 || $haslo2Length > 50 || $imieLength < 3 || $imieLength > 30 || $nazwiskoLength < 3 || $nazwiskoLength > 30){
            return LOGIN_FAILED;
        }
        $fieldsFromForm=array();
        $emptyFields=false;
        foreach($this->fields as $name=>$val){
            if($val->type != 'password'){
                $fieldsFromForm[$name]=filter_input(INPUT_POST,$name,FILTER_SANITIZE_SPECIAL_CHARS);
            }else{
                $fieldsFromForm[$name]=$_POST[$name];
            }
            $fieldsFromForm[$name]=$this->dbo->real_escape_string($fieldsFromForm[$name]);
            if($email=='' || $haslo=='' || $haslo2=='' || $imie=='' || $nazwisko==''){
                $emptyFields=true;
            }
        }
        if($emptyFields){
            unset($fieldsFromForm['haslo']);
            unset($fieldsFromForm['haslo2']);
            $_SESSION['formData']=$fieldsFromForm;
            return FORM_DATA_MISSING;
        }
        $query="SELECT COUNT(*) FROM Klienci WHERE Email='".$fieldsFromForm['email']."'";
        if($this->getQuerySingleResult($query) > 0){
            return USER_NAME_ALREADY_EXISTS;
        }
        if($fieldsFromForm['haslo'] != $fieldsFromForm['haslo2']){
            return PASSWORDS_DO_NOT_MATCH;
        }
        unset($fieldsFromForm['haslo2']);
        unset($this->fields['haslo2']);
        $salt='5o3_5$f';
        $blowfish='3S1$5_3';
        $fieldsFromForm['haslo']=crypt($fieldsFromForm['haslo'],$salt.$blowfish);
        $fieldNames='`'.implode('`,`',array_keys($this->fields)).'`';
        $fieldVals='\''.implode('\',\'',$fieldsFromForm).'\'';
        $query="INSERT INTO Klienci ($fieldNames) VALUES ($fieldVals)";
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
                return ACTION_OK; 
            }
        }else{
            return ACTION_FAILED;
        }
        include 'loginSupport/register.php';
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