<img class='sitelogo' src='<?=$this->url->asset("img/logo.png")?>' alt='Site logo'/>
<span class='sitetitle'><?=$siteTitle?></span>

<div class='right user'>

		<?php if(isset($_SESSION['userId'])) :?> 
        
            <a href="<?=$this->url->create('users/profile/' . $_SESSION['userId']); ?>">Profile</a> | 
            <a href="<?=$this->url->create('users/logout/')?>">Log out</a>        |        
        
		<?php else :?>    
               
            <a href="<?=$this->url->create('users/add')?>">Register</a> |  
            <a href="<?=$this->url->create('users/login')?>">Login</a>
            
 		<?php endif; ?>
        
</div> 