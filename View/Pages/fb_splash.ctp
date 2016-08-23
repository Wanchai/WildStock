<?php 
if(unserialize($authUser['help_steps'])){
?>

    <div id='help'>
    <p>"Welcome!"</p>
    </div>
    
<?php 
}else{
    echo "dommage";
}
debug($authUser);
?>

<div class="top-left">
    <h2><?php echo __('Stallions'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
			<th><?php echo _('Stock'); ?></th>
			<th><?php echo _('Value'); ?></th>
			<th><?php echo _('Variation'); ?></th>
	    </tr>
        <?php
    	foreach ($best as $stock): ?>
    
    	<tr>
    		<td><?php echo $this->Html->link($stock['Stock']['name'], array('controller' => 'stocks', 'action' => 'view', $stock['Stock']['id'])); ?>&nbsp;</td>
    		<td><?php echo h($stock['Stock']['value']); ?>&nbsp;</td>
    		<td><?php
    			$addSign = ($stock['Stock']['variation'] > 0 ) ? '▲ +' : '▼ ';
    			$change = ($stock['Stock']['variation']) == 0 ? '--' : $addSign.''.$stock['Stock']['variation'].'%' ;
    
    			echo '<span style=color:'. (($stock['Stock']['variation']>=0) ? '#0CB918' : 'red') . '>'.h($change).'</span>' ;
    		?>&nbsp;</td>
    	</tr>
        <?php endforeach; ?>
        
    </table>
    <h2><?php echo __('Mules'); ?></h2>
    <table cellpadding="0" cellspacing="0">
	    <tr>
			<th><?php echo _('Stock'); ?></th>
			<th><?php echo _('Value'); ?></th>
			<th><?php echo _('Variation'); ?></th>
	    </tr>
        <?php
    	foreach ($worst as $stock): ?>
    
    	<tr>
    		<td><?php echo $this->Html->link($stock['Stock']['name'], array('controller' => 'stocks', 'action' => 'view', $stock['Stock']['id'])); ?>&nbsp;</td>
    		<td><?php echo h($stock['Stock']['value']); ?>&nbsp;</td>
    		<td><?php
    			$addSign = ($stock['Stock']['variation'] > 0 ) ? '▲ +' : '▼ ';
    			$change = ($stock['Stock']['variation']) == 0 ? '--' : $addSign.''.$stock['Stock']['variation'].'%' ;
    
    			echo '<span style=color:'. (($stock['Stock']['variation']>=0) ? '#0CB918' : 'red') . '>'.h($change).'</span>' ;
    		?>&nbsp;</td>
    	</tr>
        <?php endforeach; ?>
        
    </table>
</div>
<div class="twitter">

	<a class="twitter-timeline" data-chrome="noheader noborders" data-dnt="true" href="https://twitter.com/WildStocks" width="360" data-widget-id="299486617796755456">&nbsp</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</div>