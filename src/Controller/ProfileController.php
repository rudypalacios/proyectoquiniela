<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile", methods={"GET"})
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        return $this->renderForm('profile/index.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/profile", name="app_profile_edit", methods={"POST"})
     */
    public function edit(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();
        $currentPassword = $user->getPassword();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainTextPassword = $user->getPassword();

            if (!empty($plainTextPassword)) {
                $encodedPassword = $passwordHasher->hashPassword($user, $plainTextPassword);
                $user->setPassword($encodedPassword);
            } else {
                $user->setPassword($currentPassword);
            }

            $userRepository->add($user, true);
        }

        return $this->renderForm('profile/index.html.twig', [
            'form' => $form
        ]);
    }
}
