 
 <?php
 
 if($facebook_user){
        $this->redirect(array('controller' => 'mobile', 'action' => 'index'));
     
 }else{
    //  echo 'You are not logged in';
     echo $this->Facebook->login(array('perms' => 'email,publish_actions'));
 }
 
/*if(env('SERVER_NAME') == LOCAL_SERVER){
    // DEV
	echo 'MOBILE!';
	if($facebook_user){
		$this->redirect(array('controller' => 'mobile', 'action' => 'index'));
	    
	}else{
        echo 'You are not logged in';
        echo $this->Facebook->login(array('perms' => 'email,publish_actions'));
	}

} else if (env('SERVER_NAME') == TEST_SERVER) {?>

   <script>
       var oauth_url = 'https://www.facebook.com/dialog/oauth/';
       oauth_url += '?client_id=283595065092791';
       oauth_url += '&redirect_uri=https://<?php echo TEST_SERVER; ?>/mobile/';
       oauth_url += '&scope=email,publish_actions';
       oauth_url += '&display=popup';
       
       window.top.location = oauth_url;
   </script>
   
<?php
    
} else { ?>
    
    <script>
        var oauth_url = 'https://www.facebook.com/dialog/oauth/';
        oauth_url += '?client_id=283595065092791';
        oauth_url += '&redirect_uri=https://<?php echo PROD_SERVER; ?>/mobile/';
        oauth_url += '&scope=email,publish_actions';
        oauth_url += '&display=popup';
        
        window.top.location = oauth_url;
    </script>
	
<?php
    
}*/
     
?>
 
