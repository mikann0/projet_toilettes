<?php

namespace App\Controller\utilisateur;

use App\Entity\Comment;
use App\Entity\Utilisateur;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\ToilettesRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('/utilisateur/comment')]
class UtilisateurCommentController extends AbstractController
{
    public $toilettesRepository;
    public $logger;

    public function __construct(ToilettesRepository $repository)
    {
        // Initialize properties with constructor parameters
        $this->toilettesRepository = $repository;
        $this->logger = new Logger();
    }

    #[Route('/', name: 'app_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository, Security $security): Response
    {
        $token = $security->getToken();
        if ($token !== null) {
            $this->logger->log(LogLevel::WARNING, "token=" . $token);

            /** @var Utilisateur $utilisateur */
            $utilisateur = $token->getUser();
            $comments = $commentRepository->findBy(["idUtilisateur" => $utilisateur->getId()]);
            $toiletById = [];
            foreach ($comments as $comment) {
                $toiletId = $comment->getIdToilette();
                $toilet = $this->toilettesRepository->uneToilette($toiletId);
                $toiletById[$toiletId] = $toilet;
            }

            return $this->render('utilisateur/comment/index.html.twig', [
                'comments' => $comments,
                'utilisateur' => $utilisateur,
                'toiletById' => $toiletById
            ]);
        }
    }

    #[Route('/{tid}/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new($tid, Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        
        $token = $security->getToken();
        if ($token !== null) {
            $this->logger->log(LogLevel::WARNING, "token=" . $token);
            $uneToilette = $this->toilettesRepository->uneToilette($tid);

            /** @var Utilisateur $utilisateur */
            $utilisateur = $token->getUser();
            if ($utilisateur instanceof Utilisateur) {
                $comment = new Comment();
                $comment->setIdToilette($tid);
                $comment->setIdUtilisateur($utilisateur);
                $form = $this->createForm(CommentType::class, $comment);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager->persist($comment);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('utilisateur/comment/new.html.twig', [
                    'comment' => $comment,
                    'utilisateur' => $utilisateur,
                    'toilette' => $uneToilette,
                    'form' => $form,
                ]);
            }
        }
    }


    // #[Route('/{id}', name: 'app_comment_show', methods: ['GET'])]
    // public function show(Comment $comment): Response
    // {
    //     return $this->render('utilisateur/comment/show.html.twig', [
    //         'comment' => $comment,
    //     ]);
    // }

    #[Route('/{tid}/edit', name: 'app_comment_edit', methods: ['GET', 'POST'])]
    public function edit(
        $tid,
        Request $request,
        EntityManagerInterface $entityManager,
        CommentRepository $commentRepository,
        Security $security
    ): Response {


        $token = $security->getToken();
        if ($token !== null) {
            $this->logger->log(LogLevel::WARNING, "token=" . $token);
            $utilisateur = $token->getUser();
            if ($utilisateur instanceof Utilisateur) {
                $userId = $utilisateur->getId();
                $comment = $commentRepository->findOneBy(['idToilette' => $tid, 'idUtilisateur' => $userId]);
                $comment->setDateCommentaire(new DateTime());
                
                $uneToilette = $this->toilettesRepository->uneToilette($tid);
                $form = $this->createForm(CommentType::class, $comment);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager->flush();

                    return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('utilisateur/comment/edit.html.twig', [
                    'comment' => $comment,
                    'utilisateur' => $utilisateur,
                    'form' => $form,
                    'toilette' => $uneToilette,
                ]);
            }
        }
    }

    #[Route('/{id}', name: 'app_comment_delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
    }
}
