<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item - Home
        'home'  => [
            'text'  => 'Home',
            'url'   => $this->di->get('url')->create(''),
            'title' => ''
        ],

        // This is a menu item - Questions
         'questions'  => [
            'text'  => 'Questions',
            'url'   => $this->di->get('url')->create('questions/list'),
            'title' => 'Questions'
        ],

        // This is a menu item - Tags
        'tags' => [
            'text'  =>'Tags',
            'url'   => $this->di->get('url')->create('tags/list'),
            'title' => 'Tags'
        ],
		
		// This is a menu item - Users
        'users' => [
            'text'  =>'Users',
            'url'   => $this->di->get('url')->create('users/list'),
            'title' => 'Users'
        ],
		
		// This is a menu item - About
        'about' => [
            'text'  =>'About',
            'url'   => $this->di->get('url')->create('about'),
            'title' => 'About'
        ],
		
		// This is a menu item - Ask a question
        'addQuestion' => [
            'text'  =>'Ask a question',
            'url'   => $this->di->get('url')->create('questions/add'), 
            'title' => 'Ask a question'
        ],

    ],
 


    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getCurrentUrl(false)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   /*
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    */
];
