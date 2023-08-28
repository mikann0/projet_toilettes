<?php

namespace App\Controller\utilisateur;

use App\Entity\Comment;
use App\Repository\ToilettesRepository;
use App\Repository\CommentRepository;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('/utilisateur')]
class InfoController extends AbstractController
{
    public $toilettesRepository;
    public $logger;
    // Constructor
    public function __construct(ToilettesRepository $repository)
    {
        // Initialize properties with constructor parameters
        $this->toilettesRepository = $repository;
        $this->logger = new Logger();
    }


    #[Route('/toilette/{tid}', name: 'app_utilisateur_info')]
    public function index($tid, CommentRepository $commentRepository, Security $security,
        EntityManagerInterface $entityManagerInterface): Response
    {
        $this->logger->log(LogLevel::WARNING, "Request toilette with id=" . $tid);
        $uneToilette = $this->toilettesRepository->uneToilette($tid);
        $token = $security->getToken();
        if ($token !== null) {
            $utilisateur = $token->getUser();
            $comments = $commentRepository->findBy(['idToilette' => $tid]);

            if (!empty($comments)) {
                $queryBuilder = $commentRepository->createQueryBuilder('comment')
                    ->select('SUM(comment.note) as sum')
                    ->where('comment.idToilette = :specialId')
                    ->setParameter('specialId', $uneToilette['uid'])
                    ->getQuery();
                $sum = $queryBuilder->getSingleScalarResult();
                $moyenNote = $sum / count($comments);
            } else {
                $moyenNote = -1;
            }


            if ($utilisateur instanceof Utilisateur) {
                $userId = $utilisateur->getId();
                $utilisateurComment = $commentRepository->findOneBy(['idToilette' => $tid, 'idUtilisateur' => $userId]);
            }

            return $this->render('utilisateur/info/index.html.twig', [
                'toilette' => $uneToilette,
                'comments' => $comments,
                'utilisateur' => $utilisateur,
                'userComment' => $utilisateurComment,
                'moyenNote' => $moyenNote,
            ]);
        }
    }
}
