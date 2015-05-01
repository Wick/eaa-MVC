<?php
namespace Anax\HTMLForm;
/**
* Anax base class for forms.
*
*/
class CFormQuestion extends \Mos\HTMLForm\CForm
{
	use \Anax\DI\TInjectionaware,
	\Anax\MVC\TRedirectHelpers;

	
	public $questions=null;
	public $userId;
	public $tags;
	
	
	/**
	 * Constructor
	 *
	 */
	public function __construct($questions, $userId, $tags, $question=null)
	{
		
		$this->questions = $questions;
		$this->userId = $userId;
		$this->tags = $tags;
		
		parent::__construct([], [
			'title' => [
				'type'        => 'text',
				'label'       => 'Subject:',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => isset($question) ? $question->title : '',
			],
			'text' => [
				'type'        => 'textarea',
				'label'       => 'Text:',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => isset($question) ? $question->text : '',
			],
			'tags' => [
				'type'        => 'text',
				'label'       => 'Tags: (separate with ",")',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => isset($question) ? $question-tags : '',
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

		$this->questions->save([
			'userId' => $this->userId,
			'question' => $this->Value('text'),
			'questionTitle' => $this->Value('title'),
			'created' => $now
		]);
		
		$maxQuestionId = $this->questions->getLastId();
		
		$insertTags = explode(",", $this->Value('tags'));
		
		foreach($insertTags as $tag) {
			$this->tags->saveTag($tag, $maxQuestionId);
		}
		
		return true;
	}
	
	
	/**
	 * Callback What to do if the form was submitted?
	 *
	 */
	public function callbackSuccess()
	{	
		$this->redirectTo('questions/list');
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