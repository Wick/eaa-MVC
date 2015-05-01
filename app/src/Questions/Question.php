<?php
namespace Anax\Questions;
 
/**
 * Model for Questions.
 *
 */
class Question extends \Anax\MVC\CDatabaseModel
{

	/**
	 * Get last id
	 *
	 */	
	public function getLastId() {
		return $this->db->lastInsertId();
	}

	/**
	 * Get tags
	 *
	 */	
	public function getTags($questionId) {
		$sql = "SELECT * FROM stack_questionTag as questionTag, stack_tag as tag WHERE questionTag.questionId = '{$questionId}' and questionTag.tagName = tag.tag;"; 
		$this->db->execute($sql);
		return $this->db->fetchAll();
	}
	
		
	/**
	 * Get question and answer
	 *
	 */
	public function getQuestionandAnswers($questionId) {
		$sql = "SELECT * FROM stack_question as question, stack_answer as answer WHERE question.id = {$questionId} and answer.questionId = {$questionId};"; 
		$this->db->execute($sql);
		return $this->db->fetchAll();
	}
		
	
	/**
	 * Get latest questions (3)
	 *
	 */
	public function findLatestQuestions() {
		$sql = "SELECT * FROM stack_question ORDER BY id DESC LIMIT 3;"; 
		$this->db->execute($sql);
		return $this->db->fetchAll();
	}
}