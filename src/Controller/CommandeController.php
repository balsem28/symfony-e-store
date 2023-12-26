<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\DetailleCommande;
use App\Entity\Produit;
use App\Repository\CommandeRepository;
use App\Repository\DetailleCommandeRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
#[Route('/commande')]
class CommandeController extends AbstractController
{

    #[Route('/', name: 'all_commande', methods: ['GET'])]
    public function index(CommandeRepository $repository): Response
    {
        return $this->render('commande/allCommande.html.twig', [
            'commandes' => $repository->findAll(),
        ]);
    }
    #[Route('/detaille/{commande}', name: 'commande_detaille', methods: ['GET'])]
    public function detailleProduit(Commande $commande,DetailleCommandeRepository $command): Response
    {
        $details = $command->findByCommandeId($commande);
        $TOTALE=0;
        foreach($details as $detail ){
            $TOTALE += $detail->getTotale();
        }

        return $this->render('commande/detailleCommande.html.twig', [
            'details' =>$details,
             'TOTALE'=>$TOTALE

        ]);
    }
    #[Route('/{id}', name: 'commande_delete', methods: ['POST'])]
    public function delete(Request $request,Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('all_commande', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/ajout', name: 'app_commande')]
    public function add(SessionInterface $session, ProduitRepository $produitRepository,EntityManagerInterface $entityManager): Response
    {

        // Check if the user is authenticated
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $panier =$session->get('panier',[]);
            if ($panier === []){
                return $this->redirectToRoute('categorie');
            }else{
                $commande= new Commande();
                $commande->setUsers($this->getUser());
                $commande->setDate(new \DateTime());
                $commande->setVerifie("not valid");
                foreach ($panier as $item => $quantite){
                    $detailleCommande= new DetailleCommande();
                    $detailleCommande->setProduit($produitRepository->find($item));
                    $detailleCommande->setPrix($produitRepository->find($item)->getPrix());
                    $detailleCommande->setQuantite($quantite);
                    $detailleCommande->setTotale($quantite * ($produitRepository->find($item)->getPrix()));
                    $commande->addDetaileCommande($detailleCommande);
                }
                $entityManager->persist($commande);
                $entityManager->flush();

            }

            return $this->render('commande/index.html.twig');
        } else {
            // The user is not authenticated
            // Redirect to login page or handle the situation accordingly
            return $this->redirectToRoute('app_login');
        }

    }
}
