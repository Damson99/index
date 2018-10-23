<?php if(!isset($this)) die();?>
<center>
    <div id="usersList">
        <table>
            <tr>
                <?php foreach($fields=$result->fetch_fields() as $field):?>
                    <th><?=$field->name?></th>
                <?php endforeach;?>
            </tr>
            <?php while($row=$result->fetch_row()):?>
                <tr>
                    <?php foreach($row as $val):?>
                        <td><?=$val?></td>
                    <?php endforeach;?>
                        <?php $pic=substr($row[1], 0, strpos($row[1], "."));?>
                        <img src="<?="templates/images/".$pic.".jpg"?>" class="wrapperImage">
                </tr>
            <?php endwhile;?>
        </table>
    </div>
</center>