<?php if(isset($komunikat)): ?>
    <div class="komunikat"><?=$komunikat?></div>
<?php endif; ?>
<div id="mainWrapper">
    <?php while($row=$result->fetch_row()):?>
        <div class="wrapper">
            <?php $count=count($row); $pic=substr($row[3], 0, strpos($row[3], "."));?>
            <a href="index.php?action=showDetails&amp;id=<?=$row[$count-1]?>"><img src="<?="templates/images/".$pic.".jpg"?>" class="wrapperImage"></a>
            <div class="wrapperHeader">
                <a href="index.php?action=showDetails&amp;id=<?=$row[$count-1]?>"><?=$row[0]?></a>
            </div>
            <div class="secondWrapper">
                <div>
                    <?php
                    if($row[1]==='d') echo "Damska";
                    if($row[1]==='m') echo "Męska";
                    if($row[1]==='u') echo "Unisex";
                    ?>
                </div>
                <div><b><?=$row[2]?>zł</b></div>
                <div class="basketLink"><a href="index.php?action=toBasket&amp;id=<?=$row[1]?>">DO KOSZYKA</a></div>
            </div>
        </div>
    <?php endwhile;?>
</div>
