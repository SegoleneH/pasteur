<?php

namespace App\Controller;

use App\Entity\Tag;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/test')]
class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
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
