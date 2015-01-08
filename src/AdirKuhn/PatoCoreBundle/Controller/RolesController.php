<?php
namespace AdirKuhn\PatoCoreBundle\Controller;

use AdirKuhn\PatoCoreBundle\Entity\Roles;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class RolesController extends Controller
{
    private $permissions = array(
        'READ'   => 'R',
        'WRITE'  => 'W',
        'UPDATE' => 'U',
        'DELETE' => 'D',
        'ADMIN'  => 'A'
    );

    /**
     * List all resources to choose protect them or not
     *
     */
    public function protectResourcesAction(Request $request, $userId)
    {
        if ($userId == 0) {
            throw new ResourceNotFoundException();
        }

        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->find('PatoCoreBundle:User', $userId);

        if (!$user) {
            throw new ResourceNotFoundException();
        }

        //save or update roles
        if($request->isMethod('POST')) {

            $rolesToSave = array();
            $roles = array();
            //get roles from checkboxes
            if($request->request->get('roles')) {
                $roles = $request->request->get('roles');
            }

            //delete all roles from user
            foreach($user->getRolesEntities() as $r) {
                $em->remove($r);
            }
            $em->flush();

                               //entities  //roles
            foreach ($roles as $entityToProtect => $roleValues) {

                foreach($roleValues as $roleKey => $roleValue) {

                    $actualRoleKey = strtoupper($roleKey);
                    if (array_key_exists($actualRoleKey, $this->permissions)) {

                        $actualRole = new Roles();
                        $actualRole->setUser($user);
                        $actualRole->setEntity($entityToProtect);
                        $actualRole->setRole($this->permissions[$actualRoleKey]);

                        $rolesToSave[] = $actualRole;

                    } else {
                        continue;
                    }
                }
            }

            //save to db
            foreach($rolesToSave as $saveRole) {
                $em->persist($saveRole);
            }
            $em->flush();

            //reload user
            $em->refresh($user);
        }

        //get bundle list
        $bundles = $this->container->getParameter('kernel.bundles');

        //check if resource implements UserBundleSimpleSecurity interface
        $protectedResources = array();
        foreach($bundles as $key => $bundle) {

            if (in_array('AdirKuhn\PatoCoreBundle\Helper\ProtectedResourceInterface', class_implements($bundle)))
            {
                $protectedResources[$key] = $bundle;
            }
        }

        return $this->render('PatoCoreBundle:Roles:protectResources.html.twig', array(
            'protectedResources' => $protectedResources,
            'user' => $user
        ));
    }
}