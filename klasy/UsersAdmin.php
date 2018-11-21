<?php
class UsersAdmin{
    private $dbo=null;
    function __construct($dbo){
        $this->dbo=$dbo;
        $this->dbo->query('SET NAMES utf8');
        $this->dbo->query('SET CHARACTER_SET utf8_unicode_ci');
    }
    function showList($limit){
        $limit=20;
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
        if($page < 0 || $page >= $pages) $page=0;
        $offset=$page*$limit;
        $query="SELECT `Id`,`Imie`,`Nazwisko`,`Email` FROM Klienci LIMIT $offset, $limit";
        if(!$result=$this->dbo->query($query)){
            return;
        }
        include 'adminTemplates/usersList.php';
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
            $query="SELECT * FROM Klienci WHERE Id='$id'";
            if(!$result=$this->dbo->query($query)){
                return SERVER_ERROR;
            }
            if(!$row=$result->fetch_row()){
                return INVALID_USER_ID;
            }
            $id=$row[0];
            /*$email=$row[1];*/
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
        
        /*$check='/^[A-ZĄĘÓŁŚŻŹĆŃ]{1}+[a-ząęółśżźćń]+$/';
        $checkPass='/^(?=.*\d)(?=.*[a-z])(?=.*[\!\@\#\$\%\^\&\*\(\)\_\+\-\=])(?=.*[A-Z])(?!.*\s).{8,}$/';
        $checkNr='/^[1-1000]$/';
        $checkKod='/^[0-9]{2}[-][0-9]{3}$/';
        if(!preg_match($check,$imie) || !preg_match($check,$nazwisko)){
            return INVALID_USER_NAME;
        }
        if(!preg_match($checkPass,$haslo) || !preg_match($checkPass,$haslo2)){
            return INVALID_PASS;
        }
        if(($ulica || $nr_domu || $nr_mieszkania || $miejscowosc || $kod || $kraj) !=''){
            if(!preg_match($check,$ulica) || !preg_match($checkNr,$nr_domu) || !preg_match($checkNr,$nr_mieszkania) || !preg_match($check,$miejscowosc) || !preg_match($check,$miejscowosc) || !preg_match($checkKod,$kod) || !preg_match($check,$kraj)){
                return INVALID_ADDRESS;
            }
        }*/
        if(($action=='edit' && $id < 1) || ($action=='add' && $id < 0)) return INVALID_USER_ID;
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
                $salt='5o3_5$f';
                $blowfish='3S1$5_3';
                $pass="Haslo='".crypt($haslo,$salt.$blowfish)."',";
            }else{
                $pass='';
            }
            $query="UPDATE Klienci Set Email='$email',$pass"."Imie='$imie',Nazwisko='$nazwisko',Ulica='$ulica',Nr_domu='$nr_domu',Nr_mieszkania='$nr_mieszkania',Miejscowosc='$miejscowosc',Kod='$kod',Kraj='$kraj' WHERE Id='$id'";
        }else{
            $query="SELECT Id FROM Klienci WHERE Email='$email'";
            if($this->getQuerySingleResult($query) !== false){
                return USER_EMAIL_ALREADY_EXISTS;
            }
            if($id > 0){
                $query="SELECT Id FROM Klienci WHERE Id='$id'";
                if($this->getQuerySingleResult($query) !== false){
                    return USER_ID_ALREADY_EXISTS;
                }
            }
            $salt='5o3_5$f';
            $blowfish='3S1$5_3';
            $hashedPass=crypt($haslo,$salt.$blowfish);
            $query="INSERT INTO Klienci VALUES($id,'$email','$hashedPass',". "'$imie','$nazwisko','$ulica',$nr_domu,$nr_mieszkania,'$miejscowosc','$kod','$kraj')";
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
    function delete(){
        if(!$this->dbo) return SERVER_ERROR;
        if(!isset($_GET['id']) || $_GET['id']<1){
            return INVALID_USER_ID;
        }
        $id=(int)$_GET['id'];
        $query="DELETE FROM Klienci WHERE `Id`='$id'";
        if(!$this->dbo->query($query)){
            return SERVER_ERROR;
            if($this->dbo->affected_rows==0){
                return USER_NOT_FOUND;
            }else{
                $query="DELETE FROM Adresy WHERE `Id`='$id'";
                if(!$this->dbo->query($query)){
                    return SERVER_ERROR;
                }else{
                    return ACTION_OK;
                }
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
    function getPagination($page,$pages,$link,$msg){
        $str='';
        for($i=0;$i<$pages;$i++){
            if($i!=$page){
                $str.="<a href=\"$link&amp;page=$i\">".($i+1)."</a>";
            }else{
                $str.='<span class="activePaginationDiv">'.($i+1).'</span>';
            }
            $str.='<span class="space"> </span>';
        }
        $str=$msg.$str;
        return $str;
    }
}


