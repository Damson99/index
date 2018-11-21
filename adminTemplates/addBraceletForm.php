<?php if(!$this) die();?>
<b><center>Id ostatniej bransoletki <?php $this->lastId();?></center></b>

<div id="loginFormWrapper">
    <img src="img/imageLog.jpg" class="imageLog"><br>
    <h1>Dodaj nową bransoletkę</h1>
    <form action="index2.php?action=braceletsAdmin&wtd=<?=$wtd?>" method="post" enctype="multipart/form-data">
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
        <p>Zdjęcia</p><br>
        <input type="file" name="file1">
        <input type="file" name="file2">
        <input type="file" name="file3">
        <input type="file" name="file4">
        <input type="file" name="file5">
        <input type="file" name="file6">
        <input type="file" name="file7">
        <input type="text" placeholder="nazwa.nazwa.nazwa." name="zdjecia" value="<?=$zdjecia?>">
        <p>Dla par - 1; pojedyncze - 0</p>
        <input type="number" max="1" min="0" placeholder="0" name="para" value="<?=$para?>">
        <input name="upload" type="submit" value="Zapisz"><br>
        <?php if($wtd=='editBracelet'):?>
            <center><a href="index2.php?action=braceletsAdmin&amp;wtd=deleteBracelet&amp;id=<?=$id?>">Usuń</a></center>
        <?php endif;?>
    </form>
</div>