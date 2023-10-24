<?php

namespace App\Form;

use App\Entity\Metier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MetierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom * ',
                'help' => 'Saisissez le nom du métier',
                'attr' => [
                    'placeholder' => 'Saisissez le nom du métier',
                ],
                'purify_html' => true,
            ])
            ->add('description', null, [
                'label' => 'Description',
                'help' => 'Saisissez la description du métier',
                'attr' => [
                    'placeholder' => 'Saisissez la description du métier',
                ],
                'purify_html' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Metier::class,
        ]);
    }
}
