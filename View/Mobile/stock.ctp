<div class="stock-details">
    <h2 class="stock-titre"><?php echo $stock['Mobile']['name']; ?></h2>
    <p class="stock-comment"><?php echo $stock['Mobile']['comment']; ?></p>
    
    <p class="var-value">
        <span class="stock-variation"><?php echo colorNumber($stock['Mobile']['variation']); ?></span>
        <span class="stock-value"><?php echo $stock['Mobile']['value']; ?></span>
    </p>
    <?php
        if($mine != ""){
            echo "<p class='book-comment'>";
            echo __(
                "You own %s bought at %s for a profit of %s",
                "<span class='stock-book1'>".splitNumber($mine['quantity'])."</span>",
                "<span class='stock-book1'>".TAUR.$mine['average_price']."</span><br />",
                "<span class='stock-book2'>".colorNumber($mine['profit'])."</span>"
                );
            echo "</p>";
        }
    ?>
    <div data-role="collapsible">
        <h2 class="add-offer"><?php echo __('Add an offer'); ?></h2>
        <?php
            echo $this->Form->create('Offer', array('controller' => 'offers', 'action' => 'add'));
            if($mine != "") {
        ?>
            <select name="data[Offer][type]" id="type" data-role="slider">
            	<option value="1"><?php echo __('BUY'); ?></option>
            	<option value="2"><?php echo __('SELL'); ?></option>
            </select>
        <?php 
        } else {
            echo $this->Html->tag('span', __('BUY'));
            echo $this->Form->hidden('type',array('value' => '1'));
        }
            
    	echo $this->Form->input('quantity', array('label' => __('Quantity')));
    	echo $this->Form->input('price', array('label' => __('Price'), 'type' => 'text'));
    	
    	echo $this->Form->hidden('user_id', array('value' => $this->viewVars['authUser']['id']));
    	echo $this->Form->hidden('stock_id', array('value' => $stock['Mobile']['id']));
    	echo $this->Form->hidden('stock_name', array('value' => $stock['Mobile']['name']));
    	echo $this->Form->hidden('date', array('value' => date('Y-m-d H:i:s')));
    	echo $this->Form->hidden('ref', array('value' => env('REQUEST_URI')));
        
        echo $this->Form->end(__('Submit'), array('class' => 'button'));
        ?>
    </div>
    
    <!-- OFFERS -->
    
    <h2 class='box-titre'><?php echo __('Offers'); ?></h2>
    <div class='inside-offers'>
        <p><?php echo __('You want to'); ; ?></p>
        <div class="buy-offers">
            <h3><?php echo __('Buy'); ?></h3>
            <?php 
                foreach ($sell_offers as $of) {
                    $class = ($of['price'] < $stock['Mobile']['value']) ? 'of-arrow1' : 'of-arrow2' ;
                    echo $this->Html->link($of['quantity'].' at '.$of['price'], '#popupSellOffer', array(
                                'class' => $class,
                                'onclick'=> "editPopup('#popupSellOffer','".$of['id']."','".$of['quantity']."','".$of['price']."', '2')",
                                'escape' => false,
                                'data-rel' => "popup",
                                'data-position-to' => 'window'
                            ));
                }
            ?>
        </div>
        
        <div class="sell-offers">
            <h3><?php echo __('Sell'); ?></h3>
            <?php 
                foreach ($buy_offers as $of){
                    $class = ($of['price'] < $stock['Mobile']['value']) ? 'of-arrow3' : 'of-arrow4' ;
                    echo $this->Html->link($of['quantity'].' at '.$of['price'], '#popupBuyOffer', array(
                                'class' => $class,
                                'onclick'=> "editPopup('#popupBuyOffer','".$of['id']."','".$of['quantity']."','".$of['price']."', '1')",
                                'escape' => false,
                                'data-rel' => "popup",
                                'data-position-to' => 'window'
                            ));
                }
            ?>
        </div>
    </div>
        
    <h2 class='yours-titre'><?php echo __('Yours'); ?></h2>
    <div class='inside-offers'>
        <div class="buy-offers">
            <h3><?php echo __('Buying'); ?></h3>
            <?php 
                foreach ($mybuy_offers as $of){
                    $class = ($of['price'] < $stock['Mobile']['value']) ? 'of-arrow1' : 'of-arrow2' ;
                    echo "<a href='' class='$class'>".$of['quantity'].' at '.$of['price'].'</a>';
                }
            ?>
        </div>
        
        <div class="sell-offers">
            <h3><?php echo __('Selling'); ?></h3>
            <?php 
                foreach ($mysell_offers as $of){
                    $class = ($of['price'] < $stock['Mobile']['value']) ? 'of-arrow3' : 'of-arrow4' ;
                    echo "<a href='' class='$class'>".$of['quantity'].' at '.$of['price'].'</a>';
                }
            ?>
        </div>
    </div>
    
    <!-- DELETE -->
    
    <div class='offers-footer'>
    <?php 
        if($mybuy_offers || $mysell_offers){
            echo $this->Form->postLink(
                __('Delete all my offers'),
                array('controller' => 'offers', 'action' => 'delete_all_mine',
                    '?' => array('ref' => env('REQUEST_URI'), 'st_id' => $stock['Mobile']['id'] )),
                array('class' => 'delete-all button'), 
                __('Are you sure you want to delete all your offers for %s?', $stock['Mobile']['name']));
        } else {
            echo $this->Html->tag('p', __('You don\'t have any offers'), array('class' => 'no-offers'));
        }
    ?>
    </div>
</div>

<?php 
    echo $this->element('mobile_buyoffer');
    echo $this->element('mobile_selloffer');
?>

<script>
function editPopup(pp, id, qty, price, type) {
    $("span[name~='offer-qty']").html(qty);
    $("span[name~='offer-price']").html(price);
    $("input[name~='transac_qty']").attr("max", qty);
    $("input[id~='offId']").val(id);
}
</script>
