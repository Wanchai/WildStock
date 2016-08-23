<?php

if (!$myBooks){
    if(isset($help_steps[3]) && $help_steps[3] == 0){
    ?>
        <div id='popup_help' class='help2'>
        
            <a href="javascript:void(0)" onclick="close_popup('popup_addoffer');" class='cross'></a>
            <p><?php echo __('All details about a specific stock can be found here.'); ?></p>
            <p><?php echo __('Now you are going to buy your first stock! Check the "Offers" box under the "Buy" label.'); ?></p>
            <br />
            <p><?php echo __('Red offers are under the actual stock price which is what you are usually looking for so <b>Click</b> on it! If there is no red offer, <b>Click</b> on a blue one.'); ?></p>
            <br />
            <p><?php echo __('Now, enter the quantity and buy.'); ?></p>
            <br />
            <?php 
            echo $this->Html->link(
                __('I don\'t want to see this message again!'), 
                array('controller' => 'Pages', 'action' => 'helpStep', 3, '?' => array('redir' => $_SERVER['REQUEST_URI'])),
                array('class' => 'help_steps_link')
                );
            ?>
        </div>
    <?php } 
} else if(!$mysell_offers){
    if (isset($help_steps[4]) && $help_steps[4] == 0) {
        ?>
            <div id='popup_help' class='help2'>
            
                <a href="javascript:void(0)" onclick="close_popup('popup_addoffer');" class='cross'></a>
                <h3><?php echo __('Sell'); ?></h3>
                <p><?php echo __('Now that you have some stocks in your portfolio, post an offer to sell them.'); ?></p>
                <br />
                <p><?php echo __('Click on the <b>BUY/SELL</b> button.'); ?></p>
                <p><?php echo __('You can only sell stocks that you own, so be sure to be on the stock page that you own and want to sell.'); ?></p>
                <br />
                <p><?php echo __('On the pop-up, select "<b>Sell</b>", set the "<b>Quantity</b>" and the "<b>Price</b>".'); ?></p>
                <br />
                <?php 
                echo $this->Html->link(
                    __('I don\'t want to see this message again!'), 
                    array('controller' => 'Pages', 'action' => 'helpStep', 4, '?' => array('redir' => $_SERVER['REQUEST_URI'])),
                    array('class' => 'help_steps_link')
                    );
                ?>
            </div>        
        <?php 
    }
} elseif (isset($help_steps[5]) && $help_steps[5] == 0) {
    ?>
        <div id='popup_help' class='help2'>
        
            <a href="javascript:void(0)" onclick="close_popup('popup_addoffer');" class='cross'></a>
            <?php 
            //echo $this->Html->image('elements/face-woman-01.png', array('alt' => 'Your host', 'class' => 'woman-face'));
            ?>
            <h3><?php echo __('Well Done!'); ?></h3>
            <p><?php echo __('It seems that you have bought some stocks and have sales under way. You are now trading among the beasts. Don\'t forget: "Buy Low, Sell High"!'); ?></p>
            <br />
            <p><?php echo __('So, will you be a bear, a wolf, a panda?'); ?></p>
            <br />
            <?php 
            echo $this->Html->link(
                __('Click here to get your reward!'), 
                array('controller' => 'Pages', 'action' => 'helpStep', 5, '?' => array('redir' => $_SERVER['REQUEST_URI']))
                ); 
            ?>
        </div>        
    <?php 
}
?>
<script>
help('popup_help');
</script>

<div class="stock-details">
    <h2 class="stock-titre"><?php echo $stock['Stock']['name']; ?></h2>
    <span class="stock-comment"><?php echo $stock['Stock']['comment']; ?></span>
    
    <p class="var-value">
        <span class="stock-variation"><?php echo colorNumber($stock['Stock']['variation']); ?></span>
        <span class="stock-value"><?php echo $stock['Stock']['value']; ?></span>
    </p>

    <a class="button" href="javascript:void(0)" onclick="popup('popup_addoffer')"><?php echo __('BUY/SELL'); ?></a>
    <br />
    
    <?php 
    if($mine != ""){
        echo "<span class='book-comment'>";
        echo __(
            "You own %s bought at %s for a profit of %s",
            "<span class='stock-book1'>".splitNumber($mine['quantity'])."</span>",
            "<span class='stock-book1'>".TAUR.$mine['average_price']."</span><br />",
            "<span class='stock-book2'>".colorNumber($mine['profit'])."</span>"
            );
        echo "</span>";
    }
    ?>
    
</div>

<div class="box-regular box offers-box">
    <h2 class='box-titre'>
        <?php echo __('Offers'); ?>
        <span><?php echo __('You want to'); ; ?></span>
    </h2>
    <div class='inside-offers'>
    
        <div class="buy-offers">
            <p><?php echo __('Buy'); ?></p>
            <?php 
                foreach ($sell_offers as $of) {
                    $class = ($of['price'] < $stock['Stock']['value']) ? 'of-arrow1' : 'of-arrow2' ;
                    echo $this->Html->link($of['quantity'].' at '.$of['price'], 'javascript:void(0)', array(
                            'class' => $class,
                            'onclick'=> "editOffer('popup_selloffer','".$of['id']."','".$of['quantity']."','".$of['price']."')",
                            'escape' => false
                        ));
                }
            ?>
        </div>
        
        <div class="sell-offers">
            <p><?php echo __('Sell'); ?></p>
            <?php 
                foreach ($buy_offers as $of){
                    $class = ($of['price'] < $stock['Stock']['value']) ? 'of-arrow3' : 'of-arrow4' ;
                    echo $this->Html->link($of['quantity'].' at '.$of['price'], 'javascript:void(0)', array(
                                'class' => $class,
                                'onclick'=> "editOffer('popup_buyoffer','".$of['id']."','".$of['quantity']."','".$of['price']."')",
                                'escape' => false
                            ));
                }
            ?>
        </div>
    </div>
        
    <div class='inside-offers'>
        <h2 class='yours-titre'><?php echo __('Yours'); ?></h2>
        <div class="buy-offers">
            <p><?php echo __('Buying'); ?></p>
            <?php 
                foreach ($mybuy_offers as $of){
                    $class = ($of['price'] < $stock['Stock']['value']) ? 'of-arrow1' : 'of-arrow2' ;
                    echo "<a href='' class='$class'>".$of['quantity'].' at '.$of['price'].'</a>';
                }
            ?>
        </div>
        
        <div class="sell-offers">
            <p><?php echo __('Selling'); ?></p>
            <?php 
                foreach ($mysell_offers as $of){
                    $class = ($of['price'] < $stock['Stock']['value']) ? 'of-arrow3' : 'of-arrow4' ;
                    echo "<a href='' class='$class'>".$of['quantity'].' at '.$of['price'].'</a>';
                }
            ?>
        </div>
    </div>
    
    <div class='offers-footer'>
    <?php 
        echo $this->Form->postLink(
            __('Delete all my offers'),
            array('controller' => 'offers', 'action' => 'delete_all_mine',
                '?' => array('ref' => env('REQUEST_URI'), 'st_id' => $stock['Stock']['id'] )),
            array('class' => 'delete-all button'), 
            __('Are you sure you want to delete all your offers for %s?', $stock['Stock']['name']));
    ?>
    </div>
    
</div>

<?php
    echo $this->element('addoffer');
    echo $this->element('buyoffer');
    echo $this->element('selloffer');
?>

<script>
function editOffer(pp, id, qty, price) {
    console.log(this);
    document.getElementsByName('data[Offer][id]')[0].value = id;
    document.getElementsByName('data[Offer][id]')[1].value = id;
    document.getElementsByName('transac_qty')[0].max = qty;
    document.getElementsByName('transac_qty')[1].max = qty;
    document.getElementsByName("offer-qty")[0].innerHTML = qty;
    document.getElementsByName("offer-qty")[1].innerHTML = qty;
    document.getElementsByName("offer-price")[0].innerHTML = price;
    document.getElementsByName("offer-price")[1].innerHTML = price;
    popup(pp);
}
</script>