<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\ProfileController as BaseController;

class ProfileController extends BaseController
{
  public function __construct() {

  }

  public function showAction() {
    //Get the current request
    $request = $this->get("request_stack")->getCurrentRequest();

    $user = $this->getUser();
    if (!is_object($user) || !$user instanceof UserInterface) {
        throw new AccessDeniedException('This user does not have access to this section.');
    }

    //If ajax request is send to controller to take off a path from user profile
    if($request->isXmlHttpRequest()) {
      $em = $this->getDoctrine()->getManager();
      $pathRepository = $em->getRepository('CoreBundle:Path');
      $path = $pathRepository->find($request->get("itemToDelete"));

      $user->removePath($path);

      $em->flush();
    }

    return $this->render('@FOSUser/Profile/show.html.twig', array(
        'user' => $user,
    ));
  }
}
