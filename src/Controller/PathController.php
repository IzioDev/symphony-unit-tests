<?php

namespace App\Controller;

use App\Entity\Path;
use App\Form\PathType;
use App\Form\PathSearchType;
use App\Repository\LocationRepository;
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
     * @return RedirectResponse|Response
     */
    public function create(Request $request, LocationRepository $locationRepository)
    {

        // If there are no Location yet, let's redirect to the location creation.
        if (!$locationRepository->findAll()) {
            return $this->redirectToRoute("new_location");
        }

        $path = new Path();
        $form = $this->createForm(PathType::class, $path);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $this->getUser();
            $path->setDriver($user);

            $entityManager->persist($path);
            $entityManager->flush();

            $this->addFlash('success', 'Trajet correctement enregistré.');
        }

        return $this->render('path/index.html.twig', [
            'createPathForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/path/search", name="search_path")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function search(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $path = new Path();
        $path->setStartTime(new \DateTime());
        $form = $this->createForm(PathSearchType::class, $path);
        $form->handleRequest($request);

        $paths = [];

        if ($form->isSubmitted()) {
            $paths = $em->getRepository(Path::class)->findForSearch($path);
        } else {
            $paths = $em->getRepository(Path::class)->findAll();
        }

        return $this->render('path/search.html.twig', [
            'form' => $form->createView(),
            'paths' => $paths
        ]);
    }
}
