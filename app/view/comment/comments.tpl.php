<hr>

<h2>Comments</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
<div class='comment-img'><img src='<?='http://www.gravatar.com/avatar/' . md5(strtolower(trim($comment['mail']))) . '.jpg?s=80'; ?>' alt='Avatar'/></div> 

<div class="head"><span class="comment-name"><?=$comment['name']?></span> <span class="comment-mail"><?=$comment['mail']?></span><span class='comment-homepage'>| <?=$comment['web']?></span></div> 
<p class="comment-date"><?=$comment['timestamp']?></p> 



<p class='comment-content'><?=$comment['content']?></p> 

<form method='post' class='comment-control'> 
    <input type='hidden' name="redirect" value="<?=$this->url->create('' . $this->request->getRoute())?>">
    <input type='hidden' name="key" value="<?=$key ?>"> 
    <input type='submit' name='doEdit' value='Edit Post' onClick="this.form.action = '<?=$this->url->create('comment/edit/' . $comment['id'])?>'"/>
    <input type='submit' name='doDelete' value='Delete Post' onClick="this.form.action = '<?=$this->url->create('comment/delete/' . $comment['id'])?>'" /> 
</form> 
<hr>
<?php endforeach; ?>
</div>
<?php endif; ?>