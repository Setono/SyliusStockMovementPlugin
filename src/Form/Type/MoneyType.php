<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\FormBuilderInterface;

final class MoneyType extends AbstractType
{
    private $baseCurrency;

    public function __construct(string $baseCurrency)
    {
        $this->baseCurrency = $baseCurrency;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('currency', CurrencyType::class, [
            'preferred_choices' => [ $this->baseCurrency ]
        ])->add('amount');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_money';
    }
}
