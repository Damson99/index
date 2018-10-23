<?php if(!$this) die();?>
<?php /*$this->show("Podsumowanie");*/?>
<center>
    <p>1. Koszyk</p>
    <p>2. Moje dane</p>
    <p>3. Płatność</p>
</center>
<div id="basketDetails"style="grid-template-columns:none">
    <h1>Dane do wysyłki</h1>
</div>
<div id="basketDetails">
    <div style="border-right:1px solid #999999;">
        <hr><br><br>
        <?php /*$this->showRegForm('up');*/?> 
    </div>
    <div>
        <?php if(!isset($_SESSION['zalogowany'])){?>
            <h1>Jeśli posiadzasz konto zaloguj się.</h1><hr><br><br>
            <?php include 'loginSupport/loginForm.php';
        }?>
    </div>
        <p><a href="index.php?action=showBasket">&#10094; Wróć do koszyka</a></p>
</div>