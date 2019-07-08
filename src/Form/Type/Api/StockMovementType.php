<?php

declare(strict_types=1);

namespace Setono\SyliusStockMovementPlugin\Form\Type\Api;

use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Product\Repository\ProductVariantRepositoryInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class StockMovementType extends AbstractResourceType
{
    /** @var ProductVariantRepositoryInterface */
    private $variantRepository;

    public function __construct(
        string $dataClass,
        ProductVariantRepositoryInterface $variantRepository,
        $validationGroups = []
    ) {
        parent::__construct($dataClass, $validationGroups);

        $this->variantRepository = $variantRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'label' => 'setono_sylius_stock_movement.form.stock_movement.quantity',
            ])
            ->add('reference', TextType::class, [
                'label' => 'setono_sylius_stock_movement.form.stock_movement.reference',
            ])
            ->add('variant', TextType::class, [
                'label' => 'setono_sylius_stock_movement.form.stock_movement.variant',
                'invalid_message' => 'setono_sylius_stock_movement.stock_movement.variant_invalid',
            ])
        ;

        $builder->get('variant')->addModelTransformer(
            new ResourceToIdentifierTransformer($this->variantRepository, 'code')
        );
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_movement_api_stock_movement';
    }
}
