<?php

namespace App\Form;

use App\Entity\User;

// use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
{
    // déclaration de la fonction hasher de mdp
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $hasher = $this->hasher;

        $builder
            ->add('email')
            // ->add('roles')

            // Ajout d'un champ pour le mot de passe
            ->add('password', RepeatedType::class, [
                'options' => ['attr' => [
                        'class' => 'password-field',
                        'autocomplete' => 'new-password'
                    ]
                ],
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'required' => true
            ])
            // Ajout d'un event listener pour lancer le hasher au submit
            // ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($hasher) {
            //     $user = $event->getData();
            //     $password = $user->getPassword();
            //     $hashedPassword = $hasher->hashPassword($user, $password);
            //     $user->setPassword($hashedPassword);
            //     $event->setData($user);
            // })
            //! Le MDP est modifié par le hasher, si un user veut modifier 
            //! son MDP, celui qu'il a créé n'apparaît pas dans le champ MDP
            //& il faut rendre accessible le MDP non hashé pour l'utilisateur
            ->add('enabled')
            // ->add('editeur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
