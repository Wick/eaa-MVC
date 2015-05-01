<?php
namespace Anax\Users;
 
/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{

    /**
     *  Login and add one to activity
     *
     */
	public function login($acronym, $password)
	{
			$user = $this->checkLogin($acronym);

			if(password_verify($password, $user->password)){
				
				$sql = "UPDATE stack_user SET timesLogedIn = timesLogedIn + 1 WHERE acronym = '{$acronym}';"; 
				$this->db->execute($sql);
				
				$this->session->set('userId', $user->id);
				$this->response->redirect($this->url->create('users/profile/' . ($user->id)));
			}
			else{
				$output = 'Authentication failed';
				return $output;
			}
	}
	
	
    /**
     * Log out
     *
     */	
	public function logout(){
		$this->session->destroy();	
		$this->response->redirect($this->url->create(''));
	}
	
	
	/**
	 * Check if username and password is correct.
	 *
	 * @return this
	 */
	public function checkLogin($acronym)
	{
		$this->db->select()
				 ->from($this->getSource())
				 ->where("acronym = ?");
	 
		$this->db->execute([$acronym]);
		
		return $this->db->fetchInto($this);
	}
	
	
	/**
     * Logged in?
     *
     */
	public function checkAuthentication()
	{
		$acronym = isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
		
		if ($acronym)
		{
			return 'You are loged in';
		}
		else {
			return 'You are not loged in';
		}
	}
	
	
	/**
	 * Get users questions
	 */
	public function getUsersQuestions($userId) {
		$this->db->select()
				 ->from("question")
				 ->where("userId = ?");

		$this->db->execute([$userId]);
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();		
	}
	
	
	/**
	 * Most active users (3)
	 *
	 */
	public function mostActiveUsers()
	{
		$sql = "SELECT * FROM stack_user ORDER BY timesLogedIn DESC LIMIT 3;"; 
		$this->db->execute($sql);
		return $this->db->fetchAll();
	}
	
}