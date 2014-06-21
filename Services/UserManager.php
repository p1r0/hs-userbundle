<?php
/**
 * User: Tabaré Caorsi <tabare@heapstersoft.com>
 * Date: 6/21/14
 * Time: 4:00 PM
 */

namespace Heapstersoft\Base\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use Heapstersoft\Base\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class UserManager
{
    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactory
     */
    protected $encoderFactory;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityeManager;

    public function __construct(EncoderFactory $encoderFactory, EntityManager $em)
    {
        $this->encoderFactory = $encoderFactory;
        $this->entityeManager = $em;
    }

    public function saveUser(User $user)
    {
        $encoder = $this->encoderFactory->getEncoder($user);

        $plainPassword = trim($user->getPlainPassword());
        if (!empty($plainPassword)) {
            $user->setPassword($encoder->encodePassword($plainPassword, $user->getSalt()));
        }

        $this->entityeManager->persist($user);
        $this->entityeManager->flush();
    }
} 