<?php

namespace Heapstersoft\Base\UserBundle\Controller;

use Heapstersoft\Base\UserBundle\Entity\User;
use Heapstersoft\Base\UserBundle\Services\UserManager;
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
        $templateString = $this->resolveTemplateString('new');
        $routes = $this->getAllRoutes();
        $actionTitle = $this->getActionTitle('new', 'Creation');
        /** @var User $entity */
        $entity = new $this->entityClass();
        $form   = $this->createForm(new $this->formType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $entity->setRoles(array('ROLE_ADMIN'));
            /** @var UserManager $userManager */
            $userManager = $this->get('user_bundle.user.manager');
            $userManager->saveUser($entity);

            $this->get('session')->getFlashBag()->add('success', $this->trans("Created Sucessfully!"));

            return $this->redirect($this->generateUrl($routes['list_route'], array('id' => $entity->getId())));
        }

        return $this->render(
            $templateString,
            array('entity' => $entity,
                'form'   => $form->createView(),
                'action_title'=>$actionTitle)  +
            $routes
        );
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
        $templateString = $this->resolveTemplateString('edit');
        $routes = $this->getAllRoutes();
        $actionTitle = $this->getActionTitle('edit', 'Edition');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository($this->bundleName.':'.$this->entityName)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find '.$this->entityName.' entity.');
        }

        $editForm   = $this->createForm(new $this->formType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            /** @var UserManager $userManager */
            $userManager = $this->get('user_bundle.user.manager');
            $userManager->saveUser($entity);

            $this->get('session')->getFlashBag()->add('success', $this->trans("Your changes were saved!"));

            return $this->redirect($this->generateUrl($routes['edit_route'], array('id' => $id)));
        }


        return $this->render(
            $templateString,
            array('entity' => $entity,
                'form'   => $editForm->createView(),
                'action_title'=>$actionTitle) +
            $routes
        );
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
