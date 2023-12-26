<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
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

    #[Route('/confirm/command/{id}', name: 'app_confirm_command')]
    public function confirmCommand(Commande $commande , CommandeRepository $repository, EntityManagerInterface $entityManager): Response

    {
        $user = $commande->getUsers();
        $caterories=0;
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
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
            'categories' => $caterories

        ]);
    }

}
