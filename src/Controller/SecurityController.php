<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\RegistrationFormType;

class SecurityController extends AbstractController
{


    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, TokenStorageInterface $tokenStorage): Response
    {
        $success = false;
        $errorm = false;

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Access the user roles from the security token
        $user = $this->getUser();
        $userRoles = $user ? $user->getRoles() : [];

        // Your existing code for registration form
        $registrationForm = $this->createForm(RegistrationFormType::class);

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'registrationForm' => $registrationForm->createView(),
            'success' => $success,
            'errorm' => $errorm,
            'user_roles' => $userRoles, // Pass the roles to the template
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
