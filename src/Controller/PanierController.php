<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/panier')]
class PanierController extends AbstractController

{
    #[Route('/add/{id}', name: 'add')]
    public function add(Produit $produit,SessionInterface $session){
        $panier = $session->get("panier",[]);
        $id = $produit->getId();
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] =1;
        }
        $session->set("panier", $panier);
        return $this->redirectToRoute("app_panier");
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Produit $produit,SessionInterface $session){
        $panier = $session->get("panier",[]);
        $id = $produit->getId();
        if(!empty($panier[$id])){
            if ($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }else{
            $panier[$id] =1;
        }
        $session->set("panier", $panier);
        return $this->redirectToRoute("app_panier");
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Produit $produit,SessionInterface $session){
        $panier = $session->get("panier",[]);
        $id = $produit->getId();
        if(!empty($panier[$id])){
            unset($panier[$id]);
            }
        $session->set("panier", $panier);
        return $this->redirectToRoute("app_panier");
    }

    #[Route('/main', name: 'app_panier')]
    public function index(SessionInterface $session, ProduitRepository $produitRepository,CategorieRepository $categorieRepository): Response
    {
        $panier = $session->get("panier",[]);
        $dataPanier = [];
        $totale = 0;
        foreach ($panier as $id=> $quantite){
            $produit=$produitRepository->find($id);
            $dataPanier[] = [
                "produit" => $produit,
                "quantite" => $quantite
            ];
            $totale += $produit->getPrix()*$quantite;

    }
        return $this->render('panier/index.html.twig',[
                'categories' => $categorieRepository->findAll(),
                'dataPanier' => $dataPanier,
                'totale' => $totale

            ]

        );
    }


}
