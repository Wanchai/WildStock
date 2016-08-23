<?php
if(isset($help_steps[2]) && $help_steps[2] == 0){
?>
    <div id='popup_help' class='help2'>
    
        <a href="javascript:void(0)" onclick="close_popup('popup_addoffer');" class='cross'></a>
    
        <?php echo $this->Html->image('elements/face-woman-02.png', array('alt' => 'Your host', 'class' => 'woman-face')); ?>
        <h3><?php echo __('The Ranch'); ?></h3>
        <p><?php echo __('Here you will find all listed stocks. Click on a name to get more details about the company.'); ?></p>
        <br />
        <?php 
        echo $this->Html->link(
            __('I don\'t want to see this message again!'), 
            array('controller' => 'Pages', 'action' => 'helpStep', 2, '?' => array('redir' => $_SERVER['REQUEST_URI'])),
            array('class' => 'help_steps_link')
            );
        ?>
    </div>
    <script>help('popup_help');</script>
<?php } ?>

<div class="box-large box stocks-box">
    <h2 class='box-titre'><?php echo __('Stocks'); ?></h2>
    <div class='inside-box'>
        <table cellpadding="0" cellspacing="0" width="100%">
        	<tr>
    			<th><?php echo $this->Paginator->sort('name'); ?></th>
    			<th><?php echo $this->Paginator->sort('value'); ?></th>
    			<th><?php echo $this->Paginator->sort('variation'); ?></th>
    			<th><?php echo $this->Paginator->sort('yesterday'); ?></th>
        	</tr>
        	
        	<?php foreach ($stocks as $stock): ?>
        	<tr>
        		<td><?php echo $this->Html->link($stock['Stock']['name'], array('controller' => 'stocks', 'action' => 'view', $stock['Stock']['id'])); ?>&nbsp;</td>
        		<td class="td-align-center"><?php echo h($stock['Stock']['value']); ?>&nbsp;</td>
        		<td class="td-align-center"><?php echo colorNumber($stock['Stock']['variation']); ?></td>
        		<td class="td-align-center"><?php echo h($stock['Stock']['yesterday']); ?>&nbsp;</td>
        	</tr>
            <?php endforeach; ?>
            
        </table>
    </div>
</div>

<?php

    echo $this->element('stallions');
    
    echo $this->element('mules'); 

?>