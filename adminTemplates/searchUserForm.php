<?php if(!isset($this)) die();?>
<div id="loginFormWrapper">
    <img src="img/imageLog.jpg" class="imageLog"><br>
    <h1>Szukaj użytkownika</h1>
    <form action="index2.php" method="get">
        <input type="hidden" name="action" value="usersAdmin">
        <input type="hidden" name="wtd" value="searchUser">
        <p>Id</p>
        <input type="number" name="id" placeholder="Id">
        <p>Imię</p>
        <input type="text" name="imie" placeholder="Imię">
        <input type="submit" value="Szukaj">
    </form>
</div>