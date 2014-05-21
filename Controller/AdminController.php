<?php

namespace Heapstersoft\Base\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Security\Core\SecurityContext;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\SecurityExtraBundle\Annotation\SatisfiesParentSecurityPolicy;
use Heapstersoft\Base\AdminBundle\Controller\AdminController as Controller;
use Symfony\Component\HttpFoundation\Request;



/**
 * @Route("/admin")
 * 
 */
class AdminController extends Controller
{
    protected $bundleName = 'UserBundle';
    protected $entityName = 'User';
    protected $entityClass = 'Heapstersoft\Base\UserBundle\Entity\User';
    protected $formType = 'Heapstersoft\Base\UserBundle\Form\UserType';
    
    /**
     * @Route("/users", name="_admin_userbundle_index")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function listAction()
    {       
        return parent::indexAction();
    }
    
    /**
     * @Route("/users/new", name="_admin_userbundle_new")
     * @Secure(roles="ROLE_ADMIN")
     * @SatisfiesParentSecurityPolicy
     */
    public function newAction()
    {
        return parent::newAction();
    }
    
    /**
     * @Route("/users/create", name="_admin_userbundle_create")
     * @Secure(roles="ROLE_ADMIN")
     * @SatisfiesParentSecurityPolicy
     */
    public function createAction(Request $request)
    {
        return parent::createAction($request);
    }

    /**
     * @Route("/users/{id}/edit", name="_admin_userbundle_edit")
     * @Secure(roles="ROLE_ADMIN")
     * @SatisfiesParentSecurityPolicy
     */
    public function editAction($id)
    {
        return parent::editAction($id);
    }
    
    /**
     * @Route("/users/{id}/update", name="_admin_userbundle_update")
     * @Method({"POST"})
     * @Secure(roles="ROLE_ADMIN")
     * @SatisfiesParentSecurityPolicy
     */
    public function updateAction(Request $request, $id)
    {
        return parent::updateAction($request, $id);
    }
    
    /**
     * @Route("/users/{id}/delete", name="_admin_userbundle_delete")
     * @Secure(roles="ROLE_ADMIN")
     * @SatisfiesParentSecurityPolicy
     */
    public function deleteAction(Request $request, $id)
    {
        return parent::deleteAction($request, $id);
    }
    
    /**
     * @Route("/users/{id}/show", name="_admin_userbundle_show")
     * @Secure(roles="ROLE_ADMIN")
     * @SatisfiesParentSecurityPolicy
     */
    public function showAction($id)
    {
        return parent::showAction($id);
    }
    
    protected function setupListFields()
    {
        return array('id'=>'Id',
                     'username'=>'Username',
                     'name'=>'Name',
                     'email'=>'Email',
        );
    }
    
    protected function setupShowFields()
    {
        return array('id'=>'Id', 
                     'username'=>'Username',
                     'name'=>'Name',
                     'email'=>'Email',
        );
    }
}
