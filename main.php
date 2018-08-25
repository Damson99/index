<?php if(!isset($sefora)) die();?>
<div class="pOfferts"><i>Witaj w pracowni artystycznej Sefory</i></div>
<div>
    <div class="pOfferts">Nowości</div>
    <div class="offerts">
        <?php $sefora->getNews();?>
    </div>
</div>
<div class="pOfferts">
    <div class="pDiv">
        <a href="index.php?action=bransoletFor&brn=women">Biżuteria damska</a>
        <a href="index.php?action=bransoletFor&brn=unisex">Biżuteria unisex</a>
        <a href="index.php?action=bransoletFor&brn=men">Biżuteria męska</a>
        <a href="index.php?action=bransoletFor&brn=all">Wszystkie</a>
    </div>
</div>