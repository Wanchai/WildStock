<?php if(count($myBooks)): ?>
<div class="box-large box book">
    <h2 class='box-titre'>
        <?php 
            echo __('Your Stocks');
            echo '<div>'.__('Profit').' '.colorNumber($profit, false).'</div>';
        ?>
    </h2>
    <div class='inside-box'>
        <table cellpadding="2" cellspacing="0" width="100%">
        	
        	<?php foreach ($myBooks as $book): 
        	?>
        	<tr>
                <td><?php echo colorNumber($book['Book']['profit']); ?></td>
        		<td>
        		    <?php 
        		    echo $this->Html->link($book['Stock']['name'], array('controller' => 'mobile', 'action' => 'stock', $book['Stock']['id']));
        		    echo ' ('.$book['Stock']['value'].')'; 
        		    ?>
        		</td>
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
<?php endif; ?>
<?php echo $this->element('mobile_stallions'); ?>
<?php echo $this->element('mobile_mules'); ?>