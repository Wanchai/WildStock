<?php
// pr($help_steps);
if(isset($help_steps[1]) && $help_steps[1] == 0){
?>
    <div id='popup_help' class='help'>
    
        
        
        <?php echo $this->Html->image('elements/face-woman-01.png', array('alt' => 'Your host', 'class' => 'woman-face')); ?>
        <h3><?php echo __('Welcome to Wild Stocks!'); ?></h3>
        <p><?php echo __('You want to be a cowboy trader and that\'s a good thing. This quick tour will show you around.'); ?></p>
        <br />
        <p><?php echo __('You will receive %s<b>1000</b> at the end of it.', TAUR); ?></p>
        <br />
        <p><?php echo __('This page is the <b>Dashboard</b>. It contains all the information about the current state of the market.'); ?></p>
        <br />
        <p><?php echo $this->Html->link(__('But let\'s have a look at the stocks'), array('controller' => 'Stocks', 'action' => 'index')); ?></p>
        <br/>
        <?php 
        echo $this->Html->link(
            __('I don\'t want to see this message again!'), 
            array('controller' => 'Pages', 'action' => 'helpStep', 1, '?' => array('redir' => $_SERVER['REQUEST_URI'])),
            array('class' => 'help_steps_link')
            );
        ?>
    </div>
<script>
help('popup_help');
</script>

<?php 
} 

    echo $this->element('book');
    echo $this->element('stallions');
    echo $this->element('mules'); 

?>

<div class="box-regular box news">
    <h2 class='box-titre'>
        <?php echo __('News'); ?>
        <span>
        <?php 
            //echo $this->Html->link('@WildStocks', 'https://twitter.com/WildStocks'); 
        ?>
        </span>
    </h2>
    <div class='inside-box'>
        <?php 
            foreach ($news_feed as $tweet){
                echo "<span class='text'>".$tweet['News']['text'].'</span>';
            }
        ?>
    </div>
</div>