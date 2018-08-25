<?php if(!isset($this)) die(); ?>
<div id="usersList">
    <table>
        <tr>
            <?php foreach($fields=$result->fetch_fields() as $field): ?>
            <th><?=$field->name?></th>
            <?php endforeach ?>
            <th>Edytuj</th>
            <th>Usuń</th>
        </tr>
        <?php while($row=$result->fetch_row()): ?>
            <tr>
                <?php foreach($row as $val): ?>
                    <td><?=$val?></td>
                <?php endforeach?>
                <td><a href="index2.php?action=usersAdmin&amp;wtd=showEditForm&amp;id=<?=$row[0]?>">Edytuj</a></td>
                <td><a href="index2.php?action=usersAdmin&amp;wtd=deleteUser&amp;id=<?=$row[0]?>">| X</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <div id="pagination">
        <?php $this->getPagination($page,$pages,'index2.php?action=usersAdmin&amp;wtd=showList','Idź do strony ');?>
    </div>
</div>