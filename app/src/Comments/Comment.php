<?php
namespace Anax\Comments;
 
/**
 * Model for Comments.
 *
 */
class Comment extends \Anax\MVC\CDatabaseModel
{
	/**
	 * Fetch comments to answers
	 *
	 */
	public function fetchCommentstoAnswers($answerId, $commentType) {
			$this->db->select()
				 ->from($this->getSource())
				 ->where("questionAnswerId = ?")
				 ->andWhere("commentType = ?");
	 
		$this->db->execute([$answerId, $commentType]);
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}
	
}