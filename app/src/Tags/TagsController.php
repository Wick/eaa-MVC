<?php
namespace Anax\Tags;
 
/**
 * A controller for tags.
 *
 */
class TagsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
		\Anax\MVC\TRedirectHelpers;
	
	
	public $tags;
	
	
	/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function initialize()
	{
		
		$this->tags = new \Anax\Tags\Tag();
		$this->tags->setDI($this->di);
	}
	
	
	/**
	 * List tags.
	 *
	 * @return void
	 */
	public function listAction()
	{
		$all = $this->tags->findAll();
		
		$this->theme->setTitle("Tags");
		$this->views->add('stack/list-all-tags', [
			'tags' => $all,
			'title' => "Tags",
		]);
	}
	
	
	/**
	 * List tag with id and the questions that has that tag.
	 *
	 */
	public function idAction($tagId = null)
	{
		$tag = $this->tags->find($tagId);
		$tagName = $tag->tag;
		
		$tagsQuestions = $this->tags->getQuestonsWithTag($tagName);
			
		$this->theme->setTitle("Visa tagg");
		$this->views->add('stack/view-tags', [
			'tag' => $tag,
			'tagsQuestions' => $tagsQuestions
		]);

	}

	
}