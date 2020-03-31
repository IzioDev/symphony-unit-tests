<?php

namespace App\Controller;

use App\Entity\Path;
use App\Entity\User;
use App\Form\PathType;
use App\Form\PathSearchType;
use App\Repository\LocationRepository;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
     * @throws Exception
     */
    public function search(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $path = new Path();
        $path->setStartTime(new \DateTime());
        $path->setSeats(1);
        $form = $this->createForm(PathSearchType::class, $path);
        $form->handleRequest($request);

        $paths = $em->getRepository(Path::class)->findForSearch($path);

        return $this->render('path/search.html.twig', [
                    'form' => $form->createView(),
                    'paths' => $paths
        ]);
    }

    /**
     * @Route("/path/{id}/book", name="book_path")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param Path path
     * @return RedirectResponse|Response
     */
    public function book(Request $request, Path $path) {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->find($this->getUser()->getId());

        $path->addPassenger($user);

        $em->persist($path);
        $em->flush();

        return $this->redirect($this->generateUrl('account'));
    }

    /**
     * @Route("/path/{id}/show", name="show_path")
     * @param Request $request
     * @param Path $path
     * @return RedirectResponse|Response
     */
    public function show(Request $request, Path $path) {

        return $this->render('path/show.html.twig', [
                    'path' => $path
        ]);
    }

}
