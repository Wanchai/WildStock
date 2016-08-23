<ul class="menu">
	<li><?php echo $this->Html->link('Home', array('controller' => 'pages')); ?></li>
	<li><?php echo $this->Html->link('Sign up', array('controller' => 'users', 'action' => 'add')); ?></li>
	<li><?php echo $this->Html->link('Log in', array('controller' => 'users', 'action' => 'login')); ?></li>
</ul>