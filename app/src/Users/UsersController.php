<?php
namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
		\Anax\MVC\TRedirectHelpers;

	
	public $users;
	private $messages;
	public $question;
 
		
	/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function initialize()
	{
		$this->users = new \Anax\Users\User();
		$this->users->setDI($this->di);
		
		$this->questions = new \Anax\Questions\Question();
		$this->questions->setDI($this->di);

	}
	
	
	/**
	 * Get users.
	 *
	 * @return void
	 */
	public function listAction()
	{
		$all = $this->users->findAll();
	 
		$this->theme->setTitle("Users");
		$this->views->add('users/list-all', [
			'users' => $all,
			'title' => "Users",
		]);
	}
	
	
	/**
	 * Get user with id.
	 *
	 * @param int $id of user to display
	 *
	 * @return void
	 */
	public function idAction($id = null)
	{
		$user = $this->users->find($id);
		
		$usersQuestions = $this->users->getUsersQuestions($id);
		
		$this->theme->setTitle("Show user with ID");
		$this->views->add('users/view', [
			'user' => $user,
			'userQuestions' => $usersQuestions,
			'questions' => $this->questions
		]);
	}
	
	
	
	/**
	 * User profile
	 *
	 * @param int $id of user to display
	 *
	 * @return void
	 */
	public function profileAction($id = null)
	{
		$userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
		
		if($userId){
			$user = $this->users->find($id);
			
			$usersQuestions = $this->users->getUsersQuestions($id);
			
			
			$this->theme->setTitle("Profile");
			$this->views->add('users/profile', [
				'user' => $user,
				'userQuestions' => $usersQuestions,
				'questions' => $this->questions
			]);
			
		} else {
			$this->di->theme->setTitle("Profile");
			$this->di->views->add('default/page', [
				'content' => '<p>You have to log in <br/> <a href="' . $this->url->create('users/login') . '">Login</a></p>'
			]);
		}
	}
	
	
	
	/**
	 * Add user.
	 *
	 * @param string $acronym of user to add.
	 *
	 * @return void
	 */
	public function addAction($acronym = null)
	{ 	 				
		$form = new \Anax\HTMLForm\CFormUser($this->users);
		$form->setDI($this->di);
		$form->check();
		
		$this->di->theme->setTitle("Register");
		$this->di->views->add('default/page', [
			'content' => $form->getHTML(),
			'title' => "Register",
		]);	
	}
	
	
	/**
	 * Login user.
	 *
	 */
	public function loginAction()
	{ 	 
		$output = null;
		$output = $this->users->checkAuthentication();
		
		$isPosted = $this->request->getPost('login');
		if (isset($isPosted))
		{
			$acronym = $this->request->getPost('acronym');
			$password = $this->request->getPost('password');
			
			$output = $this->users->login($acronym, $password);
		}
		
		$this->di->theme->setTitle("Login");
		$this->di->views->add('users/login', [
			'output'  => $output,
			'title' => "Login",
		]);
	}
	
	
	/**
	 * Logout user.
	 *
	 */
	public function logoutAction()
	{ 	 
		$output = null;
		
		$isPosted = $this->request->getPost('logout');
		if (isset($isPosted))
		{			
			$output = $this->users->logout();
		}
		
		$this->di->theme->setTitle("Log out");
		$this->di->views->add('users/logout', [
			'output'  => $output,
			'title' => "Log out",
		]);
	}
	
	/**
	 * Update user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function updateAction($id = null)
	{
		if (!isset($id)) {
			die("Missing id");
		}
		
		$user = $this->users->find($id);
		
		$form = new \Anax\HTMLForm\CFormUser($this->users, $user);
		$form->setDI($this->di);
		$form->check();
		
		$this->di->theme->setTitle("Update profile");
		$this->di->views->add('default/page', [
			'title' => "Update profile with id: " . $id,
			'content' => $form->getHTML()
		]);
	}

}