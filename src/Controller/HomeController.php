<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/home', name: 'categorie', methods: ['GET'])]
    public function categorie(CategorieRepository $categorieRepository): Response
    {
        return $this->render('client/home.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }
    #[Route('/produits/{categorie}', name:'client_product',methods: ['GET'])]
    public function getProduitbyParCategorieId(Categorie $categorie,ProduitRepository $produitRepository): Response
    {
        $produits=$produitRepository->findByCategoryId($categorie);
        return $this->render('client/produit.html.twig',[
            'produits'=> $produits,
            'categorie'=>$categorie


        ]);

    }
}
