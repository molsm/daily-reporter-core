<?php

namespace DailyReporter;

use DailyReporter\Api\Core\ReportInterface;
use DailyReporter\Api\MailerInterface;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Mailer implements MailerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ReportInterface $report
     * @return bool
     */
    public function send(ReportInterface $report): bool
    {
        $mail = new PHPMailer(true);

        try {
            // TODO: Implement verbosity level
            if (true) {
                $mail->SMTPDebug = 2;
            }

            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USERNAME');
            $mail->Password = getenv('SMTP_PASSWORD');
            $mail->Port = getenv('SMTP_PORT');

            $mail->setFrom(getenv('MAIL_FROM'), getenv('MAIL_FROM_FULL_NAME'));
            $mail->addAddress(getenv('MAIL_TO'));
            $mail->addReplyTo(getenv('MAIL_FROM'), getenv('MAIL_FROM_FULL_NAME'));

            $mail->isHTML(true);
            $mail->Subject = $report->getSubject();
            $mail->Body = $this->container->get('template')->render($report->getTemplate(), $report->getData());
            $mail->send();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}