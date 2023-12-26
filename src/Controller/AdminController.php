<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Users;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/users',name:'AllUsers', methods: ['GET'])]
    public function getAllUsers(UsersRepository $repository){
        return $this->render('user/user.html.twig',[
            'users'=>$repository->findAll(),
        ]);
    }

    #[Route('/', name: 'dashboard', methods: ['GET'])]
    public function categorie(CategorieRepository $categorieRepository,UsersRepository $repository,ProduitRepository $produitRepository): Response
    {
        return $this->render('dashboard/main.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'count'=> $repository->countAllUsers(),
            'countProduit'=>$produitRepository->countAllProduit(),
        ]);
    }


    #[Route('/{id}', name: 'delete_user', methods: ['POST'])]
    public function delete(Request $request, Users $users, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$users->getId(), $request->request->get('_token'))) {
            $entityManager->remove($users);
            $entityManager->flush();
        }

        return $this->redirectToRoute('AllUsers', [], Response::HTTP_SEE_OTHER);
    }



}
