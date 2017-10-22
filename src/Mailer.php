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

    public function send(ReportInterface $report)
    {
        $mail = new PHPMailer(true);

        try {
            // TODO: Implement verbosity level
            if (false) {
                $mail->SMTPDebug = 2;
            }
                                            // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = getenv('SMTP_HOST');  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = getenv('SMTP_USERNAME');                 // SMTP username
            $mail->Password = getenv('SMTP_PASSWORD');                           // SMTP password
            $mail->Port = getenv('SMTP_PORT');                                    // TCP port to connect to

            //Recipients
            $mail->setFrom(getenv('MAIL_FROM'), getenv('MAIL_FROM_FULL_NAME'));
            $mail->addAddress(getenv('MAIL_TO'));
            $mail->addReplyTo(getenv('MAIL_FROM'), getenv('MAIL_FROM_FULL_NAME'));

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Daily report';
            $mail->Body    = $this->container->get('template')->render($report->getTemplate());
            $mail->send();

            echo 'Message has been sent';
        } catch (\Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}