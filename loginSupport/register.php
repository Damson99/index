<?php
if(!isset($sefora)) die();
switch($sefora->registerUser()){
    case ACTION_OK:
        $sefora->setMessage("Rejestracja udana.");
        header("Location:index.php?action=braceletFor&brn=all");
        break;
    case FORM_DATA_MISSING:
        $sefora->setMessage("Wypełnij wymagane pola formularza");
        header("Location:index.php?action=showRegForm");
        break;
    case INVALID_USER_NAME:
        $sefora->setMessage("Napisz imię i nazwisko dużą literą lub usuń znaki specjalne");
        header("Location:index.php?action=showRegForm");
        break;
    case INVALID_PASS:
        $sefora->setMessage("Hasło musi zawierać co najmniej:"."<br>"."*jedną cyfrę"."<br>"."*dużą literę"."<br>"."*jedną małą literę"."<br>"."*jeden znak z grupy !@#$%^&*()_+-=."."<br>"."*musi mieć długość przynajmniej 8 znaków"."<br>"."Nie może zawierać spacji.");
        header("Location:index.php?action=showRegForm");
        break;
    case PASSWORDS_DO_NOT_MATCH:
        $sefora->setMessage("Hasła różnią się od siebie");
        header("Location:index.php?action=showRegForm");
        break;
    case LOGIN_FAILED:
        $sefora->setMessage("Email musi zawierać od 5 do 50 znaków"."<br>"."hasło od 6 do 50"."<br>"."imię od 3 do 30"."<br>"."nazwisko od 3 do 30");
        header("Location:index.php?action=showRegForm");
        break;
    case USER_NAME_ALREADY_EXISTS:
        $sefora->setMessage("Ten adres email jest już zajęty");
        header("Location:index.php?action=showRegForm");
        break;
    case INVALID_ADDRESS:
        $sefora->setMessage("Sprawdź czy dobrze został wpisany adres zamieszkania");
        header("Location:index.php?action=showRegForm");
        break;
    case ACTION_FAILED:
        $sefora->setMessage("Obecnie rejestracja nie jest możliwa");
        header("Location:index.php?action=showRegForm");
        break;
    case SERVER_ERROR:
    default:
        $sefora->setMessage("Błąd serwera");
        header("Location:index.php?action=showRegForm");
}