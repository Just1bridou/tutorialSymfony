<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\TutorialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{
    #[Route('/', name: 'list')]
    /**
     * Display the parent categories
     * 
     * @param CategoryRepository    $categoryRepository
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findBy(["categoryParent" => null])
        ]);
    }

    #[Route('/{id}', name: 'show')]
    /**
     * Display the chilren categories
     * 
     * @param Category              $category
     * @param CategoryRepository    $categoryRepository
     * @param TutorialRepository    $tutorialRepository
     */
    public function show(Category $category, CategoryRepository $categoryRepository, TutorialRepository $tutorialRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'currentCategory' => $category,
            'categories' => $categoryRepository->findBy(["categoryParent" => $category]),
            'tutorials' => $tutorialRepository->findBy(["category" => $category])
        ]);
    }
}
