<?php
namespace Anax\Tags;
 
/**
 * Model for Tags.
 *
 */
class Tag extends \Anax\MVC\CDatabaseModel
{
	
	/**
	 * Save tags
	 *
	 */
	public function saveTag($tag, $maxQuestionId) {
		
		$result = $this->findTag($tag);
		
		// if not exist
		if(!$result) {
			$this->insertNewTag($tag);
			$this->insertQuestionTag($tag, $maxQuestionId);

		// if exists
		} else {
			$this->insertQuestionTag($tag, $maxQuestionId);
		}
	}
	
	
	/**
	 * Add tag
	 *
	 */
	public function insertNewTag($tag) {
		$sql = "INSERT INTO stack_tag (tag) values ('{$tag}')"; 
		return $this->db->execute($sql); 
	}
	
	
	/**
	 * Bind question and tag
	 *
	 */
	public function insertQuestionTag($tag, $maxQuestionId) {
		
		$sql = "INSERT INTO stack_questionTag (tagName, questionId) values ('{$tag}', '{$maxQuestionId}')"; 
		return $this->db->execute($sql);
	}
	
	
	/**
	 * Find latest question id
	 *
	 */
	public function lastQuestion() {
	
		$sql = "SELECT MAX(id) FROM stack_question"; 
		return $this->db->fetchAll();
	}
	
	
	/**
	 * Find tag
	 *
	 */
	public function findTag($id)
	{
		$this->db->select("tag")
				 ->from($this->getSource())
				 ->where("tag = ?");

		$this->db->execute([$id]);
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}
	
	
	/**
	 * Get questions to tag
	 *
	 */
	public function getQuestonsWithTag($tagName) {
		
		$sql = "SELECT * FROM stack_questionTag as questionTag, stack_question as question WHERE questionTag.tagName = '{$tagName}' and questionTag.questionId = question.id;"; 
		$this->db->execute($sql);
		return $this->db->fetchAll();
		
	}
	

	/**
	 * Get most used tags
	 *
	 */
	public function fetchMostUsedTags() 
	{	
		$sql = "SELECT *, count(tagName) as tagName_count
				FROM stack_tag as tag , stack_questionTag as questionTag
				WHERE questionTag.tagName = tag.tag
				group by questionTag.tagName
				order by tagName_count desc limit 3
				;"; 
		$this->db->execute($sql);
		return $this->db->fetchAll();
	}
	
}