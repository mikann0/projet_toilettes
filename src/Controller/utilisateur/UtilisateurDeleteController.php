<?php

namespace App\Controller\utilisateur;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/utilisateur')]
class UtilisateurDeleteController extends AbstractController
{


    #[Route('/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete ($id, Request $request, Utilisateur $utilisateur,
        CommentRepository $commentRepository, EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $comments = $commentRepository->findBy(["idUtilisateur" => $id]);
            foreach($comments as $comment) {
                $entityManager->remove($comment);
                $entityManager->flush();
            }
            $entityManager->remove($utilisateur);
            $entityManager->flush();

        }
        // Clear the user from the security context
        $tokenStorage->setToken(null);
        return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
    }
}
