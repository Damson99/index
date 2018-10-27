<?php if(!isset($sefora)) die();?>
<div class="pOffertsWel"><i>Witaj w pracowni Sefory</i></div>
<div class="pOfferts">
    <div class="pDiv">
    <nav id="mainNav">
        <ul>
            <li><a href="index.php?action=braceletFor&amp;brn=women">Biżuteria damska</a>
                <ul id="subMenu">
                    <a href="index.php?action=braceletFor&amp;brn=women&jewellery=bransoletki">&#10095; Bransoletki</a>
                    <a href="index.php?action=braceletFor&amp;brn=women&jewellery=kolczyki">&#10095; Kolczyki</a>
                    <a href="index.php?action=braceletFor&amp;brn=women&jewellery=naszyjniki">&#10095; Naszyjniki</a>
                </ul>
            </li>
            <li><a href="index.php?action=braceletFor&amp;brn=unisex">Biżuteria unisex</a>
                <ul id="subMenu">
                    <a href="index.php?action=braceletFor&amp;brn=unisex&jewellery=bransoletki">&#10095; Bransoletki</a>
                    <a href="index.php?action=braceletFor&amp;brn=unisex&jewellery=kolczyki">&#10095; Kolczyki</a>
                    <a href="index.php?action=braceletFor&amp;brn=unisex&jewellery=naszyjniki">&#10095; Naszyjniki</a>
                </ul>
            </li>
            <li><a href="index.php?action=braceletFor&amp;brn=men">Biżuteria męska</a>
                <ul id="subMenu">
                    <a href="index.php?action=braceletFor&amp;brn=men&jewellery=bransoletki">&#10095; Bransoletki</a>
                    <a href="index.php?action=braceletFor&amp;brn=men&jewellery=naszyjniki">&#10095; Naszyjniki</a>
                </ul>
            </li>
            <li><a href="index.php?action=braceletFor&amp;brn=boho">Bransoletki BOHO</a>
                <ul id="subMenu">
                    <a href="index.php?action=braceletFor&amp;brn=boho">&#10095; Bransoletki BOHO</a>
                </ul>
            </li>
            <li><a href="index.php?action=braceletFor&amp;brn=breloki">Breloki</a>
                <ul id="subMenu">
                    <a href="index.php?action=braceletFor&amp;brn=breloki">&#10095; Breloki</a>
                </ul>
            </li>
        </ul>
    </nav>
    </div>
</div>
<?php $sefora->braceletFor();?>
<div id="couple">
    <a href="index.php?action=couple&amp;brn=Infinity">
        <br>
        <p>Bransoletki dla par</p>
        <p>INFINITY</p>
        <img src="img/infinity.jpg">
    </a>
    <a href="index.php?action=couple&amp;brn=NeverGiveUp">
        <br>
        <p>Bransoletki dla par</p>
        <p>NEVER GIVE UP</p>
        <img src="img/nevergiveup.jpg">
    </a>
    <a href="index.php?action=couple&amp;brn=Inne">
        <br>
        <p>Bransoletki dla par</p>
        <p>INNE</p>
        <img src="img/inne.jpg">
    </a>
</div>
<?php $sefora->couple();?>
<hr>
<div class="pOfferts">Nowości</div>
    <div id="mainWrapper">
        <div class="slideshow-container">
            <div class="mySlides fade">
               <?=$sefora->getNews(0,4)?>
            </div>
            <div class="mySlides fade">
               <?=$sefora->getNews(4,4)?>
            </div>
            <div class="mySlides fade">
               <?=$sefora->getNews(8,4)?>
            </div>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="nextMainWrapper" onclick="plusSlides(1)">&#10095;</a>
        </div>
    </div>  
<div>
    <span class="dot" onclick="currentSlide(<?=$i++;?>)"></span>
</div>
<script src="templates/slider.js"></script>