<?php
namespace Anax\HTMLForm;
/**
* Anax base class for forms.
*
*/
class CFormComment extends \Mos\HTMLForm\CForm
{
	use \Anax\DI\TInjectionaware,
	\Anax\MVC\TRedirectHelpers;

	
	public $answers=null;
	public $userId;
	public $sourceId;
	public $acronym;
	public $type;
	public $comments;
	public $question;
	
	
	/**
	 * Constructor
	 *
	 */
	public function __construct($comments, $userId, $sourceId, $acronym, $type, $question, $comment=null)
	{
		$this->comments = $comments;
		$this->userId = $userId;
		$this->sourceId = $sourceId;
		$this->acronym = $acronym;
		$this->type = $type;
		$this->question = $question;
		
		parent::__construct([], [
			'text' => [
				'type'        => 'textarea',
				'label'       => 'Comment:',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => isset($comment) ? $comment->text : '',
			],
			'submit' => [
				'type'      => 'submit',
				'callback'  => [$this, 'callbackSubmit'],
			],
		]);
	}
	
	/**
	* Customise the check() method.
	*
	* @param callable $callIfSuccess handler to call if function returns true.
	* @param callable $callIfFail handler to call if function returns true.
	*/
	public function check($callIfSuccess = null, $callIfFail = null)
	{
		return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
	}
	
	
	/**
	* Callback for submit-button.
	*
	*/
	public function callbackSubmit()
	{
		$now = gmdate('Y-m-d H:i:s');
		
		$this->comments->save([
			'commentType' => $this->type,
			'questionAnswerId' => $this->sourceId,
			'userId' => $this->userId,
			'commentText' =>$this->Value('text'),
			'created' => $now, 
			'userAcronym' => $this->acronym
		]);
	
		return true;
	}
	
	
	/**
	 * Callback What to do if the form was submitted?
	 *
	 */
	public function callbackSuccess()
	{	
		$this->redirectTo('questions/id/' . $this->question->id);
	}
	
	
	
	/**
	 * Callback What to do when form could not be processed?
	 *
	 */
	public function callbackFail()
	{
		$this->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
		$this->redirectTo();
	}
}