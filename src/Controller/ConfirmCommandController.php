<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\DetailleCommandeRepository;
use App\Repository\UsersRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;


class ConfirmCommandController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }
        #[Route('/facture/{commande}', name: 'facture', methods: ['GET'])]
    public function detailleProduit(Commande $commande,DetailleCommandeRepository $detailleCommandeRepositorycommand,CommandeRepository $commandeRepository): Response
    {
        $details = $detailleCommandeRepositorycommand->findByCommandeId($commande);
        $commande= $commandeRepository->find($commande);
        $TOTALE=0;
        foreach($details as $detail ){
            $TOTALE += $detail->getTotale();
        }

        return $this->render('client/facture.html.twig', [
            'details' =>$details,
            'TOTALE'=>$TOTALE,
            'commande'=>$commande,

        ]);
    }

    #[Route('/confirm/command/{commande}', name: 'app_confirm_command')]
    public function confirmCommand(Commande $commande , CommandeRepository $repository, EntityManagerInterface $entityManager): Response

    {
        $user = $commande->getUsers();
        $count=0;
        $countProduit=0;
        $caterories=0;
        $this->emailVerifier->sendEmailConfirmation('app_verify_email_command', $user,
            (new TemplatedEmail())
                ->from(new Address('alabjaoui18@gmail.com', 'ala'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_Commande.html.twig')




        );
        $existentCommand = $repository->find($commande);
        $existentCommand->setVerifie("valid");
        $entityManager->persist($existentCommand);
        $entityManager->flush();

        return $this->render('dashboard/main.html.twig', [
            'categories' => $caterories,
            'count'=>$count,
            'countProduit'=>$countProduit,

        ]);
    }
    #[Route('/verify/email', name: 'app_verify_email_command')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UsersRepository $usersRepository,CommandeRepository $commandeRepository, Commande $commande): Response
    {
        $id = $request->query->get('id');

        if (null === $id) {
            return $this->redirectToRoute('facture');
        }

        $user = $usersRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('facture');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('facture');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('facture', ['commande' => $commandeRepository->find($commande)]);
    }

}
