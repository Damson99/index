<?php
class Bracelets{
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
    function getNews($limitNews,$toBack){
        $query="SELECT `Id`,`Nazwa`,`Sex`,`Cena`,`Images` FROM Bransoletki ORDER BY Id DESC LIMIT $limitNews,$toBack";
        if(!$result=$this->dbo->query($query)) $komunikat="Błąd";
        include 'templates/searchResult.php';
    }
    function getBracelets($sex,$limit,$jewellery){
        $limit=20;
        if(!$this->dbo){
            echo "Wystąpił błąd. Proszę wrócić później";
            return;
        }
        if(isset($_GET['page'])){
            $page=intval($_GET['page']);
        }else{
            $page=0;
        }
        $query="SELECT COUNT(*) FROM Bransoletki";
        $rowsCount=(int)$this->getQuerySingleResult($query);
        $pages=ceil($rowsCount/$limit);
        if($page < 0 || $page >= $pages) $page=0;
        $offset=$page*$limit;
        $query="SELECT `Id`,`Nazwa`,`Sex`,`Cena`,`Images` FROM Bransoletki $sex $jewellery LIMIT $offset, $limit";
        if(!$result=$this->dbo->query($query)){
            return;
        }
        include 'templates/searchResult.php';
        if(isset($_GET['brn'])){
            $brn=$_GET['brn'];
        }
        ?>
        <center>
            <div id="pagination">
                <?=$this->getPagination($page,$pages,"index.php?action=braceletFor&amp;brn=$brn",'Idź do strony ');?>
            </div>
        </center>
        <?php
    }
    function getCouple($kind,$brn){
        $limit=20;
        if(!$this->dbo){
            echo "Wystąpił błąd. Proszę wrócić później";
            return;
        }
        if(isset($_GET['page'])){
            $page=intval($_GET['page']);
        }else{
            $page=0;
        }
        $query="SELECT COUNT(*) FROM Bransoletki";
        $rowsCount=(int)$this->getQuerySingleResult($query);
        $pages=ceil($rowsCount/$limit);
        if($page < 0 || $page >= $pages) $page=0;
        $offset=$page*$limit;
        $query="SELECT `Id`,`Nazwa`,`Sex`,`Cena`,`Images` FROM Bransoletki $kind LIMIT $offset, $limit";
        if(!$result=$this->dbo->query($query)){
            return;
        }
        echo "<div class="."pOfferts".">Biżuteria dla par $brn</div>";
        if(!$this->dbo){
            echo "Wystąpił błąd. Proszę wrócić później";
            return;
        }
        $query="SELECT `Id`,`Nazwa`,`Sex`,`Cena`,`Images`,`Para` FROM Bransoletki $kind";
        if(!$result=$this->dbo->query($query)){
            return;
        }
        include 'templates/searchResult.php';
        if(isset($_GET['brn'])){
            $brn=$_GET['brn'];
        }
        ?>
        <center>
            <div id="pagination">
                <?=$this->getPagination($page,$pages,"index.php?action=couple&amp;brn=$brn",'Idź do strony ');?>
            </div>
        </center>
        <?php
    }
    function toWishList(){
        if(!$this->dbo) return SERVER_ERROR;
        if(!isset($_SESSION['zalogowany'])){
            return LOGIN_REQUIRED;
        }else{
            $userId=$_SESSION['zalogowany']->id;
        }
        if(!isset($_GET['id'])){
            return INVALID_ID;
        }
        if(($braceletId=(int)$_GET['id']) < 1){
            return INVALID_ID;
        }
        $query="SELECT COUNT(*) FROM Zyczenia WHERE bransoletId='$braceletId' AND userId='$userId'";
        if($result=$this->getQuerySingleResult($query)){
            return USER_NAME_ALREADY_EXISTS;
        }else{
            $query="INSERT INTO Zyczenia VALUES($userId,$braceletId)";
            if(!$this->dbo->query($query)){
                return SERVER_ERROR;
            }
        }
        return ACTION_OK;
    }
    function showWishList(){
        echo '<div class="pOfferts">Lista życzeń</div>';
        if(!$this->dbo) return SERVER_ERROR;
        if(!isset($_SESSION['zalogowany'])){
            return LOGIN_REQUIRED;
        }else{
            $userId=(int)$_SESSION['zalogowany']->id;
        }
        $query="SELECT COUNT(*) FROM Zyczenia WHERE userId='$userId'";
        if(($singleResult=(int)$this->getQuerySingleResult($query)) < 1){
            return EMPTY_BASKET;
        }else{
            $query="SELECT `Id`,`Nazwa`,`Sex`,`Cena`,`Images`,'bransoletId' FROM Bransoletki LEFT JOIN Zyczenia ON Bransoletki.Id=Zyczenia.bransoletId WHERE Zyczenia.userId='$userId'";
            if(!$result=$this->dbo->query($query)){
                return SERVER_ERROR;
            }
        }
        include 'templates/wishList.php';
    }
    function deleteWishList(){
        if(!$this->dbo) return SERVER_ERROR;
        if(!isset($_SESSION['zalogowany'])){
            return LOGIN_REQUIRED;
        }else{
            $userId=(int)$_SESSION['zalogowany']->id;
        }
        if(!isset($_GET['id'])){
            return INVALID_ID;
        }
        if(($braceletId=(int)$_GET['id']) < 1){
            return INVALID_ID;
        }
        $query="DELETE FROM Zyczenia WHERE `bransoletId`='$braceletId' AND `userId`='$userId'";
        if(!$this->dbo->query($query)){
            return SERVER_ERROR;
            if($this->dbo->affected_rows==0){
                return INVALID_ID;
            }else{
                return ACTION_OK;
            }
        }
        return ACTION_OK;
    }
    function showSearchResult(){
        if($_POST['bransoletka'] != ''){
            $bransoletka=filter_input(INPUT_POST,'bransoletka',FILTER_SANITIZE_SPECIAL_CHARS);
            $cond="`Nazwa` LIKE '%$bransoletka%'";
        }else{
            $cond='';
            header("Location:index.php?action=braceletFor&brn=$brn");
        }
        $query="SELECT `Id`,`Nazwa`,`Sex`,`Cena`,`Images` FROM Bransoletki WHERE $cond GROUP BY `Id` ORDER BY `Nazwa`";
        $komunikat=false;
        if(!$result=$this->dbo->query($query)){
            $komunikat="Wyniki wyszukiwania chwilowo są niedostępne";
        }else if($result->num_rows < 1){
            $komunikat="Brak wyników";
        }
        include 'templates/searchResult.php';
    }
    function getPagination($page,$pages,$link,$msg){
        $str='';
        for($i=0;$i<$pages;$i++){
            if($i!=$page){
                $str.="<a href=\"$link&amp;page=$i\">".($i+1)."</a>";
            }else{
                $str.='<span class="activePagination">'.($i+1).'</span>';
            }
            $str.='<span class="space"></span>';
        }
        $str=$msg.$str;
        return $str;
    }
}