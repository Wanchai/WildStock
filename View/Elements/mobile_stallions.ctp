<div class="box-regular box stallions">
    <h2 class='box-titre'><?php echo __('Stallions'); ?></h2>
    <div class='inside-box'>
        <table cellpadding="0" cellspacing="0" width="100%">

            <?php foreach ($best as $stock): ?>
        	<tr>
        		<td><?php echo colorNumber($stock['Mobile']['variation']) ; ?></td>
        		<td><?php 
        		
        		    echo $this->Html->link($stock['Mobile']['name'], array('controller' => 'mobile', 'action' => 'stock', $stock['Mobile']['id'])); 
        		    echo ' ('.$stock['Mobile']['value'].')';
        		    
        		?></td>
        	</tr>
            <?php endforeach; ?>
    
        </table>
    </div>
</div>