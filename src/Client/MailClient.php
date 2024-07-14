<?php

declare(strict_types=1);

namespace App\Client;

use App\Service\MailSenderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailClient implements MailSenderInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
    ) {
    }

    public function sendEmail(
        string $to,
        string $subject,
        string $text
    ): void {
        $email = (new Email())
            ->from('timmi129@xm-test.com')
            ->to($to)
            ->subject($subject)
            ->text($text);

        $this->mailer->send($email);
    }
}
