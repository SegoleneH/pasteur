<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Faq;

#[Route('/test')]
class TestController extends AbstractController
{
    #[Route('/faq', name: 'app_test_faq')]
    public function faq(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $repoFaq = $em->getRepository(Faq::class);

        //liste de tous les faqs
        $faqs = $repoFaq->findAll();

        //création d'une nouvelle Faq
        $newFaq = new Faq();
        $newFaq->setQuestion('Nouvelle question');
        $newFaq->setReponse('Nouvelle reponse');
        $em->persist($newFaq);
        $em->flush();

        //edition d'une faq existante
        $faq2 = $repoFaq->find(2);
        $faq2->setQuestion('Nouvelle question 2');
        $faq2->setReponse('Nouvelle reponse 2');
        $em->flush();   

        //suppression d'une faq existante
        $faq5 = $repoFaq->find(5);
        if ($faq5) {
            $em->remove($faq5);
            $em->flush();
        }

        $title = 'FAQ Test';
        return $this->render('test/faq.html.twig', [
            'title' => $title,
            'faqs' => $faqs,
        ]);
    }
}
