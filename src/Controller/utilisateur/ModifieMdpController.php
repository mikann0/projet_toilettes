<?php

namespace App\Controller\utilisateur;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;

#[Route('/utilisateur')]
class ModifieMdpController extends AbstractController
{
    #[Route('/{uid}/modifie/mdp', name: 'app_modifie_mdp', methods: ['GET', 'POST'])]
    public function index($uid, Request $request, EntityManagerInterface $entityManager, UtilisateurRepository $utilisateurRepository): Response
    {
        $utilisateur = $utilisateurRepository->findOneBy(["id" => $uid]);
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/modifie_mdp/index.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }
}
