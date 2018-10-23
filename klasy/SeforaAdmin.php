<?php
include 'constants.php';
class SeforaAdmin{
    private $dbo=null;
    
    function __construct($host,$user,$pass,$db){
        $this->dbo=$this->initDB($host,$user,$pass,$db);
        $this->zalogowany_adm=$this->getActualAdmin();
    }
    function initDB($host,$user,$pass,$db){
        $dbo = new mysqli($host,$user,$pass,$db);
        if($dbo->connect_errno){
            $msg="Brak połączenia z bazą: ".$dbo->connect_error;
            throw new Exception($msg);
        }
        return $dbo;
    }
    function getActualAdmin(){
        if(isset($_SESSION['zalogowany_adm'])){
            return $_SESSION['zalogowany_adm'];
        }else{
            return null;
        }
    }
    function setAdminMessage($komunikat_adm){
        $_SESSION['komunikat_adm']=$komunikat_adm;
    }
    function getAdminMessage(){
        if(isset($_SESSION['komunikat_adm'])){
            $komunikat_adm=$_SESSION['komunikat_adm'];
            unset($_SESSION['komunikat_adm']);
            return $komunikat_adm;
        }else{
            return null;
        }
    }
    function loginAdmin(){
        if(!$this->dbo) return SERVER_ERROR;
        if(!isset($_POST['user']) || !isset($_POST['haslo'])){
            return LOGIN_FAILED;
        }
        $user=$_POST['user'];
        $pass=$_POST['haslo'];
        $userLength=strlen($user);
        $passLength=strlen($pass);
        if($userLength < 5 || $userLength > 50 || $passLength < 6 || $passLength > 50){
            return LOGIN_FAILED;
        }
        $user=$this->dbo->real_escape_string($user);
        $pass=$this->dbo->real_escape_string($pass);
        $query="SELECT `Id`, `Imie`, `Haslo` FROM Klienci WHERE `Imie`='$user'";
        if(!$result=$this->dbo->query($query)){
            return SERVER_ERROR;
        }
        if($result->num_rows <> 1){
            return LOGIN_FAILED;
        }else{
            $row=$result->fetch_row();
            $pass_db=$row[2];
            $salt='5o3_5$f';
            $blowfish='3S1$5_3';
            $hashedPass=crypt($pass,$salt.$blowfish);
            if($hashedPass !== $pass_db){
                return LOGIN_FAILED;
            }else{
                $nazwa=$row[1];
                $_SESSION['zalogowany_adm'] = new User($row[0],$nazwa);
                $this->zalogowany=new User($row[0],$nazwa);
                if(!isset($_SESSION['przywileje'])){
                    $_SESSION['przywileje']=array();
                }
                $query="SELECT PrzywilejeId FROM Klienci_Przywileje WHERE UserId='$row[0]'";
                if($result=$this->dbo->query($query)){
                    while($row=$result->fetch_row()){
                        $_SESSION['przywileje']=$row[0];
                    }
                }
                if($_SESSION['przywileje']!=='1'){
                    return NO_ADMIN_RIGHTS;
                }
                return LOGIN_OK;
            }
        }
    }
    function logoutAdmin(){
        if(isset($_SESSION['zalogowany_adm'])){
            $this->zalogowany_adm = null;
            unset($_SESSION['zalogowny_adm']);
            unset($_SESSION['przywileje']);
            if(isset($_COOKIE[session_name()])){
                setcookie(session_name(),'',time() - 3600);
            }
            session_destroy();
        }
    }
    function braceletsAdmin(){
        $ba = new BraceletsAdmin($this->dbo);
        if(isset($_GET['wtd'])){
            $wtd=$_GET['wtd'];
        }else{
            $wtd='';
        }
        switch($wtd){
            case 'showOrders':
                $limit=20;
                switch($ba->showOrders($limit)){
                    case SERVER_ERROR:
                        $this->setAdminMessage("Błąd serwera");
                        header("Location:index2.php?action=braceletsAdmin&wtd=showOrders");
                        break;
                }
                break;
            case 'orderDetails':
                switch($ba->orderDetails()){
                    case INVALID_ID:
                        $this->setAdminMessage("Błędny identyfikator");
                        break;
                    case SERVER_ERROR:
                        $this->setAdminMessage("Błąd serwera");
                        break;
                }
                break;
            case 'orderDetailsBrn':
                switch($ba->orderDetailsBrn()){
                    case INVALID_ID:
                        $this->setAdminMessage("Błędny identyfikator");
                        break;
                    case SERVER_ERROR:
                        $this->setAdminMessage("Błąd serwera");
                        break;
                }
                break;
            case 'updateOrders':
                switch($ba->updateOrders()){
                    case ACTION_OK:
                        $this->setAdminMessage("Zaktualizowano");
                        break;
                    case INVALID_ID:
                        $this->setAdminMessage("Nieprawidłowy identyfikator");
                        break;
                    case SERVER_ERROR:
                        $this->setAdminMessage("Błąd serwera");
                        break;
                }
                header("Location:index2.php?action=braceletsAdmin&wtd=showOrders");
                break;
            case 'addBraceletForm':
                $ba->addBraceletForm('add');
                break;
            case 'editBraceletForm':
                $ba->addBraceletForm('edit');
                break;
            case 'addBracelet':
                switch($ba->editBracelet('add',$id)){
                    case ACTION_OK:
                        $this->setAdminMessage("Dodano nową bransoletkę");
                        break;
                    case FORM_DATA_MISSING:
                        $this->setAdminMessage("Wypełnij wszystkie pola");
                        break;
                    case USER_ID_ALREADY_EXISTS:
                        $this->setAdminMessage("Bransoletka z danym Id już istnieje");
                        break;
                    case SERVER_ERROR:
                    default:
                        $this->setAdminMessage("Błąd serwera");
                }
                header("Location:index2.php?action=braceletsAdmin&wtd=addBraceletForm");
                break;
            case 'editBracelet':
                switch($ba->editBracelet('edit',$id)){
                    case ACTION_OK:
                        $this->setAdminMessage("Edytowano bransoletkę");
                        break;
                    case SERVER_ERROR:
                    default:
                        $this->setAdminMessage("Błąd serwera");
                }
                header("Location:index2.php?action=braceletsAdmin&wtd=addBraceletForm");
                break;
            case 'searchBraceletForm':
                $ba->searchBraceletForm();
                break;
            case 'searchBracelet':
                switch($ba->searchBracelet()){
                    case ACTION_OK:
                        break;
                    case USER_NOT_FOUND:
                        echo "Nie znaleziono bransoletki";
                        break;
                    case FORM_DATA_MISSING:
                        echo "Wypełnij pola w formularzu";
                        break;
                    case INVALID_USER_ID:
                        echo "Nieprawidłowy identyfikator";
                        break;
                    case INVALID_USER_NAME:
                        echo "Błędna nazwa bransoletki";
                        break;
                    case SERVER_ERROR:
                    default:
                        echo "Błąd serwera";
                }
                break;
            case 'deleteBracelet':
                switch($ba->delete()){
                    case ACTION_OK:
                        $this->setAdminMessage("Usunięto bransoletkę");
                        break;
                    case USER_NOT_FOUND:
                        $this->setMessage("Nie znaleziono bransoletki");
                        break;
                    case INVALID_USER_ID:
                        $this->setAdminMessage("Nieprawidłowy identyfikator");
                        break;
                    case SERVER_ERROR:
                    default:
                        $this->setAdminMessage("Błąd serwera");
                }
                header("Location:index2.php?action=braceletsAdmin&wtd=addBraceletForm");
                break;
        }
    }
    function usersAdmin(){
        $ua = new UsersAdmin($this->dbo);
        if(isset($_GET['wtd'])){
            $wtd=$_GET['wtd'];
        }else{
            $wtd='';
        }
        switch($wtd){
            case 'deleteUser':
                switch($ua->delete()){
                    case ACTION_OK:
                        $this->setAdminMessage("Usunięto użytkownika");
                        break;
                    case USER_NOT_FOUND:
                        $this->setMessage("Nie znaleziono użytkownika");
                        break;
                    case INVALID_USER_ID:
                        $this->setAdminMessage("Nieprawidłowy identyfikator");
                        break;
                    case SERVER_ERROR:
                    default:
                        $this->setAdminMessage("Błąd serwera");
                }
                header("Location:index2.php?action=usersAdmin&wtd=showList");
                break;
            case 'showEditForm':
                $ua->showEditForm('edit');
                break;
            case 'showAddForm':
                $ua->showEditForm('add');
                break;
            case 'showSearchForm':
                $ua->showSearchForm();
                break;
            case 'addUser':
                $id=0;
                switch($ua->editUser('add',$id)){
                    case FORM_DATA_MISSING:
                        $this->setAdminMessage("Uzupełnij wszystkie pola, które nie dotyczą adresu");
                        break;
                    case ACTION_OK:
                        $this->setAdminMessage("Dodano nowego użytkownika (Id=$id)");
                        break;
                    case INVALID_USER_ID:
                        $this->setAdminMessage("Nieprawidłowy identyfikator");
                        break;
                    case INVALID_USER_NAME:
                        $this->setAdminMessage("Nieprawidłowa nazwa");
                        break;
                    case USER_EMAIL_ALREADY_EXISTS:
                        $this->setAdminMessage("Ten email jest zajęty");
                        break;
                    case USER_ID_ALREADY_EXISTS:
                        $this->setAdminMessage("Istnieje użytkownik o podanym identyfikatorze");
                        break;
                    case SERVER_ERROR:
                    default:
                        $this->setAdminMessage("Błąd serwera");
                }
                header("Location:index2.php?action=usersAdmin&wtd=showAddForm");
                break;
            case 'modifyUser':
                $id=0;
                switch($ua->editUser('edit',$id)){
                    case ACTION_OK:
                        $this->setAdminMessage("Dane zostały zmienione");
                        break;
                    case INVALID_USER_ID:
                        $this->setAdminMessage("Nieprawidłowy identyfikator");
                        break;
                    case INVALID_USER_NAME:
                        $this->setAdminMessage("Nieprawidłowa nazwa");
                        break;
                    case USER_EMAIL_ALREADY_EXISTS:
                        $this->setAdminMessage("Ten email jest zajęty");
                        break;
                    case USER_NAME_ALREADY_EXISTS:
                        $this->setAdminMessage("Ta nazwa jest zajęta");
                        break;
                    case FORM_DATA_MISSING:
                        $this->setAdminMessage("Brak danych");
                        break;
                    case SERVER_ERROR:
                    default:
                        $this->setAdminMessage("Błąd serwera");
                }
                header("Location:index2.php?action=usersAdmin&wtd=showEditForm&id=$id");
                break;
            case 'searchUser':
                switch($ua->searchUser()){
                    case ACTION_OK:
                        break;
                    case USER_NOT_FOUND:
                        echo "Nie znaleziono użytkonika";
                        break;
                    case FORM_DATA_MISSING:
                        echo "Wypełnij pola w formularzu";
                        break;
                    case INVALID_USER_ID:
                        echo "Nieprawidłowy identyfikator";
                        break;
                    case INVALID_USER_NAME:
                        echo "Błędna nazwa użytkownika";
                        break;
                    case SERVER_ERROR:
                    default:
                        echo "Błąd serwera";
                }
                break;
            case 'showList':
                $ua->showList(ROWS_ON_PAGE);
                break;
        }
    }
}




