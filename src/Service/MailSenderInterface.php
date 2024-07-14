<?php

declare(strict_types=1);

namespace App\Service;

interface MailSenderInterface
{
    public function sendEmail(
        string $to,
        string $subject,
        string $text
    ): void;
}
