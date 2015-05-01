<?php
namespace Anax\Answers;
 
/**
 * Model for Answers.
 *
 */
class Answer extends \Anax\MVC\CDatabaseModel
{
	
	/**
	 * Fetch answers
	 *
	 */
	public function fetchAnswers($questionId) {
			$this->db->select()
				 ->from($this->getSource())
				 ->where("questionId = ?");
	 
		$this->db->execute([$questionId]);
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}
	
	
	/**
	 * Fetch answer with ID
	 *
	 * @return this
	 */
	public function fetchAnswer($id)
	{
		$this->db->select()
				 ->from($this->getSource())
				 ->where("id = ?");
	 
		$this->db->execute([$id]);
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}
}