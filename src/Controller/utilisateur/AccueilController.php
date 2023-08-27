<?php

namespace App\Controller\utilisateur;

use App\Repository\CommentRepository;
use App\Repository\ToilettesRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Foreach_;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/utilisateur')]
class AccueilController extends AbstractController
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

    #[Route('', name: 'app_utilisateur_accueil')]
    public function index(Request $request, Security $security, CommentRepository $commentRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $token = $security->getToken();
        $searchValue = $request->query->get('searchValue');
        $toilettes = $this->toilettesRepository->search($searchValue);
        $moyenNotes = [];

        foreach ($toilettes as $toilette) {
            $comment = $commentRepository->findBy(['idToilette' => $toilette['uid']]);
            if (!empty($comment)) {
                $queryBuilder = $commentRepository->createQueryBuilder('comment')
                    ->select('SUM(comment.note) as sum')
                    ->where('comment.idToilette = :specialId')
                    ->setParameter('specialId', $toilette['uid'])
                    ->getQuery();
                $sum = $queryBuilder->getSingleScalarResult();
                $moyenNote = $sum / count($comment);

                $moyenNotes[$toilette['uid']] = $moyenNote;
            }else{
                $moyenNotes[$toilette['uid']] = -1;
            }
        }
        if ($token !== null) {
            $utilisateur = $token->getUser();
            return $this->render('utilisateur/accueil/index.html.twig', [
                'searchValue' => $searchValue,
                'toilettes' => $toilettes,
                'utilisateur' => $utilisateur,
                'moyenNotes' => $moyenNotes,
            ]);
        }
    }
}
