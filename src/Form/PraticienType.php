<?php

namespace App\Form;

use App\Entity\Metier;
use App\Entity\Praticien;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PraticienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom',
                'label_attr' => [ 'class' => 'labelForm'],
                'help' => 'Saisissez le nom du praticien',
                'help_attr' => [ 'class' => 'helpForm'],
                'attr' => [
                    'placeholder' => 'Saisissez le nom du praticien',
                ],
            ])
            ->add('prenom', null, [
                'label' => 'Prenom',
                'label_attr' => [ 'class' => 'labelForm'],
                'help' => 'Saisissez le prenom du praticien',
                'help_attr' => [ 'class' => 'helpForm'],
                'attr' => [
                    'placeholder' => 'Saisissez le prenom du praticien',
                ],
            ])
            ->add('lienRdv', null, [
                'label' => 'Lien de rdv',
                'label_attr' => [ 'class' => 'labelForm'],
                'help' => 'Saisissez le lien de prise de rdv du praticien (doctissimo). Si aucune valeur n\'est saisie, le numéro du standard sera utilisé.',
                'help_attr' => [ 'class' => 'helpForm'],
                'attr' => [
                    'placeholder' => 'Saisissez le lien de rdv du praticien',
                ],
            ])
            ->add('metiers', EntityType::class, [
                'class' => Metier::class,
                'multiple' => true,
                'required' => true,
                'expanded' =>true,
                'label' => 'Métiers',
                'label_attr' => [ 'class' => 'labelForm'],
                'help' => 'Indiquer au moins 1 métier pour le praticien',
                'help_attr' => [ 'class' => 'helpForm'],
                'invalid_message' => 'Veuillez indiquer au moins 1 métier',
            ])
            ->add('imageFile', VichImageType::class, 
            ['required' => false,
            'download_uri' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Praticien::class,
        ]);
    }
}
