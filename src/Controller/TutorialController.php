<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Tutorial;
use App\Form\CommentType;
use App\Form\TutorialType;
use App\Manager\ScoreManager;
use App\Repository\TutorialRepository;
use App\Repository\ScoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class TutorialController
 * @Route("/tutorial", name="tutorial_")
 */
class TutorialController extends AbstractController
{
    #[Route('/', name: 'list')]
    /**
     * Liste tous les tutoriels
     * 
     * @param TutorialRepository $tutorialRepository
     * 
     * @return Response
     */
    public function index(TutorialRepository $tutorialRepository): Response
    {
        return $this->render('tutorial/index.html.twig', [
            'tutorials' => $tutorialRepository->tenLastsTutorials(),
        ]);
    }

    #[Route('/create', name: 'create')]
    /**
     * Crée un tutoriel
     * 
     * @param Request   $request
     * @param Security  $security
     * 
     * @return Reponse
     */
    public function create(Request $request, Security $security): Response
    {
        $this->denyAccessUnlessGranted('tuto_create', $security->getUser());

        $tutorial = new Tutorial();
        $tutorialForm = $this->createForm(TutorialType::class, $tutorial);

        $tutorialForm->handleRequest($request);
        if ($tutorialForm->isSubmitted() && $tutorialForm->isValid()){
            $tutorial->setIsDeleted(false);
            $tutorial->setAuthor($security->getUser());
            $tutorial->setCreatedAt(new \DateTime());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tutorial);
            $manager->flush();
    
            return $this->redirectToRoute('tutorial_list');
        }

        return $this->render('tutorial/edit.html.twig', [
            'tutorialForm' => $tutorialForm->createView(),
        ]);
    }

    #[Route('/search', name: 'search')]
    /**
     * Search a tutorial
     *
     * @param Request $request
     * @param TutorialRepository $tutorialRepository
     *
     * @return JsonResponse
     */
    public function searchTutorial(Request $request, TutorialRepository $tutorialRepository): JsonResponse
    {
        $tutorials = $tutorialRepository->searchTutorial($request->request->get("query"));
        return new JsonResponse($tutorials, Response::HTTP_OK);
    }

    #[Route('/edit/{id}', name: 'edit')]
    /**
     * Modifie un tutoriel
     * 
     * @param Tutorial      $tutorial
     * @param Request       $request
     * 
     * @return Response
     */
    public function edit(Tutorial $tutorial, Request $request): Response
    {
        $this->denyAccessUnlessGranted('tuto_edit', $tutorial->getAuthor());
        $tutorialForm = $this->createForm(TutorialType::class, $tutorial);

        $tutorialForm->handleRequest($request);
        if ($tutorialForm->isSubmitted() && $tutorialForm->isValid()){
            $tutorial->setEditedAt(new \DateTime());

            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            return $this->redirectToRoute('tutorial_list');
        }
    
        return $this->render('tutorial/edit.html.twig', [
            'tutorialForm' => $tutorialForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'view')]
    /**
     * Voir un tutoriel
     *
     * @param Tutorial      $tutorial
     * @param Request       $request
     * @param Security      $security
     *
     * @return Response
     */
    public function view(Tutorial $tutorial, Request $request, Security $security): Response
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);

        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setTutorial($tutorial)
                    ->setAuthor($security->getUser());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();
    
            return $this->redirectToRoute('tutorial_view', ['id' => $tutorial->getId()]);
        }

        return $this->render('tutorial/view.html.twig', [
            'tutorial' => $tutorial,
            'commentForm' => $commentForm->createView(),
        ]);
    }

    #[Route('/quiz/{id}', name: 'play_quiz')]
    /**
     * Lance le quiz du tutoriel
     * 
     * @todo Retourner le meilleur score de l'utilisateur connecté sur ce $tutorial
     *
     * @param Tutorial          $tutorial
     * @param Request           $request
     *
     * @return Response
     */
    public function quiz(Tutorial $tutorial, Request $request): Response
    {
        $this->denyAccessUnlessGranted('tuto_play', $tutorial->getAuthor());

        return $this->render('tutorial/quiz.html.twig', [
            'tutorial' => $tutorial,
        ]);
    }

    #[Route('/response/ajax', name: 'response')]
    /**
     * Reponse d'ajax
     * 
     * @todo Trouver un nom cohérent pour la route
     *
     * @param Request       $request
     * @param ScoreManager  $scoreManager
     *
     * @return JsonResponse
     */
    public function quizResponse(Request $request, ScoreManager $scoreManager): JsonResponse
    {
        $scoreManager->SaveScore($request);
        return new JsonResponse(null, Response::HTTP_OK);
    }
}
