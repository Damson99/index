<?php
class BraceletsAdmin{
    private $dbo=null;
    function __construct($dbo){
        $this->dbo=$dbo;
        $this->dbo->query('SET NAMES utf8');
        $this->dbo->query('SET CHARACTER_SET utf8_unicode_ci');
    }
    function showOrders($limit){
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
        $query="SELECT COUNT(*) FROM BransoletkiZamowienia";
        $rowsCount=(int)$this->getQuerySingleResult($query);
        $pages=ceil($rowsCount/$limit);
        if($page < 0 || $page >= $pages) $page=0;
        $offset=$page*$limit;
        if(!$this->dbo) return SERVER_ERROR;
        $query="SELECT Id,Status,Data_wprowadzenia FROM Zamowienia ORDER BY Id LIMIT $offset, $limit";
        if(!$result=$this->dbo->query($query)) return SERVER_ERROR;
        include 'adminTemplates/orders.php';
    }
    function orderDetails(){
        if(!$this->dbo){
            echo "Lista użytkowników nie jest dostępna";
            return;
        }
        if(!isset($_GET['idDetails'])){
            return INVALID_ID;
        }
        if(($idDetails=(int)$_GET['idDetails'])<1){
            return INVALID_ID;
        }
        $query="SELECT Bransoletki.Nazwa,Bransoletki.Images,Data_wprowadzenia,Data_realizacji,BransoletkaId,Ile,BransoletkiZamowienia.Cena,KlientId,Klienci.Id,Klienci.Imie,Klienci.Nazwisko,Klienci.Email FROM Zamowienia JOIN BransoletkiZamowienia ON Zamowienia.Id=BransoletkiZamowienia.ZamowienieId JOIN Bransoletki ON BransoletkiZamowienia.BransoletkaId=Bransoletki.Id JOIN Klienci ON Zamowienia.KlientId=Klienci.Id WHERE BransoletkiZamowienia.ZamowienieId='$idDetails'";
        if(!$result=$this->dbo->query($query)){
            return SERVER_ERROR;
        }
        if(!$row=$result->fetch_row()){
            return SERVER_ERROR;
        }
        include 'adminTemplates/orderDetails.php';
    }
    function updateOrders(){
        if(!isset($_GET['idOrder'])){
            return INVALID_ID;
        }
        if(($zamowienieId=$_GET['idOrder'])<1){
            return INVALID_ID;
        }
        $query="UPDATE zamowienia LEFT JOIN bransoletkizamowienia ON Zamowienia.Id=BransoletkiZamowienia.ZamowienieId SET Data_realizacji=NOW(),Status=1 WHERE BransoletkiZamowienia.ZamowienieId='$zamowienieId'";
        if(!$this->dbo->query($query)){
            return SERVER_ERROR;
            if($this->dbo->affected_rows==0){
                return SERVER_ERROR;
            }else{
                return ACTION_OK;
            }
        }
        
    }
    function addBraceletForm($action){
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
            $para=$row[7];
            
            $wtd='editBracelet';
            $readonly='readonly="readonly"';
        }else{
            $id='';
            $nazwa='';
            $sex='';
            $opis='';
            $cena='';
            $kolor='';
            $zdjecia='';
            $para='';
            $wtd='addBracelet';
            $readonly='';
        }
        include 'adminTemplates/addBraceletForm.php';
    }
    function lastId(){
        $query="SELECT `Id` FROM Bransoletki ORDER BY Id DESC LIMIT 1";
        $lastId=$this->dbo->query($query);
        $resultId=$lastId->fetch_row();
        echo $resultId[0];
    }
    function searchBraceletForm(){
        include 'adminTemplates/searchBraceletForm.php';
    }
    function searchBracelet(){
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
        $para=$row[7];
        $readonly='readonly';
        $wtd='editBracelet';
        include 'adminTemplates/addBraceletForm.php';
    }
    function editBracelet($action, &$id){
        if(!$this->dbo) return SERVER_ERROR;
        if(!isset($_POST['id']) || !isset($_POST['nazwa']) || !isset($_POST['sex']) || !isset($_POST['opis']) || !isset($_POST['cena']) || !isset($_POST['kolor']) || !isset($_POST['zdjecia']) || !isset($_POST['para'])){
            return FORM_DATA_MISSING;
        }
        if($_POST['id']=='' || $_POST['nazwa']=='' || $_POST['sex']=='' || $_POST['opis']=='' || $_POST['cena']=='' || $_POST['kolor']=='' || $_POST['zdjecia']=='' || $_POST['para']==''){
            return FORM_DATA_MISSING;
        }
        $id=(int)$_POST['id'];
        $nazwa=$_POST['nazwa'];
        $sex=$_POST['sex'];
        $opis=$_POST['opis'];
        $cena=(int)$_POST['cena'];
        $kolor=$_POST['kolor'];
        $zdjecia=$_POST['zdjecia'];
        $para=$_POST['para'];
        
        if(($action=='edit' && $id < 1) || ($action=='add' && $id < 0)) return INVALID_USER_ID;
        $nazwa=$this->dbo->real_escape_string($nazwa);
        $sex=$this->dbo->real_escape_string($sex);
        $opis=$this->dbo->real_escape_string($opis);
        $cena=$this->dbo->real_escape_string($cena);
        $kolor=$this->dbo->real_escape_string($kolor);
        $zdjecia=$this->dbo->real_escape_string($zdjecia);
        $para=$this->dbo->real_escape_string($para);
        
        if($action=='edit'){
            $query="UPDATE Bransoletki Set Nazwa='$nazwa',Sex='$sex',Opis='$opis',Cena='$cena',Kolor='$kolor',Images='$zdjecia',Para='$para' WHERE `Id`='$id'";
        }else{
            if($id > 0){
                $query="SELECT `Id` FROM Bransoletki WHERE `Id`='$id'";
                if($this->getQuerySingleResult($query) !== false){
                    return USER_ID_ALREADY_EXISTS;
                }
            }
            $query="INSERT INTO Bransoletki VALUES('$id','$nazwa','$sex','$opis','$cena','$kolor','$zdjecia','$para')";
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
    function delete(){
        if(!$this->dbo) return SERVER_ERROR;
        if(!isset($_GET['id']) || $_GET['id']<1){
            return INVALID_USER_ID;
        }
        $id=(int)$_GET['id'];
        $query="DELETE FROM Bransoletki WHERE `Id`=$id";
        if(!$this->dbo->query($query)){
            return SERVER_ERROR;
            if($this->dbo->affected_rows==0){
                return SERVER_ERROR;
            }else{
                return ACTION_OK;
            }
        }
        return ACTION_OK;
    }
}