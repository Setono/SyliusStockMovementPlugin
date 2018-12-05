<?php

declare(strict_types=1);

namespace Setono\SyliusStockPlugin\Model;

use Cron\CronExpression;

class ReportConfiguration implements ReportConfigurationInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var CronExpression
     */
    protected $schedule;

    /**
     * @var string
     */
    protected $ftpHost;

    /**
     * @var string
     */
    protected $ftpUsername;

    /**
     * @var string
     */
    protected $ftpPassword;

    /**
     * @var string
     */
    protected $ftpPort;

    /**
     * @var string
     */
    protected $ftpPath;

    /**
     * @var string
     */
    protected $emailTo;

    /**
     * @var string
     */
    protected $emailCc;

    /**
     * @var string
     */
    protected $emailBcc;

    /**
     * @var string
     */
    protected $emailSubject;

    /**
     * @var string
     */
    protected $emailBody;

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getSchedule(): ?CronExpression
    {
        return $this->schedule;
    }

    /**
     * {@inheritdoc}
     */
    public function setSchedule(CronExpression $schedule): void
    {
        $this->schedule = $schedule;
    }

    /**
     * {@inheritdoc}
     */
    public function getFtpHost(): ?string
    {
        return $this->ftpHost;
    }

    /**
     * {@inheritdoc}
     */
    public function setFtpHost(string $ftpHost): void
    {
        $this->ftpHost = $ftpHost;
    }

    /**
     * {@inheritdoc}
     */
    public function getFtpUsername(): ?string
    {
        return $this->ftpUsername;
    }

    /**
     * {@inheritdoc}
     */
    public function setFtpUsername(string $ftpUsername): void
    {
        $this->ftpUsername = $ftpUsername;
    }

    /**
     * {@inheritdoc}
     */
    public function getFtpPassword(): ?string
    {
        return $this->ftpPassword;
    }

    /**
     * {@inheritdoc}
     */
    public function setFtpPassword(string $ftpPassword): void
    {
        $this->ftpPassword = $ftpPassword;
    }

    /**
     * {@inheritdoc}
     */
    public function getFtpPort(): ?string
    {
        return $this->ftpPort;
    }

    /**
     * {@inheritdoc}
     */
    public function setFtpPort(string $ftpPort): void
    {
        $this->ftpPort = $ftpPort;
    }

    /**
     * {@inheritdoc}
     */
    public function getFtpPath(): ?string
    {
        return $this->ftpPath;
    }

    /**
     * {@inheritdoc}
     */
    public function setFtpPath(string $ftpPath): void
    {
        $this->ftpPath = $ftpPath;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailTo(): ?string
    {
        return $this->emailTo;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailTo(string $emailTo): void
    {
        $this->emailTo = $emailTo;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailCc(): ?string
    {
        return $this->emailCc;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailCc(string $emailCc): void
    {
        $this->emailCc = $emailCc;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailBcc(): ?string
    {
        return $this->emailBcc;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailBcc(string $emailBcc): void
    {
        $this->emailBcc = $emailBcc;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailSubject(): ?string
    {
        return $this->emailSubject;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailSubject(string $emailSubject): void
    {
        $this->emailSubject = $emailSubject;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailBody(): ?string
    {
        return $this->emailBody;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailBody(string $emailBody): void
    {
        $this->emailBody = $emailBody;
    }
}
