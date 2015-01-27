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


    public function sendApprovalEmailMessage(UserInterface $user, array $params)
    {
        $url      = $this->router->generate('MesdUserBundle_registration_approve', array('token' => $user->getConfirmationToken()), true);
        $body     = $this->templating->render($params['template'], array(
            'user'        => $user,
            'approvalUrl' => $url
        ));

        $this->sendEmailMessage($params['from'], $params['to'], $params['subject'], $body);
    }


    public function sendConfirmationEmailMessage(UserInterface $user, array $params)
    {
        $url      = $this->router->generate('MesdUserBundle_registration_confirm', array('token' => $user->getConfirmationToken()), true);
        $body     = $this->templating->render($params['template'], array(
            'user' => $user,
            'confirmationUrl' =>  $url
        ));

        $this->sendEmailMessage($params['from'], $user->getEmail(), $params['subject'], $body);
    }


    public function sendPasswordResetEmailMessage(UserInterface $user, array $params)
    {
        $url      = $this->router->generate('MesdUserBundle_reset_new_password', array('token' => $user->getConfirmationToken()), true);
        $body     = $this->templating->render($params['template'], array(
            'user' => $user,
            'confirmationUrl' =>  $url
        ));

        $this->sendEmailMessage($params['from'], $user->getEmail(), $params['subject'], $body);
    }


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