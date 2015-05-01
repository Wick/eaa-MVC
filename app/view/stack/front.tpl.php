<div class="front">
<div id="frontquestions">
	<h3>Latest Questions</h3>
	<?php foreach ($latestQuestions as $question) : ?>
		<ul>
			<li><a href="<?=$this->url->create('questions/id/' . $question->id)?>"><?=$question->questionTitle?></a></li>
			
		</ul> 
	<?php endforeach; ?>
	
</div>

<div id="fronttags">
	<h3>Most used tags</h3>
	
	<?php foreach ($mostUsedTags as $tag) : ?>
		<ul>
			<li><a href="<?=$this->url->create('tags/id/' . $tag->id)?>"><?=$tag->tagName?></a></li>
		</ul> 
	<?php endforeach; ?>
</div>

<div id="frontusers">
	<h3>Most active members</h3>
	<?php foreach ($mostActiveUsers as $user) : ?>
		<ul>
			<li><a href="<?=$this->url->create('users/id/' . $user->id)?>"><?=$user->acronym?></a></li>
		</ul> 
	<?php endforeach; ?>
</div>
</div>