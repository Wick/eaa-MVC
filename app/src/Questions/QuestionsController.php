<?php
namespace Anax\Questions;
 
/**
 * Controller for questions.
 *
 */
class QuestionsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
		\Anax\MVC\TRedirectHelpers;
		
	
	public $questions;
	public $user;
	public $answers;
	public $comments;
	public $tags;
	
	
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
		
		$this->answers = new \Anax\Answers\Answer();
		$this->answers->setDI($this->di);
				
		$this->comments = new \Anax\Comments\Comment();
		$this->comments->setDI($this->di);
		
		$this->tags = new \Anax\Tags\Tag();
		$this->tags->setDI($this->di);
		

	}
	
	
	/**
	 * Actions for the first page
	 * - latest questions
	 * - most popular tags
	 * - most active users
	 */
	public function firstpageAction() 
	{
		$latestQuestions = $this->questions->findLatestQuestions();
		$mostUsedTags = $this->tags->fetchMostUsedTags(); 
		$mostActiveUsers = $this->users->mostActiveUsers();
		
		$this->views->add('stack/front', [
			'latestQuestions' => $latestQuestions,
			'mostUsedTags' => $mostUsedTags,
			'mostActiveUsers' => $mostActiveUsers
		]);
	}
	
	
	/**
	 * List questions.
	 *
	 * @return void
	 */
	public function listAction()
	{
		$all = $this->questions->findAll();
		
		$this->theme->setTitle("Questions");
		$this->views->add('stack/list-all', [
			'questions' => $all,
			'title' => "Questions",
		]);
	}
	
	
	/**
	 * List question.
	 *
	 * @param int $id of question to display
	 *
	 * @return void
	 */
	public function idAction($questionId = null)
	{
		$question = $this->questions->find($questionId);
		
		$userId = $question->userId;
		$questionUser = $this->users->find($userId);
		
		$allAnswers = $this->answers->fetchAnswers($questionId);
		
		$tags = $this->questions->getTags($questionId);
		
		$this->theme->setTitle("Show question");
		$this->views->add('stack/view', [
			'question' => $question,
			'user' => $questionUser,
			'answers' => $allAnswers,
			'comments' => $this->comments,
			'tags' => $tags
		]);
	}
	
	
	/**
	 * Add question
	 *
	 */
	public function addAction() 
	{
		$userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
		
		if($userId){
			
			$form = new \Anax\HTMLForm\CFormQuestion($this->questions, $userId, $this->tags);
			$form->setDI($this->di);
			$form->check();
			
			$this->di->theme->setTitle("Ask a question");
			$this->di->views->add('default/page', [
				'title' => "Ask a question",
				'content' => $form->getHTML()
			]);
		} else {
			$this->di->theme->setTitle("Ask a question");
			$this->di->views->add('default/page', [
				'title' => "Ask a question",
				'content' => '<p>You have to log in first. <br/> <a href="' . $this->url->create('users/login') . '">Log in</a></p>'
			]);
		}
	} 
	
	
	/**
	 * Answer a question
	 *
	 */
	public function addAnswerAction($questionId)
	{
		$userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
		$question = $this->questions->find($questionId);
		
		$user = $this->users->find($userId);
		$acronym = $user->acronym;

				
		if($userId){
			$form = new \Anax\HTMLForm\CFormAnswer($this->answers, $userId, $question, $acronym);
			$form->setDI($this->di);
			$form->check();
			
			$this->di->theme->setTitle("Answer question");
			$this->di->views->add('default/page', [
				'title' => "Answer question: " . $question->questionTitle,
				'content' => $form->getHTML()
			]);
		} else {
			$this->di->theme->setTitle("Answer question");
			$this->di->views->add('default/page', [
				'title' => "Answer question: " . $question->questionTitle,
				'content' => '<p>You have to log in first. <br/> <a href="' . $this->url->create('users/login') . '">Log in</a></p>'
			]);
		}
	}
	
	
	/**
	 * Add a comment to a question
	 *
	 */
	public function addCommenttoQuestionAction($questionId)
	{
		$userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
		$question = $this->questions->find($questionId);
		
		$user = $this->users->find($userId);
		$acronym = isset($user->acronym) ? $user->acronym : null;
		
		$type = "question";
				
		if($userId){
			$form = new \Anax\HTMLForm\CFormComment($this->comments, $userId, $questionId, $acronym, $type, $question);
			$form->setDI($this->di);
			$form->check();
			
			$this->di->theme->setTitle("Comment");
			$this->di->views->add('default/page', [
				'title' => "Comment",
				'content' => $form->getHTML()
			]);
		} else {
			$this->di->theme->setTitle("Comment");
			$this->di->views->add('default/page', [
				'title' => "Comment",
				'content' => '<p>You have to log in first. <br/> <a href="' . $this->url->create('users/login') . '">Login</a></p>'
			]);
		}
	}
	
	
	/**
	 * Add a comment to an answer
	 *
	 */
	public function addCommenttoAnswerAction($answerId, $questionId)
	{
		$userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
		$question = $this->questions->find($questionId);
		
		$user = $this->users->find($userId);
		$acronym = isset($user->acronym) ? $user->acronym : null;
		
		$type = "answer";
				
		if($userId){
			$form = new \Anax\HTMLForm\CFormComment($this->comments, $userId, $answerId, $acronym, $type, $question);
			$form->setDI($this->di);
			$form->check();
			
			$this->di->theme->setTitle("Comment");
			$this->di->views->add('default/page', [
				'title' => "Comment",
				'content' => $form->getHTML()
			]);
		} else {
			$this->di->theme->setTitle("Comment");
			$this->di->views->add('default/page', [
				'title' => "Comment",
				'content' => '<p>You have to log in first. <br/> <a href="' . $this->url->create('users/login') . '">Login</a></p>'
			]);
		}
	}
	
}