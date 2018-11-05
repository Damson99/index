<?php if(!$this) die();?>
<b><center>Id ostatniej bransoletki <?php $this->lastId();?></center></b>

<div id="loginFormWrapper">
    <img src="img/imageLog.jpg" class="imageLog"><br>
    <h1>Dodaj nową bransoletkę</h1>
    <form action="index2.php?action=braceletsAdmin&wtd=<?=$wtd?>" method="post">
        <p>Id</p>
        <input type="number" placeholder="Id" name="id" value="<?=$id?>">
        <p>Nazwa</p>
        <input type="text" placeholder="Nazwa" name="nazwa" value="<?=$nazwa?>">
        <p>Płeć: d-Damska m-Męska u-Unisex</p>
        <input type="text" placeholder="Płeć" name="sex" value="<?=$sex?>">
        <p>Opis</p>
        <textarea placeholder="Opis bransoletki" name="opis"><?=$opis?></textarea>
        <p>Cena</p>
        <input type="number" placeholder="Cena" name="cena" value="<?=$cena?>">
        <p>Kolor</p>
        <input type="text" placeholder="Kolor" name="kolor" value="<?=$kolor?>">
        <p>Zdjęcia</p>
        <input type="text" placeholder="1_1.1_2.1_3." name="zdjecia" value="<?=$zdjecia?>">
        <p>Dla par - 1; pojedyncze - 0</p>
        <input type="number" placeholder="0" name="para" value="<?=$para?>">
        <input type="submit" value="Zapisz"><br>
        <?php if($wtd=='editBracelet'):?>
            <center><a href="index2.php?action=braceletsAdmin&amp;wtd=deleteBracelet&amp;id=<?=$id?>">Usuń</a></center>
        <?php endif;?>
    </form>
    <?php 
        if(isset($komunikat_adm)){
            echo $komunikat_adm;
        }
    ?>
</div>