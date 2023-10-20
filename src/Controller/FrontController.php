<?php

namespace App\Controller;

use App\Entity\Faq;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $faqRepository = $em->getRepository(Faq::class);

        $faqs = $faqRepository->findAll();

        return $this->render('front/index.html.twig', [
            'faqs' => $faqs,
        ]);
    }
}
