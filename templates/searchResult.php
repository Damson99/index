<?php if(isset($komunikat)): ?>
    <div class="komunikat"><?=$komunikat?></div>
<?php endif; ?>
<div id="mainWrapper">
    <?php while($row=$result->fetch_row()):?>
        <div class="wrapper">
            <?php $pic=substr($row[4], 0, strpos($row[4], "."));?>
            <a href="index.php?action=showDetails&amp;id=<?=$row[0]?>"><img src="<?="templates/images/".$pic.".jpg"?>" class="wrapperImage"></a>
            <div class="wrapperHeader">
                <a href="index.php?action=showDetails&amp;id=<?=$row[0]?>"><?=$row[1]?></a>
            </div>
            <div class="secondWrapper">
                <div>
                    <?php
                    if($row[2]==='d') echo "Damska";
                    if($row[2]==='m') echo "Męska";
                    if($row[2]==='u') echo "Unisex";
                    ?>
                </div>
                <div><b><?=$row[3]?>zł</b></div>
                <a id="none" href="index.php?action=toWishList&amp;id=<?=$row[0]?>"><div class="heart"></div></a>
                <div><a href="index.php?action=toBasket&amp;id=<?=$row[0]?>">DO KOSZYKA</a></div>
            </div>
        </div>
    <?php endwhile;?>
</div>