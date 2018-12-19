<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Form\Type;

use Setono\SyliusStockPlugin\Form\DataTransformer\EmailsToArrayTransformer;
use Setono\SyliusStockPlugin\Form\DataTransformer\UrlToHostTransformer;
use Setono\SyliusStockPlugin\Model\ReportConfigurationInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ReportConfigurationType extends AbstractResourceType
{
    /**
     * @var string[]
     */
    private $templateLabels;

    public function __construct(string $dataClass, array $templateLabels, $validationGroups = [])
    {
        parent::__construct($dataClass, $validationGroups);

        $this->templateLabels = $templateLabels;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'setono_sylius_stock.form.report_configuration.name',
                'attr' => [
                    'placeholder' => 'setono_sylius_stock.form.report_configuration.name_placeholder',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'setono_sylius_stock.form.report_configuration.type',
                'choices' => [
                    'Stock movement' => ReportConfigurationInterface::TYPE_STOCK_MOVEMENT,
                ],
            ])
            ->add('schedule', null, [
                'label' => 'setono_sylius_stock.form.report_configuration.schedule',
            ])
            ->add('template', ChoiceType::class, [
                'label' => 'setono_sylius_stock.form.report_configuration.template',
                'choices' => array_flip($this->templateLabels),
            ])
            ->add('ftpHost', null, [
                'label' => 'setono_sylius_stock.form.report_configuration.ftp_host',
                'required' => false,
            ])
            ->add('ftpUsername', null, [
                'label' => 'setono_sylius_stock.form.report_configuration.ftp_username',
                'required' => false,
            ])
            ->add('ftpPassword', null, [
                'label' => 'setono_sylius_stock.form.report_configuration.ftp_password',
                'required' => false,
            ])
            ->add('ftpPort', IntegerType::class, [
                'label' => 'setono_sylius_stock.form.report_configuration.ftp_port',
                'attr' => [
                    'placeholder' => 'setono_sylius_stock.form.report_configuration.ftp_port_placeholder',
                ],
                'required' => false,
            ])
            ->add('ftpPath', null, [
                'label' => 'setono_sylius_stock.form.report_configuration.ftp_path',
                'required' => false,
            ])
            ->add('emailTo', null, [
                'label' => 'setono_sylius_stock.form.report_configuration.email_to',
                'attr' => [
                    'placeholder' => 'setono_sylius_stock.form.report_configuration.email_placeholder',
                ],
                'required' => false,
            ])
            ->add('emailSubject', null, [
                'label' => 'setono_sylius_stock.form.report_configuration.email_subject',
                'attr' => [
                    'placeholder' => 'setono_sylius_stock.form.report_configuration.email_subject_body_placeholder',
                ],
                'required' => false,
            ])
            ->add('emailBody', null, [
                'label' => 'setono_sylius_stock.form.report_configuration.email_body',
                'attr' => [
                    'placeholder' => 'setono_sylius_stock.form.report_configuration.email_subject_body_placeholder',
                ],
                'required' => false,
            ])
        ;

        $builder->get('ftpHost')->addModelTransformer(new UrlToHostTransformer());
        $builder->get('emailTo')->addModelTransformer(new EmailsToArrayTransformer());
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'setono_sylius_stock_report_configuration';
    }
}
