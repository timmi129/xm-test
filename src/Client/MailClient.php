<?php

declare(strict_types=1);

namespace App\Client;

use App\Service\MailSenderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Throwable;

class MailClient implements MailSenderInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger
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

        try {
            $this->mailer->send($email);
        } catch (Throwable $e) {
            $this->logger->error('Error on sending email: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
}
