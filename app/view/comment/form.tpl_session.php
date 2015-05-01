<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create('' . $page)?>">
        
        <fieldset>
        <legend>Leave a comment</legend>
        <p><label>Comment:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Name:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Homepage:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Email:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
            <input type='submit' name='doCreate' value='Comment' onClick="this.form.action = '<?=$this->url->create('comment/add/' . $page)?>'"/>
            <input type='reset' value='Reset'/>
            <input type='submit' name='doDeleteAll' value='Delete all' onClick="this.form.action = '<?=$this->url->create('comment/delete-all/' . $this->request->getRoute())?>'"/>
        </p>
        <output><?=$output?></output>
        </fieldset>
    </form>
</div>
