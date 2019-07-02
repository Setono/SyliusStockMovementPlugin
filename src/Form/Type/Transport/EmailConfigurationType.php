<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\Type\Transport;

use Setono\SyliusStockMovementPlugin\Form\DataTransformer\EmailsToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class EmailConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('to', TextType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_transport.email_configuration.to',
            ])
            ->add('cc', TextType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_transport.email_configuration.cc',
                'required' => false,
            ])
            ->add('bcc', TextType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_transport.email_configuration.bcc',
                'required' => false,
            ])
            ->add('subject', TextType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_transport.email_configuration.subject',
                'required' => false,
                'attr' => [
                    'placeholder' => 'setono_sylius_stock_movement.form.report_configuration_transport.email_configuration.email_subject_body_placeholder',
                ],
            ])
            ->add('body', TextareaType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_transport.email_configuration.body',
                'required' => false,
                'attr' => [
                    'placeholder' => 'setono_sylius_stock_movement.form.report_configuration_transport.email_configuration.email_subject_body_placeholder',
                ],
            ])
        ;

        foreach (['to', 'cc', 'bcc'] as $field) {
            $builder->get($field)->addModelTransformer(new EmailsToArrayTransformer());
        }
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_movement_report_configuration_transport_email_configuration';
    }
}
