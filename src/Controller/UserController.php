<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ScoreRepository;
use App\Repository\TutorialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class UserController
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    #[Route('/', name: "account")]
    /**
     * Affiche la page de l'utilisateur connecté
     * 
     * @param Security $security
     * 
     * @return Response
     */
    public function index(Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/index.html.twig', [
            'user' => $security->getUser(),
        ]);
    }

    #[Route('/tutorials/{id}', name: "tutorials")]
    /**
     * Affiche le tableau de bord de ses tutoriels
     * 
     * @param User                  $user
     * @param TutorialRepository    $tutorialRepository
     * 
     * @return Reponse
     */
    public function show_tutorials(User $user, TutorialRepository $tutorialRepository): Response
    {
        $this->denyAccessUnlessGranted('tuto_dashboard', $user);

        return $this->render('user/my_tutorials.html.twig', [
            'tutorials' => $tutorialRepository->findBy(['author' => $user]),
        ]);
    }

    #[Route('/scores/{id}', name: "scores")]
    /**
     * Display the list of user's scores
     * 
     * @param User                  $user
     * @param ScoreRepository       $scoreRepository
     * 
     * @return Reponse
     */
    public function show_scores(User $user, ScoreRepository $scoreRepository): Response
    {
        return $this->render('user/my_scores.html.twig', [
            'scores' => $scoreRepository->findBy(['learner' => $user]),
        ]);
    }
}
