<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_db_app.php'; 

// Start session
$app->session(); 

// Set title
$app->theme->setVariable('title', "Everything about Adventure");

// Add services.  
$di->set('form', '\Mos\HTMLForm\CForm'); 

$di->setShared('db', function() { 
    $db = new \Mos\Database\CDatabaseBasic(); 
    $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php'); 
    $db->connect(); 
    return $db; 
}); 

$di->set('UsersController', function() use ($di) { 
    $controller = new \Anax\Users\UsersController(); 
    $controller->setDI($di); 
    return $controller; 
}); 

$di->set('QuestionsController', function() use ($di) { 
    $controller = new \Anax\Questions\QuestionsController(); 
    $controller->setDI($di); 
    return $controller; 
}); 

$di->set('TagsController', function() use ($di) { 
    $controller = new \Anax\Tags\TagsController(); 
    $controller->setDI($di); 
    return $controller; 
});

// Load theme config and navigation
$app->theme->configure(ANAX_APP_PATH . 'config/theme_stack.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_stack.php');

// Add stylesheets
$app->theme->addStylesheet('css/comments.css'); 

//Set up routes 
$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Everything about Adventure");
	
    $app->dispatcher->forward([ 
        'controller' => 'questions', 
        'action' => 'firstpage', 
        'params' => [], 
    ]); 
	
});

$app->router->add('about', function() use ($app) { 
    $app->theme->setTitle("About"); 
     
    $content = $app->fileContent->get('about.md'); 
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown'); 
     
    $app->views->add('stack/page', [ 
        'content' => $content, 
    ]); 
}); 
 
 
$app->router->handle();


// Render the response using theme engine.
$app->theme->render();