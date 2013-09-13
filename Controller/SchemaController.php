<?php

namespace Padam87\AttributeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Padam87\AttributeBundle\Entity\Schema;
use Padam87\AttributeBundle\Form\SchemaType;

/**
* @Route("/attribute/schema")
*/
class SchemaController extends Controller
{
    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $schema = $em->find('Padam87AttributeBundle:Schema', $id);

        if ($schema === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new SchemaType(), $schema);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $schema = $form->getData();

                $em->persist($schema);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('Save successful!'));

                return $this->redirect($this->generateUrl('padam87_attribute_schema_edit', array(
                    'id' => $id
                )));
            } else {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('Save unsuccessful!'));
            }
        }

        return array(
            'form' => $form->createView(),
            'schema' => $schema
        );
    }
}