<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationFormType;
use App\Repository\LocationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    /**
     * @Route("/location/create", name="new_location")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param LocationRepository $locationRepository
     * @return Response
     */
    public function create(Request $request, LocationRepository $locationRepository)
    {
        $firstLocation = false;
        if (!$locationRepository->findAll())
        {
            $firstLocation = true;
        }

        $location = new Location();
        $form = $this->createForm(LocationFormType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($location);
            $entityManager->flush();
        }

        return $this->render('location/create.html.twig', [
            'firstLocation' => $firstLocation,
            'createLocationForm' => $form->createView()
        ]);
    }
}
