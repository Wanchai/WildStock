<div class="box-large box stocks-box">
    <h2 class='box-titre'><?php echo __('Stocks'); ?></h2>
    <div class='inside-box'>
    <?php 
        echo __('Sort by: ').$this->Paginator->sort('variation').' | '.$this->Paginator->sort('name').' | '.$this->Paginator->sort('value');
    ?>
        <table cellpadding="0" cellspacing="0" width="100%">
        	<?php foreach ($stocks as $stock): ?>
        	<tr>
        		<td class="td-align-center"><?php echo colorNumber($stock['Mobile']['variation']); ?></td>
        		<td>
        		<?php 
        		echo $this->Html->link($stock['Mobile']['name'], array('controller' => 'mobile', 'action' => 'stock', $stock['Mobile']['id'])); 
        		echo ' ('.$stock['Mobile']['value'].')';
        		?>
        		</td>
        	</tr>
            <?php endforeach; ?>
            
        </table>
    </div>
</div>
