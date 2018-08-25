<?php if(!$this) die(); ?>
<div class="pOfferts"><?=$title?></div>
<?php if($komunikat):?>
    <div class="pOfferts"><div class="komunikat"><?=$komunikat?></div></div>
<?php else:?>
    <div id="basketDetails">
        <form action="index.php?action=modifyBasket" method="post">
            <?php $sum=0; while($row=$jewellery->fetch_row()):?>
                <div>
                    <img src="<?="templates/images/image".$row[0]."_1.jpg"?>">
                </div>
                <div>
                    <?=$row[1]?>
                </div>
                <div>
                    <?=$row[2]?>zł
                </div>
                <?php 
                $value=sprintf("%01.2f", ($ile=$basket[$row[0]]->ile) * $row[2]);
                $sum += $value;
                ?>
                <a href="index.php?action=deleteBasket">Usuń</a>
                <?php if($allowModify):?>
                    <input type="number" name="<?=$basket[$row[0]]->id?>" value="<?=$ile?>">
                <?php else:
                    $ile;
                endif;?>
                <div>
                    <?=$value?>
                </div>
            <?php endwhile;?>
            <div>
                SUMA: <?php sprintf("%01.2f",$sum);?>
            </div>
            <?php if($allowModify):?>
                <div>
                    <input type="submit" value="Zapisz zmiany">
                </div>
            <?php endif;
            if($allowModify):?>
                <a href="index.php?action=checkout">Do kasy</a>
            <?php else:?>
                <a href="index.php?action=save">Złóż zamówienie</a>
            <?php endif;?>
        </form>
    </div>
<?php endif; ?>