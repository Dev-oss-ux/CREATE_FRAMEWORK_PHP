<?php

$url = isset($_SERVER['REQUEST_URI']) ? explode('/', ltrim($_SERVER['REQUEST_URI'], '/')) : '/';
    echo "<pre>";
    var_dump($url);
    echo "</pre>";

    if ($url == '/')
    {
    	// echo "Page d'accueil.";

        // Ceci est la page d'accueil
        // Lancer le contrôleur domestique
        // et affiche la vue d'accueil
        require_once __DIR__.'/Models/index_model.php';
        require_once __DIR__.'/Controllers/index_controller.php';
        require_once __DIR__.'/Views/index_view.php';

        $indexModel = New IndexModel();
        $indexController = New IndexController($indexModel);
        $indexView = New IndexView($indexController, $indexModel);

        print $indexView->index();

    }else{

    	// echo "Pas une page d'accueil.";
    
        // Ceci n'est pas la page d'accueil
        // Lancer le contrôleur approprié
        // et afficher la vue requise

        //Le premier élément doit être un contrôleur
        $requestedController = $url[0]; 

        // Si une deuxième partie est ajoutée dans l'URI,
        // ce devrait être une méthode
        $requestedAction = isset($url[1])? $url[1] :'';

        // Les parties restantes sont considérées comme
        // arguments de la méthode
        $requestedParams = array_slice($url, 2); 

       // Vérifie si le contrôleur existe. NB :
        // Vous devez le faire pour le modèle et la vue aussi
        $ctrlPath = __DIR__.'/Controllers/'.$requestedController.'_controller.php';



        if (file_exists($ctrlPath))
        {

            require_once __DIR__.'/Models/'.$requestedController.'_model.php';
            require_once __DIR__.'/Controllers/'.$requestedController.'_controller.php';
            require_once __DIR__.'/Views/'.$requestedController.'_view.php';

            $modelName      = ucfirst($requestedController).'Model';
            $controllerName = ucfirst($requestedController).'Controller';
            $viewName       = ucfirst($requestedController).'View';

            $controllerObj  = new $controllerName( new $modelName );
            $viewObj        = new $viewName( $controllerObj, new $modelName );


            // S'il y a une méthode - Deuxième paramètre
            if ($requestedAction != '')
            {
                // puis on appelle la méthode via la vue
                // appel dynamique de la vue
                print $viewObj->$requestedAction($requestedParams);

            }

        }else{

            header('HTTP/1.1 404 Not Found');
            die('404 - The file - '.$ctrlPath.' - not found');
            // exige le contrôleur 404 et l'initie
            //Afficher sa vue
        }
    }