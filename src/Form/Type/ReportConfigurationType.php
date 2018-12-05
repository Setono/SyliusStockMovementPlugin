<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

final class ReportConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('schedule')
            ->add('ftpHost')
            ->add('ftpUsername')
            ->add('ftpPassword')
            ->add('ftpPort')
            ->add('ftpPath')
            ->add('emailTo')
            ->add('emailCc')
            ->add('emailBcc')
            ->add('emailSubject')
            ->add('emailBody')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_report_configuration';
    }
}
