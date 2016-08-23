<ul class="menuadmin">
	<li><?php echo $this->Html->link('Stocks', array('controller' => 'stocks', 'action' => 'index')); ?></li>
	<li><?php echo $this->Html->link('Books', array('controller' => 'books', 'action' => 'index')); ?></li>
	<!--<li>|</li>
	<li><?php echo $this->Html->link('Categories', array('controller' => 'categories', 'action' => 'index')); ?></li>
	<li><?php echo $this->Html->link('Indices', array('controller' => 'indices', 'action' => 'index')); ?></li>
	-->
	<li>|</li>
	<li><?php echo $this->Html->link('Offers', array('controller' => 'offers', 'action' => 'index')); ?></li>
	<li><?php echo $this->Html->link('Transactions', array('controller' => 'transactions', 'action' => 'index')); ?></li>
	<li><?php echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index')); ?></li>
	<li><?php echo $this->Html->link('FBRequests', array('controller' => 'fbrequests', 'action' => 'index')); ?></li>
	<li><?php echo $this->Html->link('News', array('controller' => 'news', 'action' => 'index')); ?></li>
	<li>|</li>
	<li><?php echo $this->Html->link('Functions', array('controller' => 'func', 'action' => 'index')); ?></li>
</ul>