<?php
if($this->request->is('mobile') && env('SERVER_NAME') == PROD_SERVER) {
?>

    <div class="login">
    <?php echo $this->Session->flash('auth'); ?>
    <script>
        var oauth_url = 'https://www.facebook.com/dialog/oauth/';
        oauth_url += '?client_id=283595065092791';
        oauth_url += '&redirect_uri=https://ws-deploy.herokuapp.com/mobile/';
        oauth_url += '&scope=email,publish_actions';
        oauth_url += '&display=popup';
        
        window.top.location = oauth_url;
    </script>
    </div>
     
<?php
} else if(env('SERVER_NAME') == PROD_SERVER){
?>
    
    <div class="login">
    <?php echo $this->Session->flash('auth'); ?>
    <script>
        var oauth_url = 'https://www.facebook.com/dialog/oauth/';
        oauth_url += '?client_id=283595065092791';
        oauth_url += '&redirect_uri=https://apps.facebook.com/wildstocks/';
        oauth_url += '&scope=email,publish_actions';
        oauth_url += '&display=popup';
        
        window.top.location = oauth_url;
    </script>
    </div>
    
<?php
} else if (env('SERVER_NAME') == LOCAL_SERVER) {
    
    echo '<div style="background:white;padding:15px;width:200px">';
    echo 'You are not logged in';
    echo $this->Facebook->login(array('perms' => 'email,publish_actions'));
    
    echo '<br><br>';
    echo $this->Html->link('Go Home', array('controller' => 'pages', 'action' => 'home'), array('class' => 'button'));
    echo '</div>';

} else if ($this->request->is('mobile') && env('SERVER_NAME') == TEST_SERVER){
?>
    
        <div class="login">
        <?php echo $this->Session->flash('auth'); ?>
        <script>
            var oauth_url = 'https://www.facebook.com/dialog/oauth/';
            oauth_url += '?client_id=283595065092791';
            oauth_url += '&redirect_uri=https://ws-experiment.herokuapp.com/mobile/';
            oauth_url += '&scope=email,publish_actions';
            oauth_url += '&display=popup';
            
            window.top.location = oauth_url;
        </script>
        </div>
         
<?php
} else if(env('SERVER_NAME') == TEST_SERVER){

    echo '<div style="background:white;padding:15px;width:200px">';
    echo $this->Facebook->login(array('perms' => 'email,publish_actions'));
    
    echo '<br><br>';
    echo 'Once you are logged in, click on this button:';
    echo '<br><br>';
    echo $this->Html->link('Go Home', array('controller' => 'pages', 'action' => 'home'), array('class' => 'button'));
    echo '</div>';
?>    
    
    
    <!--<div class="login">
    <?php echo $this->Session->flash('auth'); ?>
    <script>
        var oauth_url = 'https://www.facebook.com/dialog/oauth/';
        oauth_url += '?client_id=283595065092791';
        oauth_url += '&redirect_uri=https://apps.facebook.com/1485221221691506';
        oauth_url += '&scope=email,publish_actions';
        oauth_url += '&display=popup';
        
        window.top.location = oauth_url;
    </script>
    </div>-->
    
    
    
<?php
}
?>