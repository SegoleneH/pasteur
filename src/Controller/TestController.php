<?php

namespace App\Controller;

use App\Entity\Tag;
use Doctrine\Persistence\ManagerRegistry;
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

    #[Route('/tag', name: 'app_test_tag')]
    public function tag(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $tagRepository = $em->getRepository(Tag::class);

        //NEW : création d'un tag
        $newTag = new Tag();
        $newTag->setNom('Nouveau tag');
        $newTag->setDescription('Nouveau tag');

        $em->persist($newTag);
        $em->flush();

        // SHOW : all tags
        $tags = $tagRepository->findAll();

        // SHOW : one tag
        $tag1 = $tagRepository->find(1);

        // UPDATE : edit tag
        $tag1->setNom('tagTest2');
        $em->flush();

        // DELETE : delete tag
        $tag2 = $tagRepository->find(2);
        if ($tag2) {
            $em->remove($tag2);
        }
        $em->flush();

        return $this->render('test/tag.html.twig', [
            'controller_name' => 'TestController',
            'tags' => $tags,
            'tag1' => $tag1,
            'tag2' => $tag2,
            'newTag' => $newTag,
        ]);
    }

}
