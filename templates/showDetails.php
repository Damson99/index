<?php if(!$this) die();?>
<div id="detailsDiv">
<?php if($komunikat):?>
    <div class="komunikat"><?=$komunikat?></div>
<?php else:?>
        <div>
            <div class="slideshow-container">
                    <?php 
                        $pics=explode(".",$row['Images']);
                        array_pop($pics);
                        $i=0;
                        while($i<count($pics)){
                            $a=$pics[$i];?>
                            <div class="mySlides fade">
                                <img src="<?="templates/images/".$a.".jpg"?>" class="pic">
                            </div>
                            <?php $i++;
                        }
                    ?>
                <div class="mySlides fade">
                    <img src="templates/images/0_0.jpg" class="pic">
                </div>
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <div>
                <?php 
                    $pics=explode(".",$row['Images']);
                    array_pop($pics);
                    $i=0;
                    while($i<count($pics)){
                        $a=$pics[$i];?>
                        <div class="list">
                            <img src="<?="templates/images/".$a.".jpg"?>" class="dot" onclick="currentSlide(<?=$i?>)">
                        </div>
                        <?php $i++;
                    }
                ?>
                <img src="templates/images/0_0.jpg" class="dot" onclick="currentSlide(<?=$i++;?>)">
            </div>
            <script src="templates/slider.js"></script>
        </div>
        <div class="rightDiv">
            <h1><?=$row['Nazwa']?></h1>
            <h2><?=$row['Cena']?> zł</h2>
            <a href="index.php?action=toBasket&amp;id=<?=$row['Id']?>" id="basketLink">DODAJ DO KOSZYKA</a>
            <a href="index.php?action=toWishList&amp;id=<?=$row['Id']?>" id="basketLink">DODAJ DO ULUBIONYCH</a>
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