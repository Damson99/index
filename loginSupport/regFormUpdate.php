<div id="loginFormWrapper">
    <?php if(isset($_SESSION['zalogowany'])):?>
        <img src="img/imageLog.jpg" class="imageLog"><br>
        <h1>Dane do wysyłki</h1><br><br>
        <form name="formUpdate" action="index.php?action=userUpdate" method="post">
            <div>
                <?php
                    $i=3;
                    foreach($formData as $input){
                        echo "<p>$input->description</p>";
                        $input->value=$rowForm[$i];
                        $i++;
                        echo $input->getInputHTML();
                        if($i===11){
                            break;
                        }
                    }
                ?>
                <p><input type="submit" value="Potwierdź"></p>
                <a href="index.php?action=braceletFor&brn=all">Wróć do strony głównej</a>
            </div>
        </form>
    <?php else:?>
        <form><img src="img/imageLog.jpg" class="imageLog"><br><br><br>
            <h1><a href="index.php?action=showRegForm">Zarejestruj się</a></h1><br></form>
    <?php endif;?>
</div>