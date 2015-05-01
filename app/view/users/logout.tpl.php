<article class="article">
	<h1><?=$title?></h1>
	<p>Log out?</p>
    
	<form method=post>
	  <fieldset>
		  <p><input type='submit' name='logout' value='Log out' onClick="this.form.action = '<?=$this->url->create('users/logout')?>'"/></p>
		  <output><b><?=$output?></b></output>
	  </fieldset>
	</form>
    
</article>