<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

final class ReportConfigurationFilterCollectionType extends AbstractConfigurationCollectionType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('entry_type', ReportConfigurationFilterType::class);
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_movement_report_configuration_filter_collection';
    }
}
