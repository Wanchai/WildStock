<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    echo $this->Facebook->html();
?>
<head prefix="og:http://ogp.me/ns# fb:http://ogp.me/ns/fb# wildstocks:http://ogp.me/ns/fb/wildstocks#">
    <?php echo $this->Html->charset(); ?>
    
    <meta property="fb:app_id" content="283595065092791" /> 
    <meta property="og:type"   content="wildstocks:stock" />
    <meta property="og:url"    content="http://ws-deploy.herokuapp.com/stocks/fb_feed/<?php echo $this->viewVars['stock']['Stock']['id'] ?>" /> 
    <meta property="og:title"  content="<?php echo $this->viewVars['stock']['Stock']['name'] ?>" /> 
    <meta property="og:image"  content="http://www.wildstocks-game.com/img/logo_medium.png" /> 
	<title>
		<?php echo $this->viewVars['stock']['Stock']['name']; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css('style');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>

</head>
<body>
    <div id="container">
		<div id="header">
            <?php echo $this->element('menuloggedin'); ?>
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>

	<?php echo $this->Facebook->init(); ?>

</body>
</html>
