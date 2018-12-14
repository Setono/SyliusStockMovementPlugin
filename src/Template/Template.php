<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Template;

use Setono\SyliusStockPlugin\Model\ReportAwareInterface;
use Setono\SyliusStockPlugin\Model\ReportAwareTrait;
use Setono\SyliusStockPlugin\Model\ReportConfigurationAwareInterface;
use Setono\SyliusStockPlugin\Model\ReportConfigurationAwareTrait;

abstract class Template implements TemplateInterface, ReportAwareInterface, ReportConfigurationAwareInterface
{
    use ReportAwareTrait, ReportConfigurationAwareTrait;
}
