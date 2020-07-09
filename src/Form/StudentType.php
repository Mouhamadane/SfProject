<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Building;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fisrtName')
            ->add('lastName')
            ->add('email')
            ->add('telephone')
            ->add('dateNaissance')
            ->add('typeStudent',ChoiceType::class,[
                'choices'=>['Boursier Logé'=>'BL','boursier non logé'=>'BNL','Non Boursier'=>'NB',]
            ])
            ->add('bourse',ChoiceType::class,[
                'choices'=>['Bourse'=>null,'Bourse Entière'=>'40000','Demi Bourse'=>'20000']
            ])
            ->add('adresse')
            ->add('numRoom',EntityType::class,[
                'class' => 'App\Entity\Room',
                'choice_label'=>'matricule',
                'multiple'=>false,
                'expanded'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
