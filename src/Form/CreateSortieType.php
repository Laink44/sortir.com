<?php

namespace App\Form;

use App\Entity\Sortie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom' ,TextType::class,[
               // 'attr' => ['class' => "row"],
                'label' => 'Nom de la sortie'
            ])
            ->add('datedebut',null,[
                'label' => 'Date et heure de la sortie'
            ])
            ->add('nbinscriptionsmax',null,[
                'label' => "Nombre de place"
            ])
            ->add('duree',null,[
                'label' => "Durée"
            ])
            ->add('datecloture',null,[
            'label' => "Date limite d'inscription"
            ])

            ->add('descriptioninfos',null,[
                'label' => "Description et infos"
            ])
            //->add('etatsortie')
            //->add('urlphoto')
            //->add('organisateur')

            ->add('lieuxNoLieu', EntityType::class, [
                'class'=> 'App\Entity\Lieu',
                'placeholder' => 'Lieu',
//              'expanded' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('');
                }
            ])
            //->add('etatsNoEtat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
