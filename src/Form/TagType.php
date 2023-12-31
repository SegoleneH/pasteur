<?php

namespace App\Form;

use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'attr' => ['placeholder' => 'Le nom de votre catégorie '],
                'label' => 'Nom * ',

                'help' => 'Saisissez le nom de votre nouvelle catégorie',
                'purify_html' => true,
            ])
            ->add('description', null, [
                'attr' => ['placeholder' => 'Votre description ici'],
                'label' => 'Description',
                'help' => 'Saisissez une brève description de la catégorie à créer',
                'purify_html' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}
