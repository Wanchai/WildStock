

<ul id="menu" class="menu">

	<li class="home">
	    <?php 
	    echo $this->Html->link(
	        $this->Html->tag('span','&nbsp', array('class' => 'img')).$this->Html->tag('span',__('Dashboard',true), array('class' => 'text')), 
	        array('controller' => 'pages', 'action' => 'home'), 
	        array('escape' => false)
	        );
	    ?>
	</li>
	
	<li class="stocks">
	    <?php 
	    echo $this->Html->link(
	        $this->Html->tag('span','&nbsp', array('class' => 'img')).$this->Html->tag('span',__('Stocks',true), array('class' => 'text')), 
	        array('controller' => 'stocks', 'action' => 'index'), 
	        array('escape' => false)
	        );
	    ?>
	</li>
	
	<li class="profile">
	    <?php 
	    echo $this->Html->link(
	        $this->Html->tag('span','&nbsp', array('class' => 'img')).$this->Html->tag('span',__('Me',true), array('class' => 'text')), 
	        array('controller' => 'users', 'action' => 'me'), 
	        array('escape' => false)
	        );
	    ?>
	</li>

	<!-- <li class="forum">
	    <?php 
	    echo $this->Html->link(
	        $this->Html->tag('span','&nbsp', array('class' => 'img')).$this->Html->tag('span',__('Forum',true), array('class' => 'text')), 
	        'http://wildstocks-game.com/forums/', 
	        array('target' => '_blank', 'escape' => false)
	        );
	    ?>
	</li> -->
	
</ul>
