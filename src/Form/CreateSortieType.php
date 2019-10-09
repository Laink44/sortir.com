<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CreateSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        $CPVILLE= $options['cpville'];
        dump( $CPVILLE);
        $builder
            ->add('nom',null,[
                'label'=> "Nom de la sortie"
            ])
            ->add('datedebut',DateTimeType::class,[
                'label'=>"Date de début",
                'widget' => 'single_text',
                'required' => false,
                'html5' => false,
                'attr' => [
                    'class' => 'datepicker-here' ,
                    'data-timepicker' =>"true",
                    "data-language" =>'fr',
                    'data-date-format'=>'yyyy-mm-dd'],
            ])
            ->add('duree',null,[
                'label'=>"Durée"
            ])
            ->add("datecloture",DateTimeType::class,[
                'label'=>"Date limite d'enregistrement",
                'widget' => 'single_text',
                'required' => false,
                'html5' => false,
                'attr' => [
                    'class' => 'datepicker-here' ,
                    'data-timepicker' =>"true",
                    "data-language" =>'fr',
                    'data-date-format'=>'yyyy-mm-dd'],

            ])

            ->add('nbinscriptionsmax',null,[
                'label'=>"Nombre de place",
            ])
            ->add('descriptioninfos',CKEditorType::class,[
                'label'=>"Description et infos",
                'config' => array(
                    'toolbar' => 'standard',
                    'basicEntities'=>false,
                    'resize_enabled' => false,
                    'entities'=>false,
                    'entities_additional'=>'#39',
                                                       ),

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
                 'choice_label' => 'nom_lieu',
                 'placeholder' => 'Choisir une lieu',
                 ])


           ->add('save',SubmitType::class,[
               'label'=>'Enregistrer'
           ])

           ->add('publish',SubmitType::class,[
                'label'=>'Publier une sortie'
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
