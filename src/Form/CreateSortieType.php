<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class CreateSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        $CPVILLE= $options['cpville'];
        dump( $CPVILLE);
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
                'config' => array(
                    'toolbar' => 'standard',
                                   ),
                'label' => 'Description et Info'
            ])


            ->add('ville', EntityType::class, [

                'class'=> 'App\Entity\Ville',
                'choice_label' => 'nom_ville',
                'placeholder' => 'Choisir une ville',
                'mapped'=>false,
               'query_builder'=>function(EntityRepository $er) use ($CPVILLE) {
                return $er->createQueryBuilder('v')->where('v.codePostal like :cp')->setParameter('cp',$CPVILLE)->groupBy('v.nomVille');
                }
            ])



          ->add('lieu', EntityType::class, [
                'class'=> 'App\Entity\Lieu',
                 'disabled'=>true,
                 'choice_label' => 'nom_lieu',
                 'placeholder' => 'Choisir une lieu',
                 ])

        ->add('rue',EntityType::class,[
                'class'=>'App\Entity\Lieu',
                'disabled'=>true,
                'choice_value'=>'rue',
                'mapped'=>false,
                'required'=>false,
                ]);









     }




    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
            'cpville'=> 0,




        ]);

    }




}
