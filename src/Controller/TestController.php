<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Editeur;
use App\Entity\Faq;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Faq;
use App\Entity\Metier;
use App\Entity\Praticien;

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

    #[Route('/metier', name: 'app_test_metier')]
    public function metier(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $repoMetier = $em->getRepository(Metier::class);

        //all metiers
        $metiers = $repoMetier->findAll();

        //new metier
        $newMetier = new Metier();
        $newMetier->setNom('Nouveau métier');
        $newMetier->setDescription(null);
        $em->persist($newMetier);
        $em->flush();

        //edit metier
        $metier1 = $repoMetier->find(1);
        $metier1->setNom('Nouveau nom metier 1');
        $em->flush();
        
        //delete metier
        $metier4 = $repoMetier->find(6);

        if ($metier4) {
            $em->remove($metier4);
            $em->flush();
        }

        $title = 'Metier Test';
        return $this->render('test/metier.html.twig', [
            'title' => $title,
            'metiers' => $metiers,
        ]);
    }

    #[Route('/praticien', name: 'app_test_praticien')]
    public function praticien(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $repoPraticien = $em->getRepository(Praticien::class);
        $repoMetier = $em->getRepository(Metier::class);

        $metier1 = $repoMetier->find(1);

        //liste de tous les praticiens
        $praticiens = $repoPraticien->findAll();

        $praticiensMetiers = [];

        foreach ($praticiens as $praticien) {
            $praticiensMetiers[] = [
                'praticien' => $praticien,
                'metiers' => $praticien->getMetiers()
            ];
        }

        //creation nouveau praticien
        $newPraticien = new Praticien();
        $newPraticien->setNom('Nouveau nom');
        $newPraticien->setPrenom('Nouveau Prenom');
        $newPraticien->setLienRdv(null);
        $newPraticien->addMetier($metier1);
        $em->persist($newPraticien);
        $em->flush();
        
        //delete praticien
        $praticien2 = $repoPraticien->find(2);
        if ($praticien2) {
            $em->remove($praticien2);
            $em->flush();
        }

        //edition praticien
        $praticien3 = $repoPraticien->find(3);
        $praticien3->setNom('Nouveau nom 3');
        $em->flush();

        $title = 'Praticien Test';

        return $this->render('test/praticien.html.twig', [
            'title' => $title,
            'praticiens' => $praticiens,
            'praticiensMetiers' => $praticiensMetiers,
        ]);
    }

    #[Route('/article', name: 'app_test_article')]
    public function article(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $articleRepository = $em->getRepository(Article::class);
        $tagRepository = $em->getRepository(Tag::class);

        // NEW : création d'un article
        $newArticle = new Article();
        $newArticle->setTitre('Nouveau article');
        $newArticle->setResume('Nouveau article');
        $newArticle->setContenu('Contenu de l\'article');

        $newArticle->addTag($tagRepository->find(1));

        $em->persist($newArticle);
        $em->flush();

        // SHOW : all articles
        $articles = $articleRepository->findAll();
        $articlesEditeur = $articleRepository->findByEditeurNotNull();

        $articlesEditeur = 

        // SHOW : one article
        $article1 = $articleRepository->find(1);

        // UPDATE : edit article
        $article1->setTitre('TestName');
        $em->flush();

        // DELETE : delete article
        $article2 = $articleRepository->find(2);
        if ($article2) {
            $em->remove($article2);
        }
        $em->flush();
    
        return $this->render('test/article.html.twig', [
            'controller_name' => 'TestController',
            'newArticle' => $newArticle,
            'articles' => $articles,
            'article1' => $article1,
            'article2' => $article2,
        ]);
    }

    #[Route('/editeur', name: 'app_test_editeur')]
    public function editeur(ManagerRegistry $doctrine): Response {

        $em = $doctrine->getManager();
        $editeurRepository = $em->getRepository(Editeur::class);
        // $userRepository = $em->getRepository(User::class);

        // NEW : création d'un editeur
        $newEditeur = new Editeur();
        $newEditeur->setNom('Jean-Michel');
        $newEditeur->setPrenom('La Frite');

        $newLastUser = new User();
        //* Si cette ligne n'est pas modifiée entre 2 rechargements du twig, elle essaie de créer un nouveau
        //* user qui a le même email que le précédent : erreur SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry
        $newLastUser->setEmail($this->$faker->email);
        $newLastUser->setPassword('123');
        $newLastUser->setEnabled(true);
        $newLastUser->setRoles(['ROLE_USER']);
        $newEditeur->setUser($newLastUser);
        $em->persist($newEditeur);
        $em->flush();

        // SHOW : all editeurs
        $editeurs = $editeurRepository->findAll();

        // SHOW : one editeur
        $editeur3 = $editeurRepository->find(3);

        // UPDATE : edit editeur
        $editeur2 = $editeurRepository->find(1);
        if ($editeur2) {
            $editeur2->setPrenom('Bidule');
        }
        $em->flush();

        // DELETE : delete editeur
        if ($editeur2) {
            $em->remove($editeur2);
        }
        $em->flush();


        return $this->render('test/editeur.html.twig', [
            'controller_name' => 'TestController',
            'editeurs' => $editeurs,
            'editeur3' => $editeur3,
            'editeur2' => $editeur2,
            'newEditeur' => $newEditeur,
        ]);
    }

    // #[Route('/user', name: 'app_test_user')]
    // public function user(ManagerRegistry $doctrine): Response {
        
    //     $em = $doctrine->getManager();
    //     $userRepository = $em->getRepository(User::class);

    //     // NEW : nouvel utilisateur
    //     $newUser = new User();
    //     //* newUser a le même email que le précédent : erreur SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry
    //     $newUser->setEmail('foobarressdssses@example.com');
    //     $newUser->setPassword('123');
    //     $newUser->setEnabled(true);
    //     $newUser->setRoles(['ROLE_USER']);
    //     $em->persist($newUser);
    //     $em->flush();

    //     // SHOW : all users
    //     $users = $userRepository->findAll();
    //     // SHOW : one user
    //     $user1 = $userRepository->find(1);

    //     // UPDATE : edit user
    //     $user2 = $userRepository->find(2);
    //     if ($user2) {
    //         $user2->setEmail('foobarbaz@example.com');
    //         $em->flush();
    //     }

    //     // DELETE : delete user
    //     if ($user2) {
    //         $em->remove($user2);
    //     }
    //     $em->flush();

    //     return $this->render('test/user.html.twig', [
    //         'controller_name' => 'TestController',
    //         'newUser' => $newUser,
    //         'users' => $users,
    //         'user1' => $user1,
    //         'user2' => $user2,
    //     ]);
    // }
}
