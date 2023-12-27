<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/app')]
class HomeController extends AbstractController
{

    #[Route('/', name: 'categorie', methods: ['GET'])]
    public function categorie(CategorieRepository $categorieRepository,Security $security): Response
    {
        $users = $security->getUser();
        $isLogin=false;
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            $isLogin=true;
        }

        return $this->render('client/home.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'isLogin'=>$isLogin,
            'users'=>$users,

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
