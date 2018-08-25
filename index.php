<?php
include 'constants.php';
spl_autoload_register('classLoader');
session_start();

try{
    $sefora = new Sefora("localhost","user1","kl842d","sefora");
}catch(Exception $e){
    echo "Problem z bazą danych".$e->getMessage();
    exit("Portal chwilowo niedostępny");
}
function classLoader($nazwa){
    if(file_exists("klasy/$nazwa.php")){
        require_once("klasy/$nazwa.php");
    }else{
        throw new Exception("Brak pliku z definicją klasy");
    }
}
$action='showMain';
if(isset($_GET['action'])){
    $action=$_GET['action'];
}
$komunikat = $sefora->getMessage();
?>
<?php if(!isset($sefora)) die(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="Shortcut icon" href="favicon.png">
    <title>Sefora</title>
</head>
<body>
    <div>
        <?php require("header.php"); ?>
        <main>
            <?php
                switch($action){
                    case 'login':
                        include 'loginSupport/login.php';
                        break;
                    case 'registerUser':
                        include 'loginSupport/register.php';
                        break;
                    case 'logout':
                        include 'loginSupport/logout.php';
                        break;
                    case 'showSearchResult':
                        $sefora->showSearchResult();
                        break;
                    case 'showLoginForm':
                        if($sefora->zalogowany){
                            $sefora->setMessage("Jesteś zalogowany");
                        }
                        include 'loginSupport/loginForm.php';
                        break;
                    case 'showRegForm':
                        if($sefora->zalogowany){
                            $sefora->setMessage("Posiadasz już konto");
                        }
                        $sefora->showRegForm();
                        break;
                    case 'showDetails':
                        $sefora->showDetails();
                        break;
                    case 'showBasket':
                        $sefora->showBasket();
                        break;
                    case 'toBasket':
                        switch($sefora->toBasket()){
                            case INVALID_ID:
                            case FORM_DATA_MISSING:
                                $sefora->setMessage("Błędny identyfikator");
                                break;
                            case ACTION_OK:
                                $sefora->setMessage("Dodano");
                                break;
                            default:
                                $sefora->setMessage("Błąd serwera");
                        }
                        header("Location:index.php?action=showBasket");
                        break;
                    case 'modifyBasket':
                        $sefora->setMessage("Zaktualizowano");
                        $sefora->modifyBasket();
                        header("Location:index.php?action=showBasket");
                        break;
                    case 'deleteBasket':
                        header("Location:index.php?action=showBasket");
                        break;
                    case 'checkout':
                        $sefora->checkout();
                        break;
                    case 'editAccountForm':
                        $sefora->showEditForm();
                        break;
                    case 'editAccount':
                        switch($sefora->editAccount()){
                            case ACTION_OK:
                                $sefora->setMessage("Uaktualniono"); 
                                header("Location:index.php");
                                break;
                            case SERVER_ERROR:
                            default:
                                $sefora->setMessage("Błąd serwera");
                                header("Location:index.php?action=editAccountForm"); 
                        }
                    case 'deleteAccountForm':
                        include 'templates/deleteForm.php';
                        break;
                    case 'deleteAccount':
                        switch($sefora->deleteAccount()){
                            case ACTION_OK:
                                $sefora->setMessage("Usunięto"); 
                                header("Location:index.php");
                                break;
                            case SERVER_ERROR:
                            default:
                                $sefora->setMessage("Błąd serwera");
                                header("Location:index.php?action=deleteAccountForm");
                        }
                        break;
                    case 'showMain':
                    default:
                        include 'main.php';
                        $sefora->bransoletFor();
                } 
            ?>
        </main>
        <?php include 'footer.php'; ?>   
    </div>
</body>
</html>