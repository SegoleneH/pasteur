<?php

namespace App\Form;

use App\Entity\Mentions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;


class MentionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('mentionsLegale', CKEditorType::class, [
            'label' => 'Indiquez les mentions légales * ',
            'label_attr' => ['class' => 'labelForm'],
            'help' => 'Veuillez entrer ici l\'intégralité des mentions légales',
            'invalid_message' => 'Veuillez entrer les mentions légales avant de valider.',
            'required' => true,
            'purify_html' => true,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mentions::class,
        ]);
    }
}
