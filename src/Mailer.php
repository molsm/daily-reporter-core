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
     */
    public function send(ReportInterface $report)
    {
        $mail = new PHPMailer(true);

        try {
            // TODO: Implement verbosity level
            if (false) {
                $mail->SMTPDebug = 2;
            }

            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USERNAME');
            $mail->Password = getenv('SMTP_PASSWORD');
            $mail->Port = getenv('SMTP_PORT');

            //Recipients
            $mail->setFrom(getenv('MAIL_FROM'), getenv('MAIL_FROM_FULL_NAME'));
            $mail->addAddress(getenv('MAIL_TO'));
            $mail->addReplyTo(getenv('MAIL_FROM'), getenv('MAIL_FROM_FULL_NAME'));

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Daily report';
            $mail->Body = $this->container->get('template')->render($report->getTemplate(), $report->getData());
            var_dump($mail->Body);
            $mail->send();

            echo 'Message has been sent';
        } catch (\Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}