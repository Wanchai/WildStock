
<div class="box-large box book">
    <h2 class='box-titre'>
        <?php 
            echo __('Your Stocks');
            echo $this->Html->tag('span', __('Profit', true));
            echo colorNumber($profit, false);
        ?>
    </h2>
    <div class='inside-box'>
        <table cellpadding="2" cellspacing="0" width="100%">
        	<tr>
    			<th><?php echo __('Stock'); ?></th>
    			<th><?php echo __('Qty'); ?></th>
    			<th><?php echo __('Average'); ?></th>
    			<th><?php echo __('Current'); ?></th>
    			<th><?php echo __('Profit'); ?></th>
    			<!--<th class="actions"><?php echo __('Act'); ?></th>-->
        	</tr>
        	
        	<?php foreach ($myBooks as $book): ?>
        	<tr>
        		<td>
        			<?php 
        			if($this->request->is('mobile') || IS_MOBILE){
        			    echo $this->Html->link($book['Stock']['name'], array('controller' => 'mobile', 'action' => 'stock', $book['Stock']['id'])); 
        			} else {
        			    echo $this->Html->link($book['Stock']['name'], array('controller' => 'stocks', 'action' => 'view', $book['Stock']['id'])); 
        			}
        			?>
        		</td>
        		<td class='td-align-center'><?php echo splitNumber($book['Book']['quantity']); ?>&nbsp;</td>
        		<td class='td-align-center'><?php echo $book['Book']['average_price']; ?></td>
        		<td class='td-align-center'><?php echo $book['Stock']['value'] ; ?></td>
                <td class='td-align-center'><?php echo colorNumber($book['Book']['profit']); ?></td>
        		<!--<td class="actions">
        			<?php echo $this->Html->link(__('Trade'), array('controller' => 'offers', 'action' => 'add')); ?>
        		</td>-->
        	</tr>
            <?php endforeach; ?>
        
        </table>
        
        <?php 
        if($bought != 0){
            echo '<p class=\'total\'>';
            echo __('WORTH').' '.formatMoney($worth);
            echo ' '.colorNumber(round($worth*100/$bought-100, 2));
            echo '</p>';
        }
        ?>
        
    </div>
</div>