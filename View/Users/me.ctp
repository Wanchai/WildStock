
<?php echo $this->element('book'); ?>

<div class="box-large box me">
    <p class="infos">
    <?php 
        echo $this->Html->image($pic,array('align' => 'left'));
    
        echo '<b>'.$authUser['name'].'</b><br />';
        echo __('Your cash: ').formatMoney($authUser['cash']).'<br />';
        echo __('Yesterday book value: ').formatMoney($authUser['yesterday_book_value']).'<br /><br />';
        echo __('Like our page to get %s ', TAUR.LIKE_BONUS);
        echo $this->Facebook->like(array(
            'href' => 'https://www.facebook.com/WildStocks',
            'colorscheme' => 'dark',
            'layout' => 'standard',
            'show_faces' => true
            ));
    ?>
    </p>
</div>

<div class="box-regular box transactions">
    <h2 class='box-titre'>
        <?php echo __('Your transactions'); ?>
    </h2>
    <div class='inside-box'>
    
        <p class="tr-legend">
            <span class="bought"><?php echo $this->Html->image('elements/arrow_03.png').' '.__('Bought'); ?></span>
            <span class="sold"><?php echo __('Sold').' '.$this->Html->image('elements/arrow_05.png'); ?></span>
        </p>
    
        <?php 
            foreach ($transactions as $tr){
                if($tr['buyer_id'] == $authUser['id']){
                    echo '<a class="tr-arrow1">';
                    echo '<p class="tr-date1"><b>' .date('d/m', strtotime($tr['date'])).'</b></p>';
                    echo '<p class="tr-infos1"><b>'.$tr['stock_name']. '</b><br />';
                    echo '<span class="span-white">'.$tr['quantity'].'</span>';
                    echo '<span class="span-grey">'.__(' at ').'</span>';
                    echo '<span class="span-white">'.$tr['value'].'</span></p>';
                } else {
                    echo '<a class="tr-arrow2">';
                    echo '<p class="tr-infos2"><b>'.$tr['stock_name']. '</b><br />';
                    echo '<span class="span-white">'.$tr['quantity'].'</span>';
                    echo '<span class="span-grey">'.__(' at ').'</span>';
                    echo '<span class="span-white">'.$tr['value'].'</span></p>';
                    echo '<p class="tr-date2"><b>' .date('d/m', strtotime($tr['date'])).'</b></p>';
                }
                echo '</a>';
            }
        ?>
    </div>
</div>

<div class="box-regular box offers">
    <h2 class='box-titre'>
        <?php echo __('Your offers'); ?>
    </h2>
    <div class='inside-box'>
    
        <p class="tr-legend">
            <span class="bought"><?php echo $this->Html->image('elements/arrow_01.png').' '.__('Buying'); ?></span>
            <span class="sold"><?php echo __('Selling').' '.$this->Html->image('elements/arrow_04.png'); ?></span>
        </p>
    
        <?php 
            foreach ($user['Offer'] as $tr){
                if($tr['type'] === 1){
                    echo '<a class="tr-arrow1">';
                } else {
                    echo '<a class="tr-arrow2">';
                }
                
                echo '<span class="tr-infos1"><b>'.$tr['stock_name']. '</b></span>';
                echo '<span class="tr-infos2"><span class="span-white">'.$tr['quantity'].'';
                echo '<span class="span-black">'.__(' at ').'</span>';
                echo ''.$tr['price'].'</span></span>';
                echo '</a>';
            }
        ?>
    </div>
    <div class='offers-footer'>
        <?php 
            echo $this->Form->postLink(
                __('Delete all my offers'),
                array('controller' => 'offers', 'action' => 'delete_all_mine',
                    '?' => array('ref' => env('REQUEST_URI'), 'st_id' => 'all' )),
                array('class' => 'delete-all button'), 
                __('Are you sure you want to delete all your offers? THIS IS IRREVERSIBLE!'));
        ?>
    </div>
</div>
