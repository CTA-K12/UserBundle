<?php

namespace Mesd\UserBundle\Model;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;
use Mesd\UserBundle\Model\UserInterface;
use Mesd\UserBundle\Mailer\MailerInterface;

class Mailer
{
    protected $mailer;
    protected $router;
    protected $templating;

    public function __construct($mailer, RouterInterface $router, EngineInterface $templating)
    {
        $this->mailer     = $mailer;
        $this->router     = $router;
        $this->templating = $templating;
    }

    public function sendConfirmationEmailMessage(UserInterface $user, array $params)
    {
        $from     = $params['from'];
        $to       = $params['to'];
        $subject  = $params['subject'];
        $template = $params['template'];
        $url      = $this->router->generate('MesdUserBundle_registration_confirm', array('token' => $user->getConfirmationToken()), true);
        $body     = $this->templating->render($template, array(
            'user' => $user,
            'confirmationUrl' =>  $url
        ));

        $this->sendEmailMessage($from, $to, $subject, $body);
    }

/*    public function sendResettingEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['resetting.template'];
        $url = $this->router->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), true);
        $rendered = $this->templating->render($template, array(
            'user' => $user,
            'confirmationUrl' => $url
        ));
        $this->sendEmailMessage($rendered, $this->parameters['from_email']['resetting'], $user->getEmail());
    }
*/
    protected function sendEmailMessage($from, $to, $subject, $body)
    {
        $message = \Swift_Message::newInstance()
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body);

        $this->mailer->send($message);
    }
}