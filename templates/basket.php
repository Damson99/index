<?php if(!$this) die(); ?>
<div class="pOfferts"><?=$title?></div>
<?php if($komunikat):?>
    <div class="pOfferts"><div class="komunikat"><?=$komunikat?></div></div>
<?php else:?>
    <?php $sum=0; while($row=$jewellery->fetch_row()):?>
        <!--<form action="index.php?action=userAdressForm" method="post">-->
            <div id="basketDetails">
                <div>
                    <a href="index.php?action=showDetails&amp;id=<?=$row[0];?>" target="_blank"><img src="<?="templates/images/".$row[0]."_1.jpg"?>"></a>
                </div>
                <div class="basketItem">
                    <div>
                        <a href="index.php?action=showDetails&amp;id=<?=$row[0];?>" target="_blank"><?=$row[1]?></a>
                    </div>
                    <?php $value=sprintf("%01.2f", ($ile=$basket[$row[0]]->ile) * $row[2]);
                    $sum += $value;
                    if(isset($_GET['action'])) $action=$_GET['action'];
                    if($action=='checkout'){/**/
                        $disabled='disabled';
                    }else{
                        $disabled='';
                    }?>
                    <label>Ilość</label><input type="number" min="1" name="<?=$basket[$row[0]]->id?>" value="<?=$ile?>"<?=$disabled?>style="border:2px solid green;height:20px;">
                    <div>
                        <?=$value?>zł za sztukę
                    </div>
                    <a href="index.php?action=deleteBasket&amp;id=<?=$row[0];?>" id="deleteProduct" title="Usuń">X</a>
                </div>
            </div>
    <?php endwhile;?>
        <div id="basketDetails">
            <div>
                <h3>SUMA: <?php echo $sum;?>zł</h3>
            </div>
            <?php $message="Wiadomość do sprzedawcy. Proszę podać obwód nadgarstka zmierzony na styk zgodnie ze zdjęciem i kolor wybranej bransoletki.";?>
            <textarea name="message" placeholder="<?=$message?>"<?=$disabled?>></textarea>
            <div></div>
            <input type="submit" value="Do kasy" id="scroll">
        </div>
    <!--</form>-->
<ul id="subMenuf">
    <li><?php $this->showAdressForm();?></li>
</ul>
<?php endif; ?>