<?php

namespace FrontBundle\Utils;

use Doctrine\ORM\EntityManager;
use AppBundle\Helpers\StringHelper;

class EmailManager
{
    protected $em;
    protected $container;
    protected $globalManager;
    protected $templating;

    public function __construct(EntityManager $em, $container, $templating)
    {
        $this->em = $em;
        $this->container = $container;
        $this->globalManager = new GlobalManager($em, $container);
        $this->templating = $templating;
    }

    /**
     *
     * Send email
     *
     * @param  array $params  Custom parameters
     * @return boolean $result
     */
    public function sendMail($params = array())
    {
        $result     = false;
        $preSubject = $this->container->get('translator')->trans('website_email_subject.label');
        $subject    = $preSubject . ': '. $params['from'];
        $template   = $this->templating->render('FrontBundle:Default:contact_email_template.html.twig', $params);
        $configs    = $this->globalManager->getGlobalConfigs();
        $toEmail    = $configs->getWsEmail();
        $message    = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom($params['from'])
                        ->setTo($toEmail)
                        ->setBody($template, 'text/html');

        $mailer = $this->container->get('mailer')->send($message);

        if ($mailer) {
            $result     = true;
        }

        return $result;
    }
}
