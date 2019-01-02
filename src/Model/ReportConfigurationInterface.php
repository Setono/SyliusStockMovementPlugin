<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Cron\CronExpression;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ReportConfigurationInterface extends ResourceInterface
{
    public const TYPE_STOCK_MOVEMENT = 'stock_movement';

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @return string|null
     */
    public function getType(): ?string;

    /**
     * @param string $type
     */
    public function setType(string $type): void;

    /**
     * @return CronExpression|null
     */
    public function getSchedule(): ?CronExpression;

    /**
     * @param CronExpression $schedule
     */
    public function setSchedule(CronExpression $schedule): void;

    /**
     * Returns the template identifier
     *
     * @return string
     */
    public function getTemplate(): ?string;

    /**
     * @param string $template
     */
    public function setTemplate(string $template): void;

    /**
     * @return string|null
     */
    public function getDataSource(): ?string;

    /**
     * @param string $dataSource
     */
    public function setDataSource(string $dataSource): void;

    /**
     * @return string
     */
    public function getFtpHost(): ?string;

    /**
     * @param string $ftpHost
     */
    public function setFtpHost(?string $ftpHost): void;

    /**
     * @return string
     */
    public function getFtpUsername(): ?string;

    /**
     * @param string $ftpUsername
     */
    public function setFtpUsername(?string $ftpUsername): void;

    /**
     * @return string
     */
    public function getFtpPassword(): ?string;

    /**
     * @param string $ftpPassword
     */
    public function setFtpPassword(?string $ftpPassword): void;

    /**
     * @return int
     */
    public function getFtpPort(): ?int;

    /**
     * @param int $ftpPort
     */
    public function setFtpPort(?int $ftpPort): void;

    /**
     * @return string
     */
    public function getFtpPath(): ?string;

    /**
     * @param string $ftpPath
     */
    public function setFtpPath(?string $ftpPath): void;

    /**
     * @return array
     */
    public function getEmailTo(): ?array;

    /**
     * @param array $emailTo
     */
    public function setEmailTo(array $emailTo): void;

    /**
     * @return string
     */
    public function getEmailSubject(): ?string;

    /**
     * @param string $emailSubject
     */
    public function setEmailSubject(?string $emailSubject): void;

    /**
     * @return string
     */
    public function getEmailBody(): ?string;

    /**
     * @param string $emailBody
     */
    public function setEmailBody(?string $emailBody): void;
}
