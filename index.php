<?php
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
<?php if(!isset($sefora)) die();?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css"><link rel="stylesheet" type="text/css" href="css/mediaquery.css">
    <link rel="Shortcut icon" href="img/favicon.png">
    <title>Sefora</title>
</head>
<body>
    <div>
        <?php require("header.php"); ?><br><br><br><br><br>
        <main>
            <div class="komunikat">
                <?php
                    if($komunikat){
                        echo $komunikat;
                    }
                ?>
            </div>
            <?php
                switch($action){
                    case 'login':
                        include 'loginSupport/login.php';
                        break;
                    case 'registerUser':
                        include 'loginSupport/register.php';
                        break;
                    case 'showRegForm':
                        if($sefora->zalogowany){
                            $sefora->setMessage("Jesteś zalogowany");
                            header("Location:index.php?action=braceletFor&brn=all");
                        }
                        $sefora->showRegForm();
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
                    case 'showDetails':
                        $sefora->showDetails();
                        break;
                    case 'showBasket':
                        $sefora->showBasket();
                        break;
                    case 'toBasket':
                        switch($sefora->toBasket()){
                            case ACTION_OK:
                                $sefora->setMessage("Dodano do koszyka");
                                break;
                            case INVALID_ID:
                                $sefora->setMessage("Błąd");
                                break;
                        }
                        header("Location:index.php?action=showBasket");
                        break;
                    case 'deleteBasket':
                        $sefora->deleteBasket();
                        header("Location:index.php?action=showBasket");
                        break;
                    case 'checkout':
                        $sefora->checkout();
                        break;
                    case 'showAdressForm':
                        $sefora->showAdressForm();
                        break;
                    case 'registerAdress':
                        $reg=new Registration($sefora->dbo);
                        switch($reg->registerAdress()){
                            case ACTION_OK:
                                $sefora->setMessage("Akcja udana.");
                                header("Location:index.php?action=showBasket");
                                /*dolacz formularz z platnosciami*/
                                break;
                            case FORM_DATA_MISSING:
                                $sefora->setMessage("Wypełnij wymagane pola formularza");
                                header("Location:index.php?action=userAdressForm");  
                                break;
                            case LOGIN_FAILED:
                                $sefora->setMessage("Podane frazy są za krótkie lub za długie");
                                header("Location:index.php?action=userAdressForm");  
                                break;
                            case NO_LOGIN_REQUIRED:
                                $sefora->setMessage("Najpierw się zaloguj.");
                                header("Location:index.php?action=userAdressForm");  
                                break;
                            case SERVER_ERROR:
                                $sefora->setMessage("Błąd serwera");
                                header("Location:index.php?action=userAdressForm");
                                break;
                        }
                        break;
                    case 'saveOrder':
                        $id=0;
                        $basket=new Basket($sefora->dbo);
                        switch($basket->saveOrder($id)){
                            case EMPTY_BASKET:
                                $sefora->setMessage("Koszyk jest pusty");
                                return;
                            case LOGIN_REQUIRED:
                                $sefora->setMessage("Musisz się zalogować");
                                header("Location:index.php?action=showLoginForm");
                                break;
                            case ACTION_OK:
                                $sefora->setMessage("Zamówienie zostało złożone. Identyfikator zamówienia to: ".$id);
                                header("Location:index.php?action=braceletFor&brn=all");
                                return;
                            case SERVER_ERROR:
                                $sefora->setMessage("Błąd serwera");
                        }
                        header("Location:index.php?action=checkout");
                        break;
                    case 'toWishList':
                        switch($sefora->toWishList()){
                            case ACTION_OK:
                                $sefora->setMessage("Dodano");
                                break;
                            case NO_LOGIN_REQUIRED:
                                $sefora->setMessage("Musisz się najpierw zalogować");
                                break;
                            case INVALID_ID;
                                $sefora->setMessage("Nieprawidłowy identyfikator");
                                break;
                            case USER_NAME_ALREADY_EXISTS:
                                $sefora->setMessage("Dany produkt jest już na liście życzeń");
                                break;
                            case SERVER_ERROR:
                                $sefora->setMessage("Błąd serwera"); 
                        }
                        header("Location:index.php?action=showWishList");
                        break;
                    case 'showWishList':
                        switch($sefora->showWishList()){
                            case ACTION_OK:
                                $sefora->setMessage("Dodano nowy produkt");
                                break;
                            case EMPTY_BASKET:
                                echo '<center><h3>Lista życzeń jest pusta</h3></center><br><br>';
                                break;
                            case LOGIN_REQUIRED:
                                echo '<center><h3>Najpierw musisz się zalogować</h3></center>';
                                break;
                            case SERVER_ERROR:
                                $sefora->setMessage("Błąd serwera");
                                break;
                        }
                        break;
                    case 'deleteWishList':
                        switch($sefora->deleteWishList()){
                            case ACTION_OK:
                                $sefora->setMessage("Usunięto");
                                break;
                            case LOGIN_REQUIRED:
                                $sefora->setMessage("Musisz się zalogować");
                                break;
                            case INVALID_ID;
                                $sefora->setMessage("Nieprawidłowy identyfikator");
                                break;
                            case SERVER_ERROR:
                                $sefora->setMessage("Błąd serwera");
                        }
                        header("Location:index.php?action=showWishList");
                        break;
                    case 'changePassForm':
                        $sefora->changePassForm();
                        break;
                    case 'checkPass':
                        switch($sefora->checkPass()){
                            case ACTION_OK:
                                $sefora->setMessage("Zmieniono hasło");
                                header("Location:index.php?action=braceletFor&brn=all");
                                break;
                            case FORM_DATA_MISSING:
                                $sefora->setMessage("Wypełnij wymagane pole formularza");
                                header("Location:index.php?action=changePassForm");
                                break;
                            case LOGIN_FAILED:
                                $sefora->setMessage("Hasło musi zawierać od 6 do 50 znaków");
                                header("Location:index.php?action=changePassForm");
                                break;
                            case INVALID_PASS:
                                $sefora->setMessage("Stare hasło jest nieprawidłowe");
                                header("Location:index.php?action=changePassForm");
                                break;
                            case SERVER_ERROR:
                                $sefora->setMessage("Błąd serwera");
                                header("Location:index.php?action=changePassForm"); 
                        }
                        break;
                    case 'deleteAccountForm':
                        include 'templates/deleteForm.php';
                        break;
                    case 'deleteAccount':
                        switch($sefora->deleteAccount()){
                            case ACTION_OK:
                                $sefora->setMessage("Usunięto"); 
                                header("Location:index.php?action=braceletFor&brn=all");
                                break;
                            case SERVER_ERROR:
                                $sefora->setMessage("Błąd serwera");
                                header("Location:index.php?action=deleteAccountForm");
                        }
                        break;
                    case 'showMain':
                    default:
                        include 'main.php';
                } 
            ?>
            <a href="" class="backToTop">&#8743;</a>
        </main>
        <?php include 'footer.php'; ?> 
        <center>Copyright © Sefora</center><br>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="templates/scrollForm.js"></script>
    <script src="templates/scrollMenu.js"></script>
    <script src="templates/slider.js"></script>
</body>
</html>