<h1><?=$title?></h1>

<ul class="tags-list-all">
	<?php foreach ($tags as $tag) : ?>		
		<li> <a href="<?=$this->url->create('tags/id/' . $tag->id)?>"><?=$tag->tag?></a></li>		
	<?php endforeach; ?>
</ul>