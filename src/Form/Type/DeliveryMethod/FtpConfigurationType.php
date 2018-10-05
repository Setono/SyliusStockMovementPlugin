<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Form\Type\DeliveryMethod;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class FtpConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('host', TextType::class, [
                'label' => 'setono_sylius_stock.form.delivery_method.ftp.host',
                'constraints' => [
                    new NotBlank(['groups' => ['sylius']]),
                ],
            ])
            ->add('port', IntegerType::class, [
                'label' => 'setono_sylius_stock.form.delivery_method.ftp.port',
                'data' => 21,
                'constraints' => [
                    new NotBlank(['groups' => ['sylius']]),
                    new GreaterThan(['value' => 0, 'groups' => ['sylius']]),
                ],
            ])
            ->add('username', TextType::class, [
                'label' => 'setono_sylius_stock.form.delivery_method.ftp.username',
                'constraints' => [
                    new NotBlank(['groups' => ['sylius']]),
                ],
            ])
            ->add('password', TextType::class, [
                'label' => 'setono_sylius_stock.form.delivery_method.ftp.password',
                'constraints' => [
                    new NotBlank(['groups' => ['sylius']]),
                ],
            ])
            ->add('path', TextType::class, [
                'label' => 'setono_sylius_stock.form.delivery_method.ftp.path',
                'data' => '/',
                'constraints' => [
                    new NotBlank(['groups' => ['sylius']]),
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'setono_sylius_stock_ftp_delivery_method_configuration';
    }
}
