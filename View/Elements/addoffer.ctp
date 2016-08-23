
<div id="popup_addoffer" class="popup_content">

    <h2 class="addoffer-titre">
        <?php echo $this->Html->tag('span', __('Add Offer')); ?>
        <?php echo $this->Html->link('', 'javascript:void(0)', array(
            'onclick'=>'close_popup(\'popup_addoffer\');',
            'escape' => false
        )) ?>
    </h2>
    <p class="addoffer-stock">
		<?php
		    echo $stock['Stock']['name'].' ('.$stock['Stock']['value'].')';
		    
// 			$radio_data;
// 			foreach($this->viewVars['stocks'] as $stc){
// 				$radio_data[$stc['Stock']['id']] = $stc['Stock']['name'].' ('.$stc['Stock']['value'].')';
// 			}
//             echo __('Pick a stock:');
// 			echo $this->Form->select('stock_id', $radio_data, array('legend' => __('Pick a stock')));
		?>
	</p>
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
	<div class="addoffer-fields">
		<?php
		    echo $this->Form->create('Offer', array('controller' => 'offers', 'action' => 'add'));
		     
            if($mine != "") {
                echo $this->Form->radio('type', array('1' => __('Buy'), '2' => __('Sell')));
            } else {
                echo $this->Form->hidden('type',array('value' => '1'));
                echo '<div class="placeholder">'.__('Buy').'</div>';
            }
            
            echo '<div class="qty-price">';
			echo $this->Form->input('quantity');
			echo $this->Form->input( 'price', array( 'type' => 'text' ));
			echo '</div>';
        ?>
            
            <script type="text/javascript">displayTotal2("OfferQuantity","OfferPrice")</script>
            <p class="totalCost" id="totalCost"><b><span id="totalResult">&nbsp</span></b></p>
			
        <?php
			echo $this->Form->hidden('user_id', array('value' => $this->viewVars['authUser']['id']));
			echo $this->Form->hidden('stock_id', array('value' => $stock['Stock']['id']));
			echo $this->Form->hidden('stock_name', array('value' => $stock['Stock']['name']));
			echo $this->Form->hidden('date',array('value' => date('Y-m-d H:i:s') ));
	        echo $this->Form->hidden('ref', array('value' => env('REQUEST_URI')));
			
            echo $this->Form->end(__('Post Me!'), array('class' => 'button'));
            
        ?>
    </div>
</div>

<script>
    document.getElementById('OfferType1').onclick = function(){
        document.getElementById('totalCost').style.visibility = 'visible';
    }
    document.getElementById('OfferType2').onclick = function(){
        document.getElementById('totalCost').style.visibility = 'hidden';
    }
</script>