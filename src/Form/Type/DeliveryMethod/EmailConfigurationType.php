<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Form\Type\DeliveryMethod;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class EmailConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('to', TextType::class, [
                'label' => 'setono_sylius_stock.form.delivery_method.email.to',
                'constraints' => [
                    new NotBlank(['groups' => ['sylius']]),
                ],
            ])
            ->add('cc', TextType::class, [
                'label' => 'setono_sylius_stock.form.delivery_method.email.cc',
                'required' => false,
            ])
            ->add('bcc', TextType::class, [
                'label' => 'setono_sylius_stock.form.delivery_method.email.bcc',
                'required' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'setono_sylius_stock_email_delivery_method_configuration';
    }
}
