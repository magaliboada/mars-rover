<?php

namespace App\Form;

use App\Entity\Rover;
use App\Model\Coordinate;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScenarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roverDirection', ChoiceType::class, [
                'choices' => [
                    'North' => 'N',
                    'East' => 'E',
                    'South' => 'S',
                    'West' => 'W',
                ],
                'label' => false,
                'required' => true,
                'help' => 'The direction of the rover.',
            ])
            ->add('roverPosition', CoordinateForm::class, [
                'label' => false,
                'required' => true,
            ])
            ->add('planetSize', IntegerType::class, [
                'label' => false,
                'required' => true,
                'help' => 'The size of the planet is the number of squares on the x and y axis.',
            ])
            ->add('planetObstacles', IntegerType::class
                , [
                    'label' => false,
                    'required' => false,
                    'help' => 'The number of obstacles on the planet. The obstacles are randomly placed on the planet.',
                ]
            )
            ->add('commands', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'w-full',
                ],
                'row_attr' => [
                    'class' => 'w-full flex items-end flex-col',
                ],
                'required' => false,
                'help' => 'The commands are the instructions to the rover. The rover will execute the commands in the order they are given.',

            ]);
    }
}
