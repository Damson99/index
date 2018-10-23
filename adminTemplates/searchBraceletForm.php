<?php if(!isset($this)) die();?>
<div id="loginFormWrapper">
    <img src="imageLog.jpg" class="imageLog"><br>
    <h1>Szukaj bransoletki</h1>
    <form action="index2.php" method="get">
        <input type="hidden" name="action" value="braceletsAdmin">
        <input type="hidden" name="wtd" value="searchBracelet">
        <p>Id</p>
        <input type="number" name="id" placeholder="Id">
        <p>Nazwa</p>
        <input type="text" name="nazwa" placeholder="Nazwa">
        <input type="submit" value="Szukaj">
    </form>
</div>