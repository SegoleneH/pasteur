<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Editeur;
use App\Entity\Tag;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TestFixtures extends Fixture implements FixtureGroupInterface
{
    private $faker;
    private $hasher;
    private $manager;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = FakerFactory::create('fr_FR');
        $this->hasher = $hasher;
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadTags();
        $this->loadEditeurs();
        $this->loadArticles();
    }

    public function loadEditeurs(): void
    {
        $userRepository = $this->manager->getRepository(User::class);
        $users = $userRepository->findAll();
        $user1 = $userRepository->find(1);
        $user2 = $userRepository->find(2);
        $user3 = $userRepository->find(3);

        //données statiques

        $datas = [
            [
                'email' => 'foo.foo@example.com',
                'roles' => ['ROLE_USER'],
                'password' => '123',
                'enabled' => true,

                'nom' => 'George',
                'prenom' => 'Lucas',
                'user' => $user1,
            ],
            [
                'email' => 'bar.bar@example.com',
                'roles' => ['ROLE_USER'],
                'password' => '123',
                'enabled' => true,

                'nom' => 'Pierre',
                'prenom' => 'Lapin',
                'user' => $user2,
            ],
            [
                'email' => 'baz.baz@example.com',
                'roles' => ['ROLE_USER'],
                'password' => '123',
                'enabled' => false,

                'nom' => 'Jean',
                'prenom' => 'Petit',
                'user' => $user2,
            ]
        ];

        foreach ($datas as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $password = $this->hasher->hashPassword($user, $data['password']);
            $user->setPassword($password);
            $user->setRoles($data['roles']);
            $user->setEnabled($data['enabled']);

            $this->manager->persist($user);

            $editeur = new Editeur();
            $editeur->setNom($data['nom']);
            $editeur->setPrenom($data['prenom']);
            $editeur->setUser($user);

            $this->manager->persist($editeur);
        }
        $this->manager->flush();

        //données dynamiques

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($this->faker->unique()->safeEmail());
            $password = $this->hasher->hashPassword($user, '123');
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $user->setEnabled($this->faker->boolean());

            $this->manager->persist($user);

            $editeur = new Editeur();
            $editeur->setNom($this->faker->lastName());
            $editeur->setPrenom($this->faker->firstName());
            $editeur->setUser($user);

            $this->manager->persist($editeur);

        };
        $this->manager->flush();
    }

    public function loadTags(): void
    {
        $articleRepository = $this->manager->getRepository(Article::class);
        $articles=$articleRepository->findAll();
        $article1 = $articleRepository->find(1);
        $article2 = $articleRepository->find(2);
        $article3 = $articleRepository->find(3);

        //données statiques

        $datas = [
            [
                'nom' => 'Kinésithérapie', 
                'description' => 'Un service de soins de santé qui utiliseise les techniques du sport pour améliorer la santé de ses patients.',
                'articles' => $article1
            ],
            [
                'nom' => 'Sophrologie',
                'description' => 'Un service de soins de santé qui utiliseise les techniques de respiration et de relaxation pour améliorer la santé de ses patients.',
                'articles' => $article2
            ],
            [
                'nom' => 'Médecine Générale',
                'description' => 'la médecine générale est une forme de médecine',
                'articles' => $article1
            ]
        ];

        foreach ($datas as $data) {
            $tag = new Tag();
            $tag->setNom($data['nom']);
            $tag->setDescription($data['description']);
            $this->manager->persist($tag);
        }

        $this->manager->flush();

        //données dynamiques

        for ($i = 0; $i < 10; $i++) {
            $tag = new Tag();
            $tag->setNom($this->faker->words(2, true));
            $tag->setDescription($this->faker->text(100));

            $this->manager->persist($tag);
        }
        $this->manager->flush();
    }


    public function loadArticles(): void
    {

        $tagRepository = $this->manager->getRepository(Tag::class);
        $tags = $tagRepository->findAll();
        $tag1 = $tagRepository->find(1);
        $tag2 = $tagRepository->find(2);
        $tag3 = $tagRepository->find(3);

        $editeurRepository = $this->manager->getRepository(Editeur::class);
        $editeurs = $editeurRepository->findAll();
        $editeur1 = $editeurRepository->find(1);
        $editeur2 = $editeurRepository->find(2);
        $editeur3 = $editeurRepository->find(3);

        //données statiques

        $datas = [
            [
                'titre' => 'Article 1',
                'resume' => 'Lorem ipsum dolor sit amet',
                'contenu' => 'Lorem ipsum dolor sit amet',
                'editeur' => $editeur1,
                'tag' => [$tag1],
            ],
            [
                'titre' => 'Article 2',
                'resume' => 'Lorem ipsum dolor sit amet',
                'contenu' => 'Lorem ipsum dolor sit amet',
                'editeur' => $editeur2,
                'tag' => [$tag2],
            ],
            [
                'titre' => 'Article 3',
                'resume' => 'Lorem ipsum dolor sit amet',
                'contenu' => 'Lorem ipsum dolor sit amet',
                'editeur' => $editeur3,
                'tag' => [$tag3],
            ]
        ];

        foreach ($datas as $data) {
            $article = new Article();
            $article->setTitre($data['titre']);
            $article->setResume($data['resume']);
            $article->setContenu($data['contenu']);
            $article->addEditeur($data['editeur']);
            $article->addTag($data['tag'][0]);

            $this->manager->persist($article);
        }
        $this->manager->flush();

        //données dynamiques

        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitre($this->faker->words(2, true));
            $article->setResume($this->faker->text(100));
            $article->setContenu($this->faker->paragraphs(3, true));


            //*------------------------------METTRE PLUSIEURS TAGS DANS UN ARTICLE-------------------------------*/
            $nbrTags = random_int(1, 3);
            $shortList = $this->faker->randomElements($tags, $nbrTags);
            foreach ($shortList as $tag) {
                $article->addTag($tag);
            }
            $this->manager->persist($article);

            $nbrEditeurs = random_int(1, 3);
            $shortList = $this->faker->randomElements($editeurs, $nbrEditeurs);
            foreach ($shortList as $editeur) {
                $article->addEditeur($editeur);
            }
            $this->manager->persist($article);
        }
        $this->manager->flush();
    }

}