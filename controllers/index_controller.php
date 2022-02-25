<?php

    /**
    * page d'accueil du controller
    */
    class IndexController
    {
        private $model;

        function __construct($model)
        {
            $this->model = $model;
        }

        public function sayWelcome()
        {
            return $this->model->welcomeMessage();
        }


    }