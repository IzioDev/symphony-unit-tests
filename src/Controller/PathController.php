<?php

namespace App\Controller;

use App\Entity\Path;
use App\Form\PathType;
use App\Repository\LocationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PathController extends AbstractController {

    /**
     * @Route("/path/create", name="new_path")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param LocationRepository $locationRepository
     * @return RedirectResponse|Response
     */
    public function create(Request $request, LocationRepository $locationRepository) {

        // If there are no Location yet, let's redirect to the location creation.
        if (!$locationRepository->findAll()) {
            return $this->redirectToRoute("new_location");
        }

        $path = new Path();
        $form = $this->createForm(PathType::class, $path);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($path);
            $entityManager->flush();

            $this->addFlash('success', 'Trajet correctement enregistré.');
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', "Erreur lors de l'enregistrement.");
        }


        return $this->render('path/index.html.twig', [
                    'createPathForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/path/search", name="search_path")
     */
    public function search() {
        $res = new Response("", 200);
        return $res;
    }

}
