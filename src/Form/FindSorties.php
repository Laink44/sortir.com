<?php

namespace App\Form;

use App\Dto\RequestFindSeries;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use function Sodium\add;

class FindSorties extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("site",EntityType::class, [
                'class'=> 'App\Entity\Site',
                'choice_label' => 'nom_site',
                'placeholder' => 'Choisir une ville',
//              'expanded' => true,
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s');
                }
            ])
            ->add('dateDebut',DateTimeType::class,[
                'widget' => 'single_text',
                'required' => false,
                'html5' => false,
                'attr' => [
                    'class' => 'datepicker-here' ,
                    'data-timepicker' =>"true",
                    "data-language" =>'fr',
                    'data-date-format'=>'yyyy-mm-dd'],
            ])
            ->add("dateFin",DateTimeType::class,[
                'widget' => 'single_text',
                'required' => false,
                'html5' => false,
                'attr' => [
                    'class' => 'datepicker-here' ,
                    'data-timepicker' =>"true",
                    "data-language" =>'fr',
                    'data-date-format'=>'yyyy-mm-dd'],
            ])
            ->add("keyword",TextType::class, array(
                'required' => false,
            ))
            ->add('ManagerFilter',CheckboxType ::class, array(
                'required' => false,
                'label' => 'Sorties dont je suis l\'organisateur/trice'
            ))
            ->add('RegisterFilter',CheckboxType ::class, array(
                'required' => false,
                'label' => 'Sorties auxquelles je suis inscrit/e'
            ))
            ->add('NotRegisterFilter',CheckboxType ::class, array(
                'required' => false,
                'label' => 'Sorties auxquelles je suis ne pas inscrit/e'
            ))
            ->add('OutDatedFilter',CheckboxType ::class, array(
                'required' => false,
                'label' => 'Sorties passées'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RequestFindSeries::class,
        ]);
    }
}
