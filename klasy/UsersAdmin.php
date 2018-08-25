<?php
class UsersAdmin{
    private $dbo=null;
    function __construct($dbo){
        $this->dbo=$dbo;
        $this->dbo->query('SET NAMES utf8');
        $this->dbo->query('SET CHARACTER_SET utf8_unicode_ci');
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
    function showOrders(){
        
    }
    function addBransoletForm($action){
        if(!$this->dbo) return SERVER_ERROR;
        if($action=='edit'){
            if(!isset($_GET['id'])){
                return FORM_DATA_MISSING;
            }
            if($id=intval($_GET['id']) < 1){
                return INVALID_USER_ID;
            }
            $query="SELECT * FROM Bransoletki WHERE `Id`=$id";
            if(!$result=$this->dbo->query($query)){
                return SERVER_ERROR;
            }
            if(!$row=$result->fetch_row()){
                return INVALID_USER_ID;
            }
            $id=$row[0];
            $nazwa=$row[1];
            $sex=$row[2];
            $opis=$row[3];
            $cena=$row[4];
            $kolor=$row[5];
            $zdjecia=$row[6];
            
            $wtd='editBransolet';
            $readonly='readonly="readonly"';
        }else{
            $id='';
            $nazwa='';
            $sex='';
            $opis='';
            $cena='';
            $kolor='';
            $zdjecia='';
            $wtd='addBransolet';
            $readonly='';
        }
        include 'adminTemplates/addBransoletForm.php';
    }
    function searchBransoletForm(){
        include 'adminTemplates/searchBransoletForm.php';
    }
    function searchBransolet(){
        if(!$this->dbo) return SERVER_ERROR;
        if(!isset($_GET['id']) || !isset($_GET['nazwa'])) return FORM_DATA_MISSING;
        $id=$_GET['id'];
        $nazwa=$_GET['nazwa'];
        if($id=='' && $nazwa=='') return FORM_DATA_MISSING;
        if($id!=''){
            if(($id=(int)$id)<1){
                return INVALID_USER_ID;
            }
            $cond1="AND `Id`=$id";
        }else{
            $cond1='';
        }
        if($nazwa!=''){
            $nazwa=$this->dbo->real_escape_string($nazwa);
            $cond2="AND `Nazwa` LIKE '%$nazwa%'";
        }else{
            $cond2='';
        }
        $query="SELECT * FROM Bransoletki WHERE 1=1 $cond1 $cond2";
        if(!$result=$this->dbo->query($query)){
            return SERVER_ERROR;
        }
        if(!$row=$result->fetch_row()){
            return USER_NOT_FOUND;
        }
        $id=$row[0];
        $nazwa=$row[1]; 
        $sex=$row[2];
        $opis=$row[3];
        $cena=$row[4];
        $kolor=$row[5];
        $zdjecia=$row[6];
        $readonly='readonly';
        $wtd='editBransolet';
        include 'adminTemplates/addBransoletForm.php';
    }
    function editBransolet($action, &$id){
        if(!$this->dbo) return SERVER_ERROR;
        if(!isset($_POST['id']) || !isset($_POST['nazwa']) || !isset($_POST['sex']) || !isset($_POST['opis']) || !isset($_POST['cena']) || !isset($_POST['kolor']) || !isset($_POST['zdjecia'])){
            return FORM_DATA_MISSING;
        }
        $id=(int)$_POST['id'];
        $nazwa=$_POST['nazwa'];
        $sex=$_POST['sex'];
        $opis=$_POST['opis'];
        $cena=(int)$_POST['cena'];
        $kolor=$_POST['kolor'];
        $zdjecia=$_POST['zdjecia'];
        
        if(($action=='edit' && $id < 1) || ($action=='add' && $id < 0)) return INVALID_USER_ID;
        $nazwa=$this->dbo->real_escape_string($nazwa);
        $sex=$this->dbo->real_escape_string($sex);
        $opis=$this->dbo->real_escape_string($opis);
        $cena=$this->dbo->real_escape_string($cena);
        $kolor=$this->dbo->real_escape_string($kolor);
        $zdjecia=$this->dbo->real_escape_string($zdjecia);
        
        if($action=='edit'){
            $query="UPDATE Bransoletki Set Nazwa='$nazwa',Sex='$sex',Opis='$opis',Cena=$cena,Kolor='$kolor',Images='$zdjecia' WHERE `Id`='$id'";
        }else{
            if($id > 0){
                $query="SELECT `Id` FROM Bransoletki WHERE `Id`='$id'";
                if($this->getQuerySingleResult($query) !== false){
                    return USER_ID_ALREADY_EXISTS;
                }
            }
            $query="INSERT INTO Bransoletki VALUES('$id','$nazwa','$sex','$opis',$cena,'$kolor','$zdjecia')";
        }
        if($this->dbo->query($query)){
            if($action != 'edit'){
                $id=$this->dbo->insert_id;
            }
            return ACTION_OK;
        }else{
            return ACTION_FAILED;
        }
    }
    function showList($limit){
        if(!$this->dbo){
            echo "Lista użytkowników nie jest dostępna";
            return;
        }
        if(isset($_GET['page'])){
            $page=intval($_GET['page']);
        }else{
            $page=0;
        }
        $query="SELECT COUNT(*) FROM Klienci";
        $rowsCount=(int)$this->getQuerySingleResult($query);
        $pages=ceil($rowsCount/$limit);
        if($page < 0 || $page>=$pages) $page=0;
        $offset=$page*$limit;
        $query="SELECT `Id`,`Imie`,`Nazwisko`,`Email` FROM Klienci LIMIT $offset, $limit";
        if(!$result=$this->dbo->query($query)){
            return;
        }
        include 'adminTemplates/usersList.php';
    }
    function getPagination($page,$pages,$link,$msg){
        $str='';
        for($i=0;$i<$pages;$i++){
            if($i!=$page){
                $str.="<a href=\"$link&amp;page=$i\">".($i+1)."</a>";
            }else{
                $str.='<span class="activePaginationDiv">'.($i+1).'</span>';
            }
            $str.='<span class="space"></span>';
        }
        $str=$msg.$str;
        return $str;
    }
    function showEditForm($action){
        if(!$this->dbo) return SERVER_ERROR;
        if($action=='edit'){
            if(!isset($_GET['id'])){
                return FORM_DATA_MISSING;
            }
            if($id=intval($_GET['id']) < 1){
                return INVALID_USER_ID;
            }
            $query="SELECT * FROM Klienci WHERE Id=$id";
            if(!$result=$this->dbo->query($query)){
                return SERVER_ERROR;
            }
            if(!$row=$result->fetch_row()){
                return INVALID_USER_ID;
            }
            $id=$row[0];
            $email=$row[1];
            $haslo=$row[2];
            $imie=$row[3];
            $nazwisko=$row[4];
            $ulica=$row[5];
            $nr_domu=$row[6];
            $nr_mieszkania=$row[7];
            $miejscowosc=$row[8];
            $kod=$row[9];
            $kraj=$row[10];
            
            $wtd='modifyUser';
            $readonly='readonly="readonly"';
        }else{
            $id='';
            $email='';
            $haslo='';
            $imie='';
            $nazwisko='';
            $ulica='';
            $nr_domu='';
            $nr_mieszkania='';
            $miejscowosc='';
            $kod='';
            $kraj='';
            $wtd='addUser';
            $readonly='';
        }
        include 'adminTemplates/editUserForm.php';
    }
    function editUser($action, &$id){
        if(!$this->dbo) return SERVER_ERROR;
        if(!isset($_POST['id']) || !isset($_POST['email']) || !isset($_POST['haslo']) || !isset($_POST['imie']) || !isset($_POST['nazwisko'])){
            return FORM_DATA_MISSING;
        }
        $id=(int)$_POST['id'];
        $email=$_POST['email'];
        $haslo=$_POST['haslo'];
        $imie=$_POST['imie'];
        $nazwisko=$_POST['nazwisko'];
        $ulica=$_POST['ulica'];
        $nr_domu=(int)$_POST['nr_domu'];
        $nr_mieszkania=(int)$_POST['nr_mieszkania'];
        $miejscowosc=$_POST['miejscowosc'];
        $kod=$_POST['kod'];
        $kraj=$_POST['kraj'];
        
        if(($action=='edit' && $id < 1) || ($action=='add' && $id < 0)) return INVALID_USER_ID;
        if(!preg_match("/^[a-zA-Z0-9_.]{3,20}$/", $imie)){
            return INVALID_USER_NAME;
        }
        $email=$this->dbo->real_escape_string($email);
        $haslo=$this->dbo->real_escape_string($haslo);
        $imie=$this->dbo->real_escape_string($imie);
        $nazwisko=$this->dbo->real_escape_string($nazwisko);
        $ulica=$this->dbo->real_escape_string($ulica);
        $miejscowosc=$this->dbo->real_escape_string($miejscowosc);
        $kod=$this->dbo->real_escape_string($kod);
        $kraj=$this->dbo->real_escape_string($kraj);
        
        if($action=='edit'){
            if($haslo != ''){
                $pass="Haslo='".crypt($haslo)."',";
            }else{
                $pass='';
            }
            $query="UPDATE Klienci Set Email='$email',$pass"."Imie='$imie',Nazwisko='$nazwisko',Ulica='$ulica',Nr_domu='$nr_domu',Nr_mieszkania='$nr_mieszkania',Miejscowosc='$miejscowosc',Kod='$kod',Kraj='$kraj' WHERE Id='$id'";
        }else{
            $query="SELECT Id FROM Klienci WHERE Email=$email";
            if($this->getQuerySingleResult($query) !== false){
                return USER_EMAIL_ALREADY_EXISTS;
            }
            if($id > 0){
                $query="SELECT Id FROM Klienci WHERE Id=$id";
                if($this->getQuerySingleResult($query) !== false){
                    return USER_ID_ALREADY_EXISTS;
                }
            }
            $haslo=crypt($haslo);
            $query="INSERT INTO Klienci VALUES($id,'$email','$haslo',". "'$imie','$nazwisko','$ulica',$nr_domu,$nr_mieszkania,'$miejscowosc','$kod','$kraj')";
        }
        if($this->dbo->query($query)){
            if($action != 'edit'){
                $id=$this->dbo->insert_id;
            }
            return ACTION_OK;
        }else{
            return ACTION_FAILED;
        }
    }
    function showSearchForm(){
        include 'adminTemplates/searchUserForm.php';
    }
    function searchUser(){
        if(!$this->dbo) return SERVER_ERROR;
        if(!isset($_GET['id']) || !isset($_GET['imie'])) return FORM_DATA_MISSING;
        $id=$_GET['id'];
        $imie=$_GET['imie'];
        if($id=='' && $imie=='') return FORM_DATA_MISSING;
        if($id!=''){
            if(($id=(int)$id)<1){
                return INVALID_USER_ID;
            }
            $cond1=" AND `Id`=$id";
        }else{
            $cond1='';
        }
        if($imie!=''){
            if(!preg_match("/^[a-zA-Z0-9_.]{3,20}$/",$imie)){
                return INVALID_USER_NAME;
            }
            $imie=$this->dbo->real_escape_string($imie);
            $cond2=" AND `Imie`='$imie'";
        }else{
            $cond2='';
        }
        $query="SELECT * FROM Klienci WHERE 1=1 $cond1 $cond2";
        if(!$result=$this->dbo->query($query)){
            return SERVER_ERROR;
        }
        if(!$row=$result->fetch_row()){
            return USER_NOT_FOUND;
        }
        $id=$row[0];
        $email=$row[1]; 
        $imie=$row[3];
        $nazwisko=$row[4];
        $ulica=$row[5];
        $nr_domu=$row[6];
        $nr_mieszkania=$row[7];
        $miejscowosc=$row[8];
        $kod=$row[9];
        $kraj=$row[10];
        $readonly='readonly';
        $wtd='modifyUser';
        include 'adminTemplates/editUserForm.php';
    }
    function delete($action,&$id){
        if(!$this->dbo) return SERVER_ERROR;
        if(!isset($_GET['id']) || $_GET['id']<1){
            return INVALID_USER_ID;
        }
        $id=(int)$_GET['id'];
        if($action=='user'){
            $query="DELETE FROM Klienci WHERE `Id`=$id";
        }elseif($action=='bransolet'){
            $query="DELETE FROM Bransoletki WHERE `Id`=$id";
        }
        if(!$this->dbo->query($query)){
            return SERVER_ERROR;
            if($this->dbo->affected_rows==0){
                return USER_NOT_FOUND;
            }else{
                return ACTION_OK;
            }
        }
    }
}


