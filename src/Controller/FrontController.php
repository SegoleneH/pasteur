<?php

namespace App\Controller;

use App\Entity\Faq;
use App\Entity\Article;
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
        $articleRepository = $em->getRepository(Article::class);

        //liste des 3 derniers articles pour news ac tags associés
        $news = $articleRepository->findLastArticles(3);
        $newsTags = [];
        foreach ($news as $new) {
            $newsTags[] = [
                'new' => $new,
                'tags' => $new->getTags()
            ];
        }

        $faqs = $faqRepository->findAll();

        return $this->render('front/index.html.twig', [
            'faqs' => $faqs,
            'news' => $news,
            'newsTags' => $newsTags,
        ]);
    }
}
