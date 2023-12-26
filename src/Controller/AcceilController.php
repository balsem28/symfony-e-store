<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceilController extends AbstractController
{
    #[Route('/acceil', name: 'app_acceil')]
    public function index(): Response
    {
        return $this->render('acceil/index.html.twig', [
            'controller_name' => 'AcceilController',
        ]);
    }
    #[Route('/phone', name:'phone',methods: ['GET'])]
    public function getphone(ProduitRepository $produitRepository): Response
    {
        $produits=$produitRepository->findphone();
        return $this->render('client/phone.html.twig',[
            'produits'=> $produits,



        ]);

    }
    #[Route('/electromenage', name:'electromenage',methods: ['GET'])]
    public function geelectro(ProduitRepository $produitRepository): Response
    {
        $produits=$produitRepository->findelectro();
        return $this->render('client/electromenager.html.twig',[
            'produits'=> $produits,



        ]);

    }
    #[Route('/laptop', name:'laptop',methods: ['GET'])]
    public function getlaptop(ProduitRepository $produitRepository): Response
    {
        $produits=$produitRepository->findlaptop();
        return $this->render('client/laptop.html.twig',[
            'produits'=> $produits,



        ]);

    }
}
