<?php

namespace Heapstersoft\Base\UserBundle\EventListener;

use Heapstersoft\Base\AdminBundle\Event\ConfigureMenuEvent;

class ConfigureMenuListener
{
    /**
     * @param \Heapstersoft\Base\AdminBundle\Event\ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        $menu->addChild('Users')
             ->setAttribute('dropdown', true);
 
        $menu['Users']->addChild('List', array('route' => '_admin_userbundle_index'));
        $menu['Users']->addChild('New', array('route' => '_admin_userbundle_new'));
 
       
    }
}