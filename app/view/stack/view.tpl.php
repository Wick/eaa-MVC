<div id="question">
	<div>
		<h1><?=$question->questionTitle?></h1>
		<p class="qname"><?=$user->acronym?> <small class="smalldate"><?=$question->created?></small></p>

		<p><?=$this->textFilter->doFilter( $question->question, 'shortcode, markdown');?></p>
	
		<?php if(isset($tags)) : ?>
			<p>Tags:
			<?php foreach ($tags as $tag) : ?>
				<a href=" <?=$this->url->create('tags/id/' . $tag->id)?> "><?=$tag->tag?></a>
			<?php endforeach; ?>
			</p>
		<?php endif; ?>		
        
        <p><a href="<?=$this->url->create('questions/addCommenttoQuestion/' . $question->id)?>">Comment</a> or <a href="<?=$this->url->create('questions/addAnswer/' . $question->id)?>">Answer question</a></p>
	</div>
	
	<div class="comments">
			<?php $allComments = $comments->fetchCommentstoAnswers($question->id, 'question'); ?>

			<?php foreach ($allComments as $comment) : ?>				
				<div class="comment">
					<p><?=$this->textFilter->doFilter( $comment->commentText, 'shortcode, markdown');?> - <?=$comment->userAcronym?> <?=$comment->created?></p>
				</div>			
			<?php endforeach; ?>
    </div>
</div>


<div id="answers">
	<h3><?= count($answers) . " answer/s"?></h3>	

	<?php if(isset($answers)) : ?>
		<?php foreach ($answers as $answer) : ?>
			<div class="answer">
				<p class="qname"><?=$answer->userAcronym?> <small class="smalldate"><?=$answer->created?></small></p> 
				
				<?=$this->textFilter->doFilter( $answer->answer, 'shortcode, markdown');?>

				<p><a href="<?=$this->url->create('questions/addCommenttoAnswer/' . $answer->id . '/' . $question->id)?>">Comment answer</a></p>
				
				<div class="comments">
						<?php $allComments = $comments->fetchCommentstoAnswers($answer->id, 'answer');
						foreach ($allComments as $comment) : ?>
							
							<div class="comment">
								<p><?=$this->textFilter->doFilter( $comment->commentText, 'shortcode, markdown');?> - <?=$comment->userAcronym?> <small class="smalldate"><?=$comment->created?></small></p>
							</div>
						<?php endforeach; ?>					
				</div>	
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
	<p><a href="<?=$this->url->create('questions/addAnswer/' . $question->id)?>">Answer question</a></p>
</div>


