<?php
include 'constants.php';
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
$action='showLoginFormAdmin';
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
                    break;
                case LOGIN_FAILED:
                    $sefora->setAdminMessage("Nieprawidłowa nazwa lub hasło");
                    break;
                case NO_ADMIN_RIGHTS:
                    $sefora->setAdminMessage("Brak uprawnień");
                    $sefora->logoutAdmin();
                    break;
                case SERVER_ERROR:
                default:
                    $sefora->setAdminMessage("Błąd serwera. Przepraszamy");
                    $sefora->logoutAdmin();
            }
            header("Location:index2.php");
        }
        break;
    case 'logoutAdmin':
        $sefora->logoutAdmin();
        header("Location:index2.php");
}
if(!isset($sefora->zalogowany_adm)){
    /*$action='showLoginForm';*/
    $action='addBransolet';
}
$limit=5;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="Shortcut icon" href="favicon.png">
    <title>Sefora Administracja</title>
</head>
<body>
    <?php require 'adminTemplates/headerAdmin.php';
    switch($action){  
        case 'showLoginForm':
            include 'adminTemplates/loginFormAdmin.php';
            $sefora->usersAdmin();
            break;
        case 'usersAdmin':
        default:
            include 'adminTemplates/usersAdminMenu.php';
            $sefora->usersAdmin();
    }
    ?>
</body>
</html>