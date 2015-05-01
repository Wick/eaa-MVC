<?php
namespace Anax\HTMLForm;
/**
* Anax base class for forms
*
*/
class CFormLogin extends \Mos\HTMLForm\CForm
{
	use \Anax\DI\TInjectionaware,
	\Anax\MVC\TRedirectHelpers;

	
	public $users=null;	
	
	/**
	 * Constructor
	 *
	 */
	public function __construct($users, $user=null)
	{	
		$this->users=$users;			
		
		parent::__construct([], [
			'acronym' => [
				'type'        => 'text',
				'label'       => 'Username:',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => '',
			],
			'password' => [
				'type'        => 'number',
				'label'       => 'Password:',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => '',
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
		
		$acronym = $this->Value('acronym');
		$password = $this->Value('password');
		
		$user = $this->users->checkLogin($acronym);

		if(password_verify($password, $user->password)){
			$this->saveInSession = true;
			return true;
		}
		else{
			return false;
		}
	}
	
	
	/**
	 * Callback What to do if the form was submitted?
	 *
	 */
	public function callbackSuccess()
	{
		$this->redirectTo('users/id/' . ($this->users->id));
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