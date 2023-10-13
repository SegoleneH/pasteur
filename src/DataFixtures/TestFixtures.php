<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Faq;
use App\Entity\Praticien;
use App\Entity\Metier;
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
        $this->loadFaqs();
        $this->loadMetiers();
        $this->loadPraticiens();
    }

    public function loadMetiers(): void
    {
        //données statiques
        $datas = [
            [
                'nom' => 'Metier 1',
                'description' => 'Description métier 1',
            ],
            [
                'nom' => 'Metier 2',
                'description' => 'Description métier 2',
            ],
            [
                'nom' => 'Metier 3',
                'description' => 'Description métier 3',
            ],
        ];
        foreach($datas as $data) {
            $metier = new Metier();
            $metier->setNom($data['nom']);
            $metier->setDescription($data['description']);
            $this->manager->persist($metier);
        }
        $this->manager->flush();
        
        //données dynamiques
        for ($i = 0; $i < 12; $i++) {
            $metier = new Metier();
            $metier->setNom($this->faker->word());
            $metier->setDescription($this->faker->sentence(4));
            $this->manager->persist($metier);
        }
        $this->manager->flush();
    }

    public function loadPraticiens(): void
    {
        $reposMetier = $this->manager->getRepository(Metier::class);
        $metiers = $reposMetier->findAll();
        $metier1 = $reposMetier->find(1);
        $metier2 = $reposMetier->find(2);
        $metier3 = $reposMetier->find(3);

        //données statiques
        $datas = [
            [
                'nom' => 'Babar',
                'prenom' => 'Mohamed',
                'lienRdv' => 'https://www.google.fr',
                'metiers' => [$metier1]
            ],
            [
                'nom' => 'Dumbo',
                'prenom' => 'Julien',
                'lienRdv' => 'https://www.yahoo.fr',
                'metiers' => [$metier2]

            ],
            [
                'nom' => 'Batman',
                'prenom' => 'Detective',
                'lienRdv' => null,
                'metiers' => [$metier3]
            ],
        ];

        foreach ($datas as $data) {
            $praticien = new Praticien();
            $praticien->setNom($data['nom']);
            $praticien->setPrenom($data['prenom']);
            $praticien->setLienRdv($data['lienRdv']);

            $praticien->addMetier($data['metiers'][0]);
            
            $this->manager->persist($praticien);
        }
        $this->manager->flush();

        //données dynamiques
        for ($i = 0; $i < 13; $i++) {
            $praticien = new Praticien();
            $praticien->setNom($this->faker->lastName());
            $praticien->setPrenom($this->faker->firstName());
            $praticien->setLienRdv($this->faker->optional(0.7)->url());

            $nbMetier = random_int(1, 3);
            $shortList = $this->faker->randomElements($metiers, $nbMetier);
            foreach ($shortList as $metier) {
                $praticien->addMetier($metier);
            }

            $this->manager->persist($praticien);
        }
        $this->manager->flush();
    }

    public function loadFaqs(): void
    {
        //données statiques
        $datas = [
            [
                'question' => 'Question 1',
                'reponse' => 'Réponse 1',
            ],
            [
                'question' => 'Question 2',
                'reponse' => 'Réponse 2',
            ],
        ];
        foreach($datas as $data) {
            $faq = new Faq();
            $faq->setQuestion($data['question']);
            $faq->setReponse($data['reponse']);
            $this->manager->persist($faq);
        }
        $this->manager->flush();
        
        //données dynamiques
        for ($i = 0; $i<5; $i++) {
            $faq = new Faq();
            $faq->setQuestion($this->faker->sentence(10));
            $faq->setReponse($this->faker->paragraph(3));
            $this->manager->persist($faq);
        }
        $this->manager->flush();
    }

}