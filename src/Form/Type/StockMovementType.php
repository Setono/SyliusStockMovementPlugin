<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class StockMovementType extends AbstractResourceType
{
    /**
     * @var string
     */
    private $productVariantClass;

    public function __construct(string $dataClass, string $productVariantClass, $validationGroups = [])
    {
        parent::__construct($dataClass, $validationGroups);

        $this->productVariantClass = $productVariantClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // todo missing productVariant, price
        $builder
            ->add('quantity', IntegerType::class, [
                'label' => 'setono_sylius_stock.form.stock_movement.quantity',
            ])
            ->add('reference', TextType::class, [
                'label' => 'setono_sylius_stock.form.stock_movement.reference',
            ])
            ->add('productVariant', EntityType::class, [
                'label' => 'setono_sylius_stock.form.stock_movement.product_variant',
                'class' => $this->productVariantClass,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_stock_movement';
    }
}
