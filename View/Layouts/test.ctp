<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php echo $this->Facebook->html(); ?>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __('Wild Stocks'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
// 		echo $this->Html->css('debug');

        // echo $this->Html->script('ws');
	?>
</head>
<body>


			<?php echo $this->fetch('content'); ?>

<fb:like href="https://www.facebook.com/WildStocks/" layout="standard" action="like" show_faces="true" share="true"></fb:like>

    <?php 
        echo $this->Facebook->init(array('frictionlessRequests' => true));
        // echo $this->element('sql_dump'); 
        // echo $this->Js->writeBuffer(); 
    ?>
</body>
    
</html>
