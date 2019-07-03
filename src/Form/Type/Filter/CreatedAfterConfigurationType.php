<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\Type\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class CreatedAfterConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration_filter.created_after_configuration.date',
                'constraints' => [
                    new NotBlank([
                        'message' => 'setono_sylius_stock_movement.report_configuration_filter.created_after_configuration.date.not_blank',
                        'groups' => 'setono_sylius_stock_movement',
                    ]),
                ],
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_movement_report_configuration_filter_created_after_configuration';
    }
}
