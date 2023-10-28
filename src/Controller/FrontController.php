<?php

namespace App\Controller;

use App\Entity\Faq;
use App\Entity\Metier;
use App\Entity\Praticien;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/')]
class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $faqRepository = $em->getRepository(Faq::class);
        $articleRepository = $em->getRepository(Article::class);
        $praticienRepository = $em->getRepository(Praticien::class);


        //liste des 3 derniers articles pour news ac tags associés
        $news = $articleRepository->findLastArticles(2);
        $newsTags = [];
        foreach ($news as $new) {
            $newsTags[] = [
                'new' => $new,
                'tags' => $new->getTags(),

                
            ];
        }
        // dd($newsTags);

        //liste des praticiens ac metiers e infos pour section RDV/equipe
        $praticiens = $praticienRepository->findAll();
        $praticiensMetiers = [];

        foreach ($praticiens as $praticien) {
            $praticiensMetiers[] = [
                'praticien' => $praticien,
                'metiers' => $praticien->getMetiers()
            ];
        }

        $faqs = $faqRepository->findAll();

        return $this->render('front/index.html.twig', [
            'faqs' => $faqs,
            'news' => $news,
            'newsTags' => $newsTags,
            'praticiensMetiers' => $praticiensMetiers,
        ]);
    }

    #[Route('/front_articles', name: 'app_front_articles')]
    public function frontArticleIndex(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $articleRepository = $em->getRepository(Article::class);

        $articles = $articleRepository->findAll();

        return $this->render('front_articles/index.html.twig', [
            'articles' => $articles,
            
        ]);
    }

    #[Route('/front_articles/{id}', name: 'app_front_articles_show')]
    public function frontArticleshow(Article $article): Response
    {
        return $this->render('front_articles/show.html.twig', [
            'article' => $article,
        ]);
    }
}
