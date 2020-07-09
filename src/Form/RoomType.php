<?php

namespace App\Form;

use App\Entity\Room;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeRoom',ChoiceType::class, [
                'choices'  => [
                    'Type de Chambre' =>null,
                    'Individuel' => 'Individuel',
                    'Double' => 'Double',]
            ])
            ->add('disponibilite',ChoiceType::class, [
                'choices'  => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',]
            ])
            ->add('building',EntityType::class,[
                'class' => 'App\Entity\Building',
                'choice_label'=>'name',
                'multiple'=>false,
                'expanded'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
