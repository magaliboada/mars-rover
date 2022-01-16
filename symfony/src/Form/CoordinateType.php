<?php

namespace App\Form;

use App\Model\Coordinate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoordinateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('x', IntegerType::class, [
                'row_attr' => [
                    'class' => 'coordinate w-min',
                ],
                'label' => false,
            ])
            ->add('y', IntegerType::class, [
                'row_attr' => [
                    'class' => 'coordinate w-min',
                ],
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Coordinate::class,
        ]);
    }
}