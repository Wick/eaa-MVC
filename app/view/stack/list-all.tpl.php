<h1><?=$title?></h1>
 
<table class="question-list">

	<?php foreach ($questions as $question) : ?>
		<tr>
			<td><a href="<?=$this->url->create('questions/id/' . $question->id)?>"><?=$question->questionTitle?></a></td>
			<td>Created: <?=$question->created?></td>
		</tr> 
	<?php endforeach; ?>

</table>
 