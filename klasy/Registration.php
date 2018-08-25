<?php
class Registration{
    private $dbo=null;
    private $fields=array();
    
    function __construct($dbo){
        $this->dbo=$dbo;
        $this->initFields();
    }
    function initFields(){
        $this->fields['email'] = new FormInput('email','Email','','email');
        $this->fields['haslo'] = new FormInput('haslo','Hasło','','password');
        $this->fields['haslo2'] = new FormInput('haslo2','Powtórz hasło','','password');
        $this->fields['imie'] = new FormInput('imie','Imię');
        $this->fields['nazwisko'] = new FormInput('nazwisko','Nazwisko');
        $this->fields['ulica'] = new FormInput('ulica','Ulica',false);
        $this->fields['nr_domu'] = new FormInput('nr_domu','Numer domu',false);
        $this->fields['nr_mieszkania'] = new FormInput('nr_mieszkania','Numer mieszkania',false);
        $this->fields['miejscowosc'] = new FormInput('miejscowosc','Miejscowość',false);
        $this->fields['kod'] = new FormInput('kod','Kod pocztowy',false);
        $this->fields['kraj'] = new FormInput('kraj','Kraj',false);
    }
    function showRegForm(){
        foreach($this->fields as $name=>$field){
            $field->value=isset($_SESSION['formData'][$name]) ? $_SESSION['formData'][$name]:'';
        }
        $formData=$this->fields;
        if(isset($_SESSION['formData'])){
            unset($_SESSION['formData']);
        }
        include 'loginSupport/regForm.php';
    }
    function registerUser(){
        foreach($this->fields as $name=>$val){
            if(!isset($_POST[$name])){
                return FORM_DATA_MISSING;
            }
        }
        /*Wyrażenie regularne sprawdzające długość ciągów i niedozwolone znaki */
        $email=$_POST['email'];
        $haslo=$_POST['haslo'];
        $haslo2=$_POST['haslo2'];
        $imie=$_POST['imie'];
        $nazwisko=$_POST['nazwisko'];
        $ulica=$_POST['ulica'];
        $nr_domu=$_POST['nr_domu'];
        $nr_mieszkania=$_POST['nr_mieszkania'];
        $miejscowosc=$_POST['miejscowosc'];
        $kod=$_POST['kod'];
        $kraj=$_POST['kraj'];
        
        $check='/^[A-ZĄĘÓŁŚŻŹĆŃ]{1}+[a-ząęółśżźćń]+$/';
        $checkPass='/^(?=.*\d)(?=.*[a-z])(?=.*[\!\@\#\$\%\^\&\*\(\)\_\+\-\=])(?=.*[A-Z])(?!.*\s).{8,}$/';
        $checkNr='/^[1-1000]$/';
        $checkKod='/^[0-9]{2}[-][0-9]{3}$/';
        if(!preg_match($check,$imie) || !preg_match($check,$nazwisko)){
            INVALID_USER_NAME;
        }
        if(!preg_match($checkPass,$haslo) || !preg_match($checkPass,$haslo2)){
            INVALID_PASS;
        }
        if(($ulica || $nr_domu || $nr_mieszkania || $miejscowosc || $kod || $kraj) !=''){
            if(!preg_match($check,$ulica) || !preg_match($checkNr,$nr_domu) || !preg_match($checkNr,$nr_mieszkania) || !preg_match($check,$miejscowosc) || !preg_match($check,$miejscowosc) || !preg_match($checkKod,$kod) || !preg_match($check,$kraj)){
                INVALID_ADDRESS;
            }
        }
        /*koniec wyrażen regularnych*/
        $fieldsFromForm=array();
        $emptyFields=false;
        foreach($this->fields as $name=>$val){
            if($val->type != 'password'){
                $fieldsFromForm[$name]=filter_input(INPUT_POST,$name,FILTER_SANITIZE_SPECIAL_CHARS);
            }else{
                $fieldsFromForm[$name]=$_POST[$name];
            }
            $fieldsFromForm[$name]=$this->dbo->real_escape_string($fieldsFromForm[$name]);
            if($fieldsFromForm[$name]=='' && $val->required){
                $emptyFields=true;
            }
        }
        if($emptyFields){
            unset($fieldsFromForm['haslo']);
            unset($fieldsFromForm['haslo2']);
            $_SESSION['formData']=$fieldsFromForm;
            return FORM_DATA_MISSING;
        }
        $query="SELECT COUNT(*) FROM Klienci WHERE Email='".$fieldsFromForm['email']."'";
        if($this->dbo->getQuerySingleResult($query) > 0){
            return USER_NAME_ALREADY_EXISTS;
        }
        if($fieldsFromForm['haslo'] != $fieldsFromForm['haslo2']){
            return PASSWORDS_DO_NOT_MATCH;
        }
        unset($fieldsFromForm['haslo2']);
        unset($this->fields['haslo2']);
        $fieldsFromForm['haslo']=crypt($fieldsFromForm['haslo']);
        $fieldNames='`'.implode('`,`',array_keys($this->fields)).'`';
        $fieldVals='\''.implode('\',\'',$fieldsFromForm).'\'';
        $query="INSERT INTO Klienci ($fieldNames) VALUES ($fieldVals)";
        if($this->dbo->query($query)){
            return ACTION_OK;
        }else{
            return ACTION_FAILED;
        }
    }
}