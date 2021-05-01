<?php

namespace App\Controller;

use App\Entity\Tutorial;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/change_locale/{locale}', name: 'change_locale')]
    public function changeLocale($locale, Request $request)
    {
        // On stocke la langue dans la session
        $request->getSession()->set('_locale', $locale);

        // On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }
}
