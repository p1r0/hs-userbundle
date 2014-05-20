<?php

namespace Heapstersoft\Base\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Heapstersoft\Base\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Description of LoadUsers
 *
 * @author Tabaré Caorsi <tabare@heapstersoft.com>
 */
class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    /**
     *
     * @var ContainerInterface 
     */
    private $container = null;
    
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user');
        $user->setEmail('info@heapstersoft.com');
        $user->setPassword($this->encodePassword($user, 'user'));
        $manager->persist($user);
        
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('tabare@heapstersoft.com');
        $admin->setPassword($this->encodePassword($admin, 'admin'));
        $admin->setRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);
        
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    private function encodePassword(User $user, $plainTextPassword)
    {
        $enconder = $this->container->get('security.encoder_factory')
                ->getEncoder($user);
        
        return $enconder->encodePassword($plainTextPassword, $user->getSalt());
    }
}

?>
