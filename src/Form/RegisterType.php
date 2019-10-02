<?php

namespace App\Form;

use App\Entity\Participant;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Pseudo',
                'attr' => [
                    'placeholder' => "votre pseudo"
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => "votre prénom"
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => "votre Nom"
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => "votre téléphone"
                ]
            ])
            ->add('mail', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Votre email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Vous n'avez pas saisi le même mot de passe",
                'first_options' => [
                    'label' => 'Mot de passe'

                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe'
                ]
            ])
            ->add('sitesNoSite', EntityType::class, [
                'class'=> 'App\Entity\Site',
                'choice_label' => 'nom_site',
                'placeholder' => 'Choisir une ville',
//              'expanded' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s');
                }
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
