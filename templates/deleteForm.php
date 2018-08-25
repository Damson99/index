<?php if(!$sefora) die();?>
<br><br>
<h1><?=$nazwa?> Czy na pewno chcesz usunąć swoje konto?</h1>
<center>
    <h2><a href="index.php?action=deleteAccount">Usuń</a></h2>
    <h3><a href="index.php">Wróć do strony głównej</a></h3>
    <?php if(isset($komunikat)):?>
        <div class="komunikat"><?=$komunikat?></div>
    <?php endif;?>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</center>