<?php if(!$this) die();?>
<div id="loginFormWrapper">
    <img src="imageLog.jpg" class="imageLog"><br>
    <h1>Zarejestruj się</h1><br>
    <i>*Pola z adresem zamieszkania są opcjonalne i wymagane tylko przy zamówieniach.</i><br><br>
    <form name="regForm" action="index.php?action=registerUser" method="post">
        <div>
            <?php
                foreach($formData as $input){
                    echo "<p>$input->description</p>";
                    echo $input->getInputHTML();
                }
            ?>
            <input type="submit" value="Zarejestruj">
            <a href="index.php">Wróć do strony głównej</a>
        </div>
    </form>
    <div class="komunikat">
        <?php
            if(isset($komunikat)){
                echo $komunikat;
            }
        ?>
    </div>
</div>