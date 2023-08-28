<?php

namespace App\Controller\utilisateur;

use App\Form\ModificationPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\UtilisateurRepository;
use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Log\Logger;

#[Route('/utilisateur')]
class ModificationPasswordController extends AbstractController
{

    private $logger;

    // Constructor
    public function __construct()
    {
        // Initialize properties with constructor parameters
        $this->logger = new Logger();
    }

    #[Route('/{uid}/edit', name: 'app_modification_password', methods: ['GET', 'POST'])]
    public function edit($uid, Request $request, EntityManagerInterface $entityManager,
        UtilisateurRepository $utilisateurRepository,
        UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $utilisateur = $utilisateurRepository->findOneBy(["id" => $uid]);

        $form = $this->createForm(ModificationPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ($userPasswordHasherInterface->isPasswordValid($utilisateur, $data['plainPassword'])) {
                $newPassword = $data['newPassword'];
                $hashedNewPassword = $userPasswordHasherInterface->hashPassword($utilisateur, $newPassword);
                $utilisateur->setPassword($hashedNewPassword);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Votre mot de passe a bien été modifié.'
                );
                return $this->redirectToRoute('app_utilisateur_accueil', [], Response::HTTP_SEE_OTHER);
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect.'
                );
            }
        }



        return $this->render('utilisateur/modification_password/index.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }
}
