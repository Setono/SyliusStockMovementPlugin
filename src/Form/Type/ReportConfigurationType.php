<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

final class ReportConfigurationType extends AbstractResourceType
{
    /**
     * @var string[]
     */
    private $templates;

    public function __construct(string $dataClass, array $templates, $validationGroups = [])
    {
        parent::__construct($dataClass, $validationGroups);

        $this->templates = $templates;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration.name',
                'attr' => [
                    'placeholder' => 'setono_sylius_stock_movement.form.report_configuration.name_placeholder',
                ],
            ])
            ->add('schedule', null, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration.schedule',
            ])
            ->add('template', ChoiceType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration.template',
                'choices' => array_flip($this->templates),
            ])
            ->add('transports', ReportConfigurationTransportCollectionType::class, [
                'label' => 'setono_sylius_stock_movement.form.report_configuration.transports',
                'button_add_label' => 'setono_sylius_stock_movement.form.report_configuration.add_transport',
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_movement_report_configuration';
    }
}
