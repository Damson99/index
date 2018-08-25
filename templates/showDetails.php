<?php if(!$this) die();?>
<div id="detailsDiv">
<?php if($komunikat):?>
    <div class="komunikat"><?=$komunikat?></div>
<?php else:?>
        <div>
            <img src="templates/images/0_0.jpg">
            <?php for($i=1;$i<3;$i++):
                $num=0;
                $pic=substr($row['Images'], 1, strpos($row['Images'], "."));?>
                <img src="<?="templates/images/".$pic.".jpg"?>">
            <?php endfor;?>
        </div>
        <div>
            <img src="<?="templates/images/".$pic.".jpg"?>" class="pic">
        </div>
        <div class="rightDiv">
            <h1><?=$row['Nazwa']?></h1>
            <h2><?=$row['Cena']?> zł</h2>
            <a href="index.php?action=toBasket&id<?=$row['Id']?>">DODAJ DO KOSZYKA</a>
            <a href="index.php?action=toFavorite&id<?=$row['Id']?>">DODAJ DO ULUBIONYCH</a>
            <p>Wysyłka krajowa pocztą: 8,00 zł</p>
            <p>Wysyłka krajowa kurierem: 16,00 zł</p>
            <p>Wysyłka zagraniczna (dotyczy krajów UE): 18,00 zł</p>
        </div>
    </div>
    <div id="secondDetails">
        <p>OPIS</p>
        <article>
            <?=$row['Opis']?>
        </article>
    </div>
    <div id="secondDetails">
        <article>
            <b>Kolor:</b> <?=$row['Kolor']?>
        </article>
    </div>
    <div id="secondDetails">
        <article>
            <b>Bransoletka</b> 
            <?php 
            if($row['Sex']==='d') echo "Damska";
            if($row['Sex']==='m') echo "Męska";
            if($row['Sex']==='u') echo "Unisex"; 
            ?>
        </article>
    </div><br><br><br>
    <div>
        <p class="pOfferts">Zobacz również nowości</p>
        <div class="offerts">
            <?php
                $this->getNews();
            ?>
        </div>
    </div>
<?php endif;?>