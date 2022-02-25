<?php

    /**
    * page d'accueil du model
    */
    class IndexModel
    {

        private $message = 'Welcome to Home page.';

        function __construct()
        {

        }

        public function welcomeMessage()
        {
            return $this->message;
        }

    }