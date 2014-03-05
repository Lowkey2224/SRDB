<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 13.02.14
 * Time: 15:38
 */


use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;


class ResettingListener implements EventSubscriberInterface
{
    private $session;
    private $router;

    public function __construct($session, Router $router)
    {
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::RESETTING_RESET_SUCCESS => 'onResettingResetComplete',
        );
    }

    /**
     * Saves the current partner
     * @param FormEvent $event
     */
    public function onResettingResetComplete(FormEvent $event)
    {
        if (null === $response = $event->getResponse()) {
            $partnerId = $this->session->get('_partner');
            $url = $this->router->generate(
                'fos_user_profile_show',
                array('_partner' => $partnerId)
            );
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        }
    }


}