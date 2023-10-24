<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    // déclaration de la fonction hasher de mdp
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    // function isPasswordValid(PasswordAuthenticatedUserInterface $user, string $plainPassword): bool
    // {

    // }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $hasher = $this->hasher;

        $builder
            ->add('email', null, [
                'label' => 'Email * ',

                'help' => 'Entrez ici votre adresse email.',

                'attr' => ['placeholder' => 'Votre mail ici'],

                'invalid_message' => 'Veuillez entrer une adresse email.',
                'required' => true,
                'purify_html' => true,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => ['attr' => [
                        'class' => 'password-field',
                        'autocomplete' => 'new-password',
                        'purify_html' => true
                ]],
                'first_options' => ['label' => 'Mot de passe * '],
                'second_options' => ['label' => 'Confirmer le mot de passe * '],

                'help' => 'Entrez votre mot de passe dans les deux champs ci-contre.',
                
                'invalid_message' => 'Les deux mots de passe doivent être identiques.',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Assert\Length([
                        'min' => 6,
                        'max'=> 191,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                    ])
                    ],
                ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'Actif',
                'label_attr' => ['class' => 'enabled'],
                'required' => false,
                'data' => true,
                'attr' => ['class' => 'enabled'],
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($hasher) {
               
                $user = $event->getData();
                $oldPassword = $user->getPassword();
                $password = $this->hasher->hashPassword($user, $oldPassword);
                $user->setPassword($password);
                $event->setData($user);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
