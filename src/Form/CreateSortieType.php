<?php

namespace App\Form;

use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class CreateSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('datedebut',DateType::class,[
                'widget' => 'single_text',
                'label' => 'Date et heure de la sortie'
            ])
            ->add('duree')
            ->add('datecloture',DateType::class,[
                'widget' => 'single_text',
                'label' => 'Date limite d\'inscription'
            ])
            ->add('nbinscriptionsmax')
            ->add('descriptioninfos',CKEditorType::class,[
                'label' => 'Description et Info'
            ])

            ->add('lieu', EntityType::class, [
                'class'=> 'App\Entity\Lieu',
                'choice_label' => 'Ville',
                'placeholder' => 'Choisir une ville',
//              'expanded' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l');
                }
            ])

            ->add('lieu', EntityType::class, [
                'class'=> 'App\Entity\Lieu',
                'choice_label' => 'nom_lieu',
                'placeholder' => 'Choisir un lieu',
//              'expanded' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l');
                }
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
