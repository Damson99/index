<?php if(!isset($this)) die();?>
<center>
    <div id="usersList">
        <table>
            <tr>
                <th>Id zamówienia</th>
                <th>Status</th>
                <th>Data zakupu</th>
            </tr>
            <?php while($row=$result->fetch_row()):?>
                <tr>
                    <td>
                        <a href="index2.php?action=braceletsAdmin&wtd=orderDetails&amp;idDetails=<?=$row[0];?>"><?=$row[0];?></a>
                    </td>
                    <td>   
                        <input type="checkbox" value="<?=$row[1]?>" <?php if($row[1]==='1') echo "checked disabled";?>>
                        <a href="index2.php?action=braceletsAdmin&wtd=updateOrders&amp;idOrder=<?=$row[0]?>"><input type="submit" <?php if($row[1]==='1') echo "disabled";?>></a>
                    </td>
                    <td>
                        <?=$row[2]?>
                    </td>
                </tr>
            <?php endwhile;?>
        </table>
    </div>
    <div id="pagination">
        <?=$this->getPagination($page,$pages,'index2.php?action=braceletsAdmin&amp;wtd=showOrders','Idź do strony ');?>
    </div>
</center>