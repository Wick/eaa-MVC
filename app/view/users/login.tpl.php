<article class="article">
	<h1><?=$title?></h1>
	<a href="<?=$this->url->create('users/add')?>">Register</a>

	<form method=post>
	  <fieldset>
		  <p><label>User:<br/><input type='text' name='acronym' value=''/></label></p>
		  <p><label>Password:<br/><input type='password' name='password' value=''/></label></p>
		  <p><input type='submit' name='login' value='Login' onClick="this.form.action = '<?=$this->url->create('users/login')?>'"/></p>
		  <output><b><?=$output?></b></output>
		  <p><a href="<?=$this->url->create('users/logout/')?>">Log out</a></p>
	  </fieldset>
	</form>
 
</article>