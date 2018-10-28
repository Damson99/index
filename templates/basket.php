<?php if(!$this) die(); ?>
<div class="pOfferts"><?=$title?></div>
<?php if($komunikat):?>
    <div class="pOfferts"><div class="komunikat"><?=$komunikat?></div></div>
<?php else:?>
    <?php $sum=0; while($row=$jewellery->fetch_row()):?>
        <form action="index.php?action=userUpdateForm" method="post">
            <div id="basketDetails">
                <div>
                    <a href="index.php?action=showDetails&amp;id=<?=$row[0];?>"><img src="<?="templates/images/".$row[0]."_1.jpg"?>"></a>
                </div>
                <div class="basketItem">
                    <div>
                        <a href="index.php?action=showDetails&amp;id=<?=$row[0];?>"><?=$row[1]?></a>
                    </div>
                    <?php $value=sprintf("%01.2f", ($ile=$basket[$row[0]]->ile) * $row[2]);
                    $sum += $value;
                    if(isset($_GET['action'])) $action=$_GET['action'];
                    if($action=='checkout'){
                        $disabled='disabled';
                    }else{
                        $disabled='';
                    }?>
                    <label>Ilość</label><input type="number" name="<?=$basket[$row[0]]->id?>" value="<?=$ile?>"<?=$disabled?>>
                    <div>
                        <?=$value?>zł
                    </div>
                    <?php if($action!='checkout'):?>
                        <a href="index.php?action=deleteBasket&amp;id=<?=$row[0];?>" id="deleteProduct" title="Usuń">X</a>
                    <?php endif;?>
                </div>
            </div>
    <?php endwhile;?>
        <div id="basketDetails">
            <div>
                <h3>SUMA: <?php echo $sum;?>zł</h3>
            </div>
            <?php if($action=='checkout'){
                $message=$_POST['message'];
            }else{
                $message="Wiadomość do sprzedawcy. Proszę podać obwód nadgarstka zmierzony na styk zgodnie ze zdjęciem i kolor wybranej bransoletki.";
            }?>
            <textarea name="message" placeholder="<?=$message?>"<?=$disabled?>></textarea>
            <div></div>
            <?php if($action!='checkout'):?>
            <input type="submit" value="Do kasy">
            <?php endif;?>
        </div>
    </form>
<?php endif; ?>