<?php

namespace App\Form;

use App\Entity\OfferBook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class OfferBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('author')
            ->add('publishingHause')
            ->add('placeOfPublication')
            ->add('dateOfPublication',IntegerType::class,[
                'constraints' => [new Positive()],
                'attr' => [
                    'min' => 1
                ]
            ])
            ->add('page',IntegerType::class,[
                'constraints' => [new Positive()],
                'attr' => [
                    'min' => 1
                ]
            ])
            //->add('createdAt')
            ->add('description')
            //->add('isAccept')
            //->add('user')
            ->add('Add',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OfferBook::class,
        ]);
    }
}
