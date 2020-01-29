<?php

namespace App\Controller;

use App\Entity\Glaze;
use App\Form\GlazeType;
use App\Repository\GlazeRepository;
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
 * Glaze controller.
 *
 * @Route("/glaze")
 */
class GlazeController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * Lists all Glaze entities.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/", name="glaze_index", methods={"GET"})
     * @Template()
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {
        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(Glaze::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();

        $glazes = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'glazes' => $glazes,
        );
    }

    /**
     * Typeahead API endpoint for Glaze entities.
     *
     * To make this work, add something like this to GlazeRepository:
     *
     * @param Request $request
     *
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/typeahead", name="glaze_typeahead", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, GlazeRepository $repo) {
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
     * Search for Glaze entities.
     *
     * To make this work, add a method like this one to the
     * App:Glaze repository. Replace the fieldName with
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
     * @Route("/search", name="glaze_search", methods={"GET"})
     * @Template()
     *
     * @return array
     */
    public function searchAction(Request $request, GlazeRepository $repo) {
        $q = $request->query->get('q');
        if ($q) {
            $query = $repo->searchQuery($q);
            $glazes = $this->paginator->paginate($query, $request->query->getInt('page', 1), 25);
        } else {
            $glazes = array();
        }

        return array(
            'results' => $glazes,
            'q' => $q,
        );
    }

    /**
     * Creates a new Glaze entity.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/new", name="glaze_new", methods={"GET","POST"})
     * @Template()
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $glaze = new Glaze();
        $form = $this->createForm(GlazeType::class, $glaze);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($glaze);
            $em->flush();

            $this->addFlash('success', 'The new glaze was created.');

            return $this->redirectToRoute('glaze_show', array('id' => $glaze->getId()));
        }

        return array(
            'glaze' => $glaze,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Glaze entity in a popup.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/new_popup", name="glaze_new_popup", methods={"GET","POST"})
     * @Template()
     */
    public function newPopupAction(Request $request, EntityManagerInterface $em) {
        return $this->newAction($request, $em);
    }

    /**
     * Finds and displays a Glaze entity.
     *
     * @param Glaze $glaze
     *
     * @return array
     *
     * @Route("/{id}", name="glaze_show", methods={"GET"})
     * @Template()
     */
    public function showAction(Glaze $glaze) {
        return array(
            'glaze' => $glaze,
        );
    }

    /**
     * Displays a form to edit an existing Glaze entity.
     *
     * @param Request $request
     * @param Glaze $glaze
     *
     * @return array|RedirectResponse
     *
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/edit", name="glaze_edit", methods={"GET","POST"})
     * @Template()
     */
    public function editAction(Request $request, Glaze $glaze, EntityManagerInterface $em) {
        $editForm = $this->createForm(GlazeType::class, $glaze);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();
            $this->addFlash('success', 'The glaze has been updated.');

            return $this->redirectToRoute('glaze_show', array('id' => $glaze->getId()));
        }

        return array(
            'glaze' => $glaze,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Glaze entity.
     *
     * @param Request $request
     * @param Glaze $glaze
     *
     * @return array|RedirectResponse
     *
     * @IsGranted("ROLE_CONTENT_ADMIN")
     * @Route("/{id}/delete", name="glaze_delete", methods={"GET"})
     */
    public function deleteAction(Request $request, Glaze $glaze, EntityManagerInterface $em) {
        $em->remove($glaze);
        $em->flush();
        $this->addFlash('success', 'The glaze was deleted.');

        return $this->redirectToRoute('glaze_index');
    }
}
