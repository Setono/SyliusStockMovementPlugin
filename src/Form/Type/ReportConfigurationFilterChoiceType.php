<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\Type;

use function Safe\array_flip;
use Safe\Exceptions\ArrayException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ReportConfigurationFilterChoiceType extends AbstractType
{
    /** @var array */
    private $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @throws ArrayException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => array_flip($this->filters),
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_movement_report_configuration_filter_choice';
    }
}
