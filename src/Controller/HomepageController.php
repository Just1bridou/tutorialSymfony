<?php

namespace App\Controller;

use App\Entity\Tutorial;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager){}

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $tutorials = $this->entityManager->getRepository(Tutorial::class);

        return $this->render('homepage/index.html.twig');
    }
}
