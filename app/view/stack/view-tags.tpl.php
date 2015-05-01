<h1><?=$tag->tag?></h1>

<p>Questions with this tag: </p>

<div class ="tagquestion">
	<ul>
		<?php if(isset($tagsQuestions)) : ?>
		    <?php foreach ($tagsQuestions as $tagQuestion) : ?>				
			    <li><a href="<?=$this->url->create('questions/id/' . $tagQuestion->id)?>"><?=$tagQuestion->questionTitle?></a> Created: <?=$tagQuestion->created?></li>				
		    <?php endforeach; ?>
		<?php endif; ?>
	</ul>
</div>