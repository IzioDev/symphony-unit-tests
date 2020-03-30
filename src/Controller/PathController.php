<?php

namespace App\Controller;

use App\Entity\Path;
use App\Entity\User;
use App\Form\PathType;
use App\Repository\LocationRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PathController extends AbstractController
{
    /**
     * @Route("/path/create", name="new_path")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param LocationRepository $locationRepository
     * @param UserRepository $userRepository
     * @return RedirectResponse|Response
     */
    public function create(Request $request, LocationRepository $locationRepository, UserRepository $userRepository)
    {

        // If there are no Location yet, let's redirect to the location creation.
        if (!$locationRepository->findAll())
        {
            return $this->redirectToRoute("new_location");
        }

        $path = new Path();
        $form = $this->createForm(PathType::class, $path);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Types saying it's typeof UserInterface but in the
            // user authenticator, it's the real User Entity type.
            $userInterface = $this->getUser();
            $path->setDriver($userInterface);
            $entityManager->persist($path);
            $entityManager->flush();
        }

        return $this->render('path/index.html.twig', [
            'createPathForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/path/search", name="search_path")
     */
    public function search()
    {
        $res = new Response("", 200);
        return $res;
    }
}
