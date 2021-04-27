<?php

namespace App\Controller;

use App\Entity\Tutorial;
use App\Form\TutorialType;
use App\Repository\TutorialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $tutorial = new Tutorial();
        $tutorialForm = $this->createForm(TutorialType::class, $tutorial);

        $tutorialForm->handleRequest($request);
        if($tutorialForm->isSubmitted() && $tutorialForm->isValid()){
            $tutorial->setIsDeleted(false);
            $tutorial->setAuthor($security->getUser());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tutorial);
            $manager->flush();
    
            return $this->redirectToRoute('tutorial_list');
        }

        return $this->render('tutorial/edit.html.twig', [
            'tutorialForm' => $tutorialForm->createView(),
        ]);
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
        $tutorialForm = $this->createForm(TutorialType::class, $tutorial);

        $tutorialForm->handleRequest($request);
        if($tutorialForm->isSubmitted() && $tutorialForm->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
    
            return $this->redirectToRoute('tutorial_list');
        }
    
        return $this->render('tutorial/edit.html.twig', [
            'tutorialForm' => $tutorialForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'view_tutorial')]
    /**
     * Voir un tutoriel
     *
     * @param Tutorial      $tutorial
     *
     * @return Response
     */
    public function view(Tutorial $tutorial): Response
    {
        return $this->render('tutorial/view.html.twig', [
            'tutorial' => $tutorial,
        ]);
    }
}
