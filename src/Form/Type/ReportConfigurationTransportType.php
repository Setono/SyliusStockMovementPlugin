<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

final class ReportConfigurationTransportType extends AbstractConfigurableReportConfigurationElementType
{
    public function buildForm(FormBuilderInterface $builder, array $options = []): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('type', ReportConfigurationTransportChoiceType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_transport.type',
                'attr' => [
                    'data-form-collection' => 'update',
                ],
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_movement_report_configuration_transport';
    }
}
