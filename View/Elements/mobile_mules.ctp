<div class="box-regular box mules">
    <h2 class='box-titre'><?php echo __('Mules'); ?></h2>
    <div class='inside-box'>
        <table cellpadding="0" cellspacing="0" width="100%">

            <?php foreach ($worst as $stock): ?>
        	<tr>
        		<td><?php echo colorNumber($stock['Mobile']['variation']) ; ?></td>
        		<td><?php 
        		
        		    echo $this->Html->link($stock['Mobile']['name'], array('controller' => 'stocks', 'action' => 'view', $stock['Mobile']['id'])); 
        		    echo ' ('.$stock['Mobile']['value'].')';
        		    
        		?></td>
        	</tr>
            <?php endforeach; ?>
    
        </table>
    </div>
</div>