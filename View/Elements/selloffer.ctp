
<div id="popup_selloffer" class="popup_content">

    <h2 class="addoffer-titre">
        <?php echo $this->Html->tag('span', __('Offer')); ?>
        <?php echo $this->Html->link('', 'javascript:void(0)', array(
            'onclick'=>'close_popup(\'popup_editoffer\');',
            'escape' => false
        )) ?>
    </h2>
    
    <p class="addoffer-stock">
		<?php
		    echo $this->Html->tag('span', __('To sell: '), array('style' => 'color:#EDBD2F'));
		    echo $stock['Stock']['name'].' ('.$stock['Stock']['value'].')';
		?>
	</p>
	
	<p class="qty-at-price">
	    <span name="offer-qty"></span>
	    <?php echo $this->Html->tag('span', __(' at '), array('style' => 'color:#808080')); ?>
	    <span name="offer-price"></span>
	</p>
	
	<hr size='1' width="90%" />
	
	<p class="addoffer-book">
    	<?php 
        if($mine != ""){
            echo "<span>";
            echo __(
                "You own %s bought at %s",
                "<span class='stock-book1'>".splitNumber($mine['quantity'])."</span>",
                "<span class='stock-book1'>".TAUR.$mine['average_price']."</span>"
                );
            echo "</span>";
        }
        ?>
	</p>
	
	<div class="selloffer-fields">
		<?php
		    echo $this->Form->create('Offer', array('controller' => 'offers', 'action' => 'change'));
		    
            echo '<div class="qty-price">';
            echo __('I want some').' >> ';
			echo $this->Form->input('quantity', array('min' => '1', 'name' => 'transac_qty'));
			echo '</div>';
        ?>
            
            <script type="text/javascript">displayTotal2("OfferQuantity","OfferPrice")</script>
            <p class="totalCost" id="totalCost"><b><span id="totalResult"></span></b></p>
			
        <?php
			echo $this->Form->hidden('id', array('value' => '1'));
			echo $this->Form->hidden('user_id', array('value' => $this->viewVars['authUser']['id']));
			echo $this->Form->hidden('stock_id', array('value' => $stock['Stock']['id']));
			echo $this->Form->hidden('stock_name', array('value' => $stock['Stock']['name']));
			echo $this->Form->hidden('date',array('value' => date('Y-m-d H:i:s') ));
	        echo $this->Form->hidden('ref', array('value' => env('REQUEST_URI')));
			
            echo $this->Form->end(__('I\'m buying!'), array('class' => 'button'));
            
        ?>
    </div>
</div>
