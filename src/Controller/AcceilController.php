<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\Users;
use App\Form\ProduitType;
use App\Form\UserForm;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/{id}/edit', name: 'user', methods: ['GET', 'POST'])]
    public function edit(Request $request, Users $users, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserForm::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/information.html.twig', [
            'users' => $users,
            'form' => $form,
        ]);
    }
}
