<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $user = $em->getRepository(User::class)->find($this->getUser()->getId());
        
        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }
}
