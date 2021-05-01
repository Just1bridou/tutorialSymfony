<?php

namespace App\Controller;

use App\Entity\Achievement;
use App\Form\AchievementType;
use App\Repository\AchievementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AchievementController
 * @Route("/achievement", name="achievement_")
 */
class AchievementController extends AbstractController
{
    #[Route('/', name: 'list')]
    /**
     * List of achievements
     * 
     * @param AchievementRepository $achievementRepository
     */
    public function index(AchievementRepository $achievementRepository): Response
    {
        return $this->render('achievement/index.html.twig', [
            'achievements' => $achievementRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'create')]
    /**
     * Create an achievement
     * 
     * @param Request $request
     */
    public function create(Request $request): Response
    {
        //$this->denyAccessUnlessGranted('tuto_create', $security->getUser());

        $achievement = new Achievement();
        $achievementForm = $this->createForm(AchievementType::class, $achievement);

        $achievementForm->handleRequest($request);
        if ($achievementForm->isSubmitted() && $achievementForm->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($achievement);
            $manager->flush();
    
            return $this->redirectToRoute('achievement_list');
        }

        return $this->render('achievement/edit.html.twig', [
            'achievementForm' => $achievementForm->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    /**
     * Edit an achievement
     * 
     * @param Achievement   $achievement
     * @param Request       $request
     * 
     * @return Response
     */
    public function edit(Achievement $achievement, Request $request): Response
    {
        //$this->denyAccessUnlessGranted('tuto_edit', $tutorial->getAuthor());

        $achievementForm = $this->createForm(AchievementType::class, $achievement);

        $achievementForm->handleRequest($request);
        if ($achievementForm->isSubmitted() && $achievementForm->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            return $this->redirectToRoute('achievement_list');
        }
    
        return $this->render('achievement/edit.html.twig', [
            'achievementForm' => $achievementForm->createView(),
        ]);
    }
}
