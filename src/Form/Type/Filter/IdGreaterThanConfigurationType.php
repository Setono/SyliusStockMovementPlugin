<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\Type\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

final class IdGreaterThanConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', IntegerType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_filter.id_greater_than_configuration.id',
                'attr' => [
                    'placeholder' => 'setono_sylius_stock_movement.form.report_configuration_filter.id_greater_than_configuration.id_placeholder',
                ],
                'required' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_movement_report_configuration_filter_id_greater_than_configuration';
    }
}
