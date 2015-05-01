<h1><?=$user->acronym?></h1>

<div>
	<img class="comment_img" src="http://www.gravatar.com/avatar/<?=md5($user->email);?>.jpg?s=125"  />

	<ul>
		<li>Username: <?=$user->acronym?></li>
		<li>Member since: <?=$user->created?></li>
		
	</ul>

</div>

<div id="userQuestions">
	<h3>Questions:</h3>
	
	<table class="userquestions">
		<?php foreach ($userQuestions as $userQuestion) : ?>
			<tr>
				<td><a href="<?=$this->url->create('questions/id/' . $userQuestion->id)?>"><?=$userQuestion->questionTitle?></a></td>
				<td>Created: <?=$userQuestion->created?></td>
				
				<?php $questionId = $userQuestion->id;?>
				<?php $allAnswers = $questions->getQuestionandAnswers($questionId); ?>
				<?php $numberOfAnswers = count($allAnswers);?>
				<td><?= $numberOfAnswers?> answers</td>
			</tr> 
		<?php endforeach; ?>
	</table>
</div>



	