<?php
class MyDB extends mysqli{
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
}