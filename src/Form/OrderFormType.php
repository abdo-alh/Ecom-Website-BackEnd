<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'First Name'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Last Name'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'user@email.com'
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Phone Number'
                ]
            ])
            ->add('postalCode', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Postal Code'
                ]
            ])
            ->add('firstAdress', TextType::class, [
                'label' => false,
                'required' => true
            ])
            ->add('secondAdress', TextType::class, [
                'label' => false,
                'required' => true
            ])
            ->add('city', EntityType::class, [
                'label' => false,
                'required' => true,
                'class' => City::class,
                'choice_label' => 'name',
            ])
            ->add('country', EntityType::class, [
                'label' => false,
                'required' => true,
                'class' => Country::class,
                'choice_label' => 'name'
            ])
            ->add('payment_method', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Cash On Delivery' => 'cod',
                    'Paypal' => 'paypal'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'csrf_protection' => true,
        ]);
    }
}
