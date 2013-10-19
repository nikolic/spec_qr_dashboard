<?php

namespace Acme\DashboardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\DashboardBundle\Entity\Weight;
use Acme\DashboardBundle\Form\WeightType;

/**
 * Weight controller.
 *
 * @Route("/weight")
 */
class WeightController extends Controller
{

    /**
     * Lists all Weight entities.
     *
     * @Route("/", name="weight")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeDashboardBundle:Weight')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Weight entity.
     *
     * @Route("/", name="weight_create")
     * @Method("POST")
     * @Template("AcmeDashboardBundle:Weight:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Weight();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('weight_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Weight entity.
    *
    * @param Weight $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Weight $entity)
    {
        $form = $this->createForm(new WeightType(), $entity, array(
            'action' => $this->generateUrl('weight_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Weight entity.
     *
     * @Route("/new", name="weight_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Weight();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Weight entity.
     *
     * @Route("/{id}", name="weight_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeDashboardBundle:Weight')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Weight entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Weight entity.
     *
     * @Route("/{id}/edit", name="weight_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeDashboardBundle:Weight')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Weight entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Weight entity.
    *
    * @param Weight $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Weight $entity)
    {
        $form = $this->createForm(new WeightType(), $entity, array(
            'action' => $this->generateUrl('weight_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Weight entity.
     *
     * @Route("/{id}", name="weight_update")
     * @Method("PUT")
     * @Template("AcmeDashboardBundle:Weight:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeDashboardBundle:Weight')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Weight entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('weight_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Weight entity.
     *
     * @Route("/{id}", name="weight_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeDashboardBundle:Weight')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Weight entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('weight'));
    }

    /**
     * Creates a form to delete a Weight entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('weight_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
