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
                'tags' => $new->getTags()
            ];
        }

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
}
