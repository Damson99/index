<?php
spl_autoload_register('classLoader');
session_start();

try{
    $sefora=new SeforaAdmin("localhost","user1","kl842d","sefora");
}catch(Exception $e){
    exit('Panel administracyjny jest niedostępny');
}
function classLoader($nazwa){
    if(file_exists("klasy/$nazwa.php")){
        require_once("klasy/$nazwa.php");
    }else{
        throw new Exception("Brak pliku z definicją klasy");
    }
}
$action='showLoginForm';
if(isset($_GET['action'])){
    $action=$_GET['action'];
}
$komunikat_adm=$sefora->getAdminMessage();
switch($action){
    case 'loginAdmin':
        if(!$sefora->zalogowany_adm){
            switch($sefora->loginAdmin()){
                case LOGIN_OK:
                    $sefora->setAdminMessage("Zalogowano");
                    header("Location:index2.php?action=braceletsAdmin");
                    break;
                case LOGIN_FAILED:
                    $sefora->setAdminMessage("Nieprawidłowa nazwa lub hasło");
                    header("Location:index2.php");
                    break;
                case NO_ADMIN_RIGHTS:
                    $sefora->logoutAdmin();
                    header("Location:index.php?action=braceletFor&brn=all");
                    break;
                case SERVER_ERROR:
                    $sefora->setAdminMessage("Błąd serwera. Przepraszamy");
                    $sefora->logoutAdmin();
                    header("Location:index.php?action=braceletFor&brn=all");
                    break;
            }
        }
        break;
    case 'logoutAdmin':
        $sefora->logoutAdmin();
        header("Location:index2.php");
        break;
}
if(!isset($sefora->zalogowany_adm)){
    $action='showLoginForm';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="Shortcut icon" href="favicon.png">
    <title>Sefora Administracja</title>
</head>
<body>
    <?php require 'adminTemplates/headerAdmin.php';?>
    <div class="komunikat">
        <?php
            if($komunikat_adm){
                echo $komunikat_adm;
            }
        ?>
    </div>
    <?php
        switch($action){  
            case 'showLoginForm':
                include 'adminTemplates/loginFormAdmin.php';
                break;
            case 'usersAdmin':
                include 'adminTemplates/usersAdminMenu.php';
                $sefora->usersAdmin();
                break;
            case 'braceletsAdmin':
                include 'adminTemplates/usersAdminMenu.php';
                $sefora->braceletsAdmin();
                break;
        }
    ?>
</body>
</html>