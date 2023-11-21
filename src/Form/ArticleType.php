<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Article;
use App\Entity\Editeur;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'label' => 'Titre de votre article * ',

                'help' => 'Veuillez entrer un titre pour votre article.',

                'attr' => ['placeholder' => 'Votre titre ici'],

                'invalid_message' => 'Veuillez entrer un titre.',
                'required' => true,
                'purify_html' => true,
            ])
            ->add('resume', null, [
                'label' => 'Message destiné à la page d\'accueil * ',

                'help' => 'Veuillez entrer dans le champ ci-contre une brève description du contenu de
                 l\'article, qui apparaîtra dans la banderole d\'actualités sur la page d\'accueil. 
                Exemple : si votre article contient une information sur l\'actualité du cabinet, résumez
                cette information ici.',

                'attr' => ['placeholder' => 'Votre message ici'],

                'invalid_message' => 'Veuillez entrer un message dans le champ ci-dessus.',
                'required' => true,
                'purify_html' => true,
            ])
            ->add('contenu', CKEditorType::class, [
                'label' => 'Votre Article * ',
                'label_attr' => ['class' => 'labelForm'],
                'help' => 'Veuillez entrer du contenu pour votre article.',
                'invalid_message' => 'Veuillez entrer du contenu pour votre article.',

                'required' => true,
                'purify_html' => true,
                
            ])
            ->add('imageFile', VichImageType::class, 
            ['required' => false,
            'download_uri' => false,
            'label' => 'Importer une image',
            'imagine_pattern' => 'webp_80'
            ])
            ->add('alt', null, [
                'label' => 'Description de l\'image',

                'help' => 'Veuillez entrer dans le champ ci-dessus une description de l\'image, 
                destinée aux utilisateurs qui ne peuvent pas la voir, comme les utilisateurs 
                d\'un lecteur d\'écran ou les utilisateurs qui naviguent sur un réseau bas débit.
                LAISSER VIDE SI L\'IMAGE EST PUREMENT DÉCORATIVE.',

                'attr' => ['placeholder' => 'Votre description ici'],
                'purify_html' => true,
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'checkbox',
                ],
                'label' => 'Catégorie(s) * ',
                'constraints' => [
                    new Assert\Count([
                    'min' => 1,
                    'minMessage' => 'Votre article doit contenir au moins {{ limit }} catégories',
                    ])
                    ],
                'by_reference' => false,
                
            ])
            ->add('editeurs', EntityType::class, [
                'class' => Editeur::class,
                'label' => 'Editeur(s) * ',
                'choice_label' => function ($editeur) {
                    return $editeur->getNom() . ' ' . $editeur->getPrenom();
                },
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'checkbox',
                ],
                'constraints' => [
                    new Assert\Count([
                        'min' => 1,
                        'minMessage' => 'Votre article doit avoir au moins {{ limit }} auteur',
                    ])
                    ],
                    'by_reference' => false,
            ])
            ;
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
