<div class="box-large box me">
    <p class="infos">
    <?php 
        echo '<b>'.$authUser['name'].'</b><br />';
        echo formatMoney($authUser['cash']).__(' your cash').'<br />';
        echo formatMoney($authUser['yesterday_book_value']).__(' yesterday book value');
    ?>
    </p>
</div>