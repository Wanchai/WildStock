<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php echo $this->Facebook->html(); ?>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __('Wild Stocks'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('style2');
		echo $this->Html->css('menu');
		echo $this->Html->css('debug');

		echo $this->fetch('meta');
        echo $this->Html->script('ws');
        echo $this->Html->script('jquery');
	?>
</head>
<body>
	<div id="container">
	
        <?php echo $this->element('menuloggedin'); ?>
        
        <!-- <div id="market" class="market">
            <h2>Team</h2>
            <p>
                <?php 
                    echo $this->Html->image("btns/boutons_03.png", array(
                        "alt" => "Send Invites", 
                        "url" => "javascript:sendInviteRequest(); return false;", 
                        "class" => "sendInvitesBtn")
                    );
                ?>
            </p>
		</div>-->
        
		<div id="header" class="header">
			<?php echo $this->Html->image("elements/el_83.png", array("alt" => "Logo Wild Stocks", "class" => "logo")); ?>
		    <p class="cash-amount"><?php echo __('You have ').formatMoney($authUser['cash']); ?></p>
		</div>

        <?php echo $this->Session->flash(); ?>

		<div id="content" class="content">
            <div id="popup_overlay" class="popup_overlay" onclick="close_popup()"></div>
            <?php echo $this->fetch('content'); ?>
		</div>
        
		<div id="footer">
		    
		    <br />
		    <br />
		    <br />
		    <br />
		</div>        

	</div>

    <script type="text/javascript">
        // INVITE FRIENDS
        function sendInviteRequest() {
        <?php if(isset($app_non_user)): ?>
            FB.ui({method: 'apprequests',
                message: '<?php echo __('Come and trade with me!'); ?>',
                filters: [{name: 'Suggested', user_ids: <?php echo $app_non_user; ?>}]
            }, inviteCallback);
        <?php endif; ?>
        }
        function inviteCallback(response) {
            if(response != null){
                var to = "?tofb_ids=";
                for (i in response.to) {
                   to += response.to[i]+',';
                }
                to = to.slice(0,-1);
                file('fbrequests/invite/'+response.request+'/'+to);        
            }
        }
    </script>
    
    <?php 
        echo $this->Facebook->init(array('frictionlessRequests' => true));
        echo $this->element('sql_dump'); 

        echo $this->element('analytics');
    ?>
    <script>
        window.onload = function() {
            FB.Canvas.setAutoGrow(91);
        }
    </script>
</body>
</html>
