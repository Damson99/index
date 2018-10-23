<?php if(!$this) die();?>
    <?php while($row=$result->fetch_row()):?>
            <form>
        <div id="basketDetails">
                <div>
                    <a href="index.php?action=showDetails&amp;id=<?=$bransoletId;?>"><img src="<?="templates/images/".$row[0]."_1.jpg"?>"></a>
                </div>
                <div class="basketItem">
                    <div>
                        <a href="index.php?action=showDetails&amp;id=<?=$bransoletId;?>"><?=$row[1]?></a>
                    </div>
                    <?php
                        if($row[2]==='d') echo "Damska";
                        if($row[2]==='m') echo "Męska";
                        if($row[2]==='u') echo "Unisex";
                    ?>
                    <b><?=$row[3]?>zł</b>
                    <div><a href="index.php?action=toBasket&amp;id=<?=$row[0]?>" id="basketLink">DO KOSZYKA</a></div>
                    <a href="index.php?action=deleteWishList&amp;id=<?=$row[0]?>" id="deleteProduct" title="Usuń">X</a>
            </div>
        </div>
            </form>
    <?php endwhile;?>