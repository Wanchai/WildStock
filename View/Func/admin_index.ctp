<div>

<?php

    //echo date("F j, Y, g:i a", 1355610139);
?>
<ul>
<li>
<?php
    echo $this->Html->link('/!\ Change stock value', array('controller' => 'func', 'action' => 'change'));
?>
</li>
<li>
<?php
    echo $this->Html->link('/!\ Reset default stock value', array('controller' => 'func', 'action' => 'reset_stock_value'));
?>
</li>
<li>
<?php    
    echo $this->Html->link('Create BIGCORP offers', array('controller' => 'func', 'action' => 'create_offers'));
?>
</li>
<li>
<?php
    echo $this->Html->link('CRON Delete Old Offers (30 days old)', array('controller' => 'func', 'action' => 'delete_old_offers'));
?>
</li>
<li>
<?php
    echo $this->Html->link('CRON Calculate Book Value', array('controller' => 'func', 'action' => 'book_calcul'));
?>
</li>
<li>
<?php    
    echo $this->Html->link('CRON Store stock value', array('controller' => 'func', 'action' => 'store'));
?>
</li>
<li>
<?php    
    // echo $this->Html->link('Reset my Friend List', array('controller' => 'func', 'action' => 'index', 'reset_friendslist'));
?>
</li>
<li>
<?php    
    echo $this->Html->link('New Friend List', array('controller' => 'func', 'action' => 'index', 'reset_friendslist'));
?>
</li>
</ul>
</div>

<br />
<?php echo 'app non user :'.count(json_decode($app_non_user, true)); ?>
<br />
<?php echo 'invited user :'.count($app_invited_user); ?>
<br />

<a href="#" onclick="javascript:sendInviteToAll(); return false;">Invite All Friends</a>

<?php 
    // pr(json_decode($app_non_user, true));
    $all_users = implode(",", json_decode($app_non_user, true));
?>
<script type="text/javascript">
    // INVITE FRIENDS
    function sendInviteToAll() {
        FB.ui({method: 'apprequests',
            to: '<?php echo $all_users; ?>',
            title: 'Wild Stocks Invitation',
            message: '<?php echo __('Come and trade with me!'); ?>',
        }, sendInviteToAllCallback);
    }
   
    function sendInviteToAllCallback(response) {
      console.log(response);
    }
   
</script>