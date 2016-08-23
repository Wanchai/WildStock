<!DOCTYPE html>
<html lang="en">
<?php echo $this->Facebook->html(); ?>
    <head>
        <meta charset="utf-8" />
        <title><?php echo __('Wild Stocks').$title_for_layout; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css">
	    <script src="https://code.jquery.com/jquery-1.8.2.min.js"></script>
	    <script src="https://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>

	    <?php echo $this->Html->meta('icon'); ?>
	    <?php echo $this->Html->css('mobile'); ?>

    </head>
    <body>
    
        <div data-role="page">
        
            <div class="header">
                <p class="cash-amount">
                    <?php if($this->viewVars['authUser']['name']) echo $this->viewVars['authUser']['name'].'. '.__('You have ').formatMoney($this->viewVars['authUser']['cash']); ?>
                </p>
            </div>
            
            <div data-role="content" class="content">
                <?php
                    echo $this->Session->flash();
                    echo $content_for_layout;
                ?>
            </div>
            
            <div class="footer">
                <?php echo $this->element('mobile_menu'); ?>
            </div>
            
        </div>
        
        
        <?php 
        echo $this->Facebook->init(array('frictionlessRequests' => true));
        // echo $this->element('sql_dump'); 
        echo $this->element('analytics');
        echo $this->Js->writebuffer(); 
        ?>
        
    </body>
</html>