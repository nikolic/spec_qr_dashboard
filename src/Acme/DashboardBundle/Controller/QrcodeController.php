<?php

namespace Acme\DashboardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\DashboardBundle\Entity\Qrcode;
use Acme\DashboardBundle\Form\QrcodeType;

/**
 * Qrcode controller.
 *
 * @Route("/qrcode")
 */
class QrcodeController extends Controller
{

    /**
     * Lists all Qrcode entities.
     *
     * @Route("/", name="qrcode")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeDashboardBundle:Qrcode')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Qrcode entity.
     *
     * @Route("/", name="qrcode_create")
     * @Method("POST")
     * @Template("AcmeDashboardBundle:Qrcode:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Qrcode();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('qrcode_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Qrcode entity.
    *
    * @param Qrcode $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Qrcode $entity)
    {
        $form = $this->createForm(new QrcodeType(), $entity, array(
            'action' => $this->generateUrl('qrcode_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Qrcode entity.
     *
     * @Route("/new", name="qrcode_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Qrcode();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Qrcode entity.
     *
     * @Route("/{id}", name="qrcode_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeDashboardBundle:Qrcode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Qrcode entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Qrcode entity.
     *
     * @Route("/{id}/edit", name="qrcode_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeDashboardBundle:Qrcode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Qrcode entity.');
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
    * Creates a form to edit a Qrcode entity.
    *
    * @param Qrcode $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Qrcode $entity)
    {
        $form = $this->createForm(new QrcodeType(), $entity, array(
            'action' => $this->generateUrl('qrcode_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Qrcode entity.
     *
     * @Route("/{id}", name="qrcode_update")
     * @Method("PUT")
     * @Template("AcmeDashboardBundle:Qrcode:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeDashboardBundle:Qrcode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Qrcode entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('qrcode_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Qrcode entity.
     *
     * @Route("/{id}", name="qrcode_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeDashboardBundle:Qrcode')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Qrcode entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('qrcode'));
    }

    /**
     * Creates a form to delete a Qrcode entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('qrcode_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
