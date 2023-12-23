<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/dashboard')]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
//    #[Route('/', name: 'dashboard')]
//    public function dashboard(): Response
//    {
//        return $this->render('dashboard/dashboard.html.twig'
//        );
//    }
    #[Route('/', name: 'dashboard', methods: ['GET'])]
    public function categorie(CategorieRepository $categorieRepository): Response
    {
        return $this->render('dashboard/main.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }
}
