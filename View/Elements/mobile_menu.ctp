<!--<div data-role="navbar">
    <ul>
        <li><?php echo $this->Html->link(__('Home'),array('controller'=>'mobile','action'=>'index'))?></li>
        <li><?php echo $this->Html->link(__('Stocks'),array('controller'=>'mobile','action'=>'stocks'))?></li>
        <li><?php echo $this->Html->link(__('Me'),array('controller'=>'mobile','action'=>'me'))?></li>
        <li><?php echo $this->Html->link(__('About'),array('controller'=>'mobile','action'=>'about'))?></li>
    </ul>
</div>-->

<div>
    <?php 
        echo $this->Html->link(
            $this->Html->image('elements/mobile_menu_01.png'),
            array('controller'=>'mobile','action'=>'index'),
            array('class' => 'menu-home', 'escape' => false)
            
            );  
    ?>
</div>
<div>
    <?php 
        echo $this->Html->link(
            $this->Html->image('elements/mobile_menu_02.png'),
            array('controller'=>'mobile','action'=>'stocks'),
            array('class' => 'menu-stocks', 'escape' => false)
            
            ); 
    ?>
</div>
<div>
    <?php 
        echo $this->Html->link(
            $this->Html->image('elements/mobile_menu_03.png'),
            array('controller'=>'mobile','action'=>'me'),
            array('class' => 'menu-me', 'escape' => false)
            
            ); 
    ?>
</div>
<div>
    <?php 
        echo $this->Html->link(
            $this->Html->image('elements/mobile_menu_04.png'),
            'http://www.wildstocks-game.com',
            array('class' => 'menu-about', 'escape' => false)
            
            );  
    ?>
</div>