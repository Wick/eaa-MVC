<?php

namespace Anax\MVC;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CDatabaseApplication
{
    use \Anax\DI\TInjectable,
        \Anax\MVC\TRedirectHelpers;



    /**
     * Construct.
     *
     * @param array $di dependency injection of service container.
     */
    public function __construct($di)
    {
        // Add CForm
        $di->set('form', '\Mos\HTMLForm\CForm');
        
        // Add FormController
        $di->set('FormController', function () use ($di) {
            $controller = new \Anax\HTMLForm\FormController();
            $controller->setDI($di);
            return $controller;
        });
        
        // Add CDatabaseBasic
        $di->setShared('db', function() {
            $db = new \Mos\Database\CDatabaseBasic();
            $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
            $db->connect();
            return $db;
        });
        
        $this->di = $di;
    }
}