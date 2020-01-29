<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Location controller.
 *
 * @Route("/location")
 */
class LocationController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * Lists all Location entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="location_index", methods={"GET"})
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(Location::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();

        $locations = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'locations' => $locations,
        );
    }

    /**
     * Typeahead API endpoint for Location entities.
     *
     * To make this work, add something like this to LocationRepository:
     *
     * @param Request $request
     *
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/typeahead", name="location_typeahead", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, LocationRepository $repo) {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse(array());
        }
        $data = array();
        foreach ($repo->typeaheadQuery($q) as $result) {
            $data[] = array(
                'id' => $result->getId(),
                'text' => (string) $result,
            );
        }

        return new JsonResponse($data);
    }

    /**
     * Search for Location entities.
     *
     * To make this work, add a method like this one to the
     * App:Location repository. Replace the fieldName with
     * something appropriate, and adjust the generated search.html.twig
     * template.
     *
     * <code><pre>
     *    public function searchQuery($q) {
     *       $qb = $this->createQueryBuilder('e');
     *       $qb->addSelect("MATCH (e.title) AGAINST(:q BOOLEAN) as HIDDEN score");
     *       $qb->orderBy('score', 'DESC');
     *       $qb->setParameter('q', $q);
     *       return $qb->getQuery();
     *    }
     * </pre></code>
     *
     * @param Request $request
     *
     * @Route("/search", name="location_search", methods={"GET"})
     * @Template()
     *
     * @return array
     */
    public function searchAction(Request $request, EntityManagerInterface $em) {
        $repo = $em->getRepository(Location::class);
        $q = $request->query->get('q');
        if ($q) {
            $query = $repo->searchQuery($q);

            $locations = $this->paginator->paginate($query, $request->query->getInt('page', 1), 25);
        } else {
            $locations = array();
        }

        return array(
            'results' => $locations,
            'q' => $q,
        );
    }

    /**
     * Creates a new Location entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/new", name="location_new", methods={"GET","POST"})
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($location);
            $em->flush();

            $this->addFlash('success', 'The new location was created.');

            return $this->redirectToRoute('location_show', array('id' => $location->getId()));
        }

        return array(
            'location' => $location,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Location entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/new_popup", name="location_new_popup", methods={"GET","POST"})
     * @Template()
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a Location entity.
     *
     * @param Location $location
     *
     * @return array
     *
     * @Route("/{id}", name="location_show", methods={"GET"})
     * @Template()
     */
    public function showAction(Location $location) {
        return array(
            'location' => $location,
        );
    }

    /**
     * Displays a form to edit an existing Location entity.
     *
     * @param Request $request
     * @param Location $location
     *
     * @return array|RedirectResponse
     *
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="location_edit", methods={"GET","POST"})
     * @Template()
     */
    public function editAction(Request $request, Location $location, EntityManagerInterface $em) {
        $editForm = $this->createForm(LocationType::class, $location);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();
            $this->addFlash('success', 'The location has been updated.');

            return $this->redirectToRoute('location_show', array('id' => $location->getId()));
        }

        return array(
            'location' => $location,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Location entity.
     *
     * @param Request $request
     * @param Location $location
     *
     * @return array|RedirectResponse
     *
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/delete", name="location_delete", methods={"GET"})
     */
    public function deleteAction(Request $request, Location $location, EntityManagerInterface $em) {
        $em->remove($location);
        $em->flush();
        $this->addFlash('success', 'The location was deleted.');

        return $this->redirectToRoute('location_index');
    }
}
