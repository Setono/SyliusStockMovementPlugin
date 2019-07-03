<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\Type\Transport;

use Setono\SyliusStockMovementPlugin\Form\DataTransformer\UrlToHostTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class FtpConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('host', TextType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_transport.ftp_configuration.host',
                'constraints' => [
                    new NotBlank([
                        'message' => 'setono_sylius_stock_movement.report_configuration_transport.ftp_configuration.host.not_blank',
                        'groups' => 'setono_sylius_stock_movement',
                    ]),
                ],
            ])
            ->add('port', IntegerType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_transport.ftp_configuration.port',
                'attr' => [
                    'placeholder' => 'setono_sylius_stock_movement.form.report_configuration_transport.ftp_configuration.port_placeholder',
                ],
                'required' => false,
            ])
            ->add('username', TextType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_transport.ftp_configuration.username',
                'required' => false,
            ])
            ->add('password', TextType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_transport.ftp_configuration.password',
                'required' => false,
            ])
            ->add('path', TextType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_transport.ftp_configuration.path',
                'required' => false,
            ])
        ;

        $builder->get('host')->addModelTransformer(new UrlToHostTransformer());
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_movement_report_configuration_transport_ftp_configuration';
    }
}
