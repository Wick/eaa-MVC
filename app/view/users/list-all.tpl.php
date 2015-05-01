<h1><?=$title?></h1>
 
<table class="user-list">

	<tr>
		<th><?='Acronym'?></th>
		<th><?='Member since'?></th>
	</tr> 

	<?php foreach ($users as $user) : ?>
		<tr>
			<td><a href="<?=$this->url->create('users/id/' . $user->id) ?>"><?=$user->acronym?></a></td>
			<td><?=$user->active?></td>
		</tr> 
	<?php endforeach; ?>

</table>
 