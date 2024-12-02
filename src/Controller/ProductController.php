<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// préfixe avant toutes les routes
#[Route('/products')]
class ProductController extends AbstractController
{
    #[Route('', name:'app_product_index')]
    public function index(ProductRepository $productRepository): Response
    {
        /*
            Lorsqu'on génère une entity, est créé en même temps automatiquement son repository

            On a créé l'entity Product, a été créé également le ProductRepository

            Entity = table
            Repository = Requête de SELECT dans la table

            L'objectif de cette route est d'afficher tous les produits provenant de la base de données,

            Cette méthode va DEPENDRE du ProduitRepository.
            Les dépendances s'écrivent dans les parenthèses de la méthodes
            syntaxe : class $objet
        */

        $products = $productRepository->findAll();// SELECT * FROM product
        /*
           findAll() retourne un tableau d'objets issus de la class Produit (Entity)


           find(2) : SELECT * FROM product WHERE id = 2
           retourne un objet|null
        */
        //dd($products);

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/new', name:'app_product_new')]
    public function new(Request $request, EntityManagerInterface $em):Response
    {
        $product = new Product();
        //$product->setName('test');
        // dump($product);

       $form = $this->createForm(ProductType::class, $product);

       // traitement du formulaire
       $form->handleRequest($request);
       // si le formulaire est soumis et valide (constraints/conditions)
       if ($form->isSubmitted() && $form->isValid()) {
        // dump($product);
        $em->persist($product);
        $em->flush();

        // dd($product);
        return $this->redirectToRoute('app_product_index');

       }


       return $this->render('product/new.html.twig', [
          'formProduct' => $form->createView()
       ]);
    }

    #[Route('/show/{id}', name:'app_product_show')]
    public function show(Product $product): Response
    {
         return $this->render('product/show.html.twig', [
            'product' => $product
         ]);
    }

    #[Route('/edit/{id}', name:'app_product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProductType::class, $product);

       // traitement du formulaire
       $form->handleRequest($request);
       // si le formulaire est soumis et valide (constraints/conditions)
       if ($form->isSubmitted() && $form->isValid()) {

        $em->flush();

        // dd($product);
        return $this->redirectToRoute('app_product_index');

       }
        return $this->render('product/edit.html.twig', [
            'formProduct' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name:'app_product_delete')]
    public function delete(Product $product, EntityManagerInterface $em)
    {
       $em->remove($product);
       $em->flush();
       return $this->redirectToRoute('app_product_index');
    }


}
