<?php

namespace App\Controller;// App = src

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /*
        1e argument : La route (dans l'URL)
        2e argument : Le nom de la route (lien/ redirection)

        2 syntaxes :

        Annotations :

        /**
         * @Route("", name="")
         * /
         
         Attribut : 

         #[Route('/', name:'')]
    */

    
    #[Route('/', name:'app_home')]
    public function home() : Response
    {
        $prenomController = 'bart';
        $fruits = ['fraise', 'banane', 'kiwi', 'orange'];

        dump($prenomController);

        // dump($fruits);die;

        //dd($fruits);

        /*
            La méthode render() provenant d'AbstractController permet de rendre une vue (template)
            1e argument (str) : nom et emplacement du fichier html.twig dans le dossier templates
            2e argument (array) : tableau des paramètres à faire passer à la vue
        */
        return $this->render('home/index.html.twig', [
            // k => v
            'prenomTwig' => $prenomController,
            'isConnect' => true,
            'fruits' => $fruits
        ]);
    }


    #[Route('/catalogue2024', name:'app_catalogue')]
    public function catalogue(): Response
    {


        return $this->render('home/catalogue.html.twig');
    }
    

 
}
