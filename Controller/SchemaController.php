<?php

namespace Padam87\AttributeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Padam87\AttributeBundle\Entity\Schema;
use Padam87\AttributeBundle\Form;

/**
 * @Route("/attribute-schema")
 */
class SchemaController extends Controller
{
    /**
     * @Route("/{page}", defaults = { "page" = 1 }, requirements = { "page" = "\d+" })
     * @Template()
     */
    public function indexAction($page = 1)
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $schema = new Schema();

        $config = $this->container->getParameter('padam87_attribute');
        $max = count($config['schema']['class']);

        if ($max === 1) {
            $schema = $this->_em->getRepository('Padam87AttributeBundle:Schema')->findOneBy(array(

            ));

            if ($schema != null) {
                return $this->redirect($this->generateUrl('padam87_attribute_schema_edit', array(
                    'id' => $schema->getId()
                )));
            }
        }

        $form = $this->get('form.factory')->create(new Form\SchemaListType($config), $schema);
        $form->bindRequest($this->get('request'));

        $qb = $this->get('search')
                ->createFilter($form->getData(), 's')
                ->createQueryBuilder('Padam87AttributeBundle:Schema');

        $pagination = $this->get('knp_paginator')->paginate(
            $qb,
            $page,
            10
        );

        return array(
            'pagination'	=> $pagination,
            'form'			=> $form->createView(),
            'classmap'        => array_flip($config['schema']['class']),
        );
    }

    /**
     * @Route("/edit/{id}")
     */
    public function editAction($id)
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $schema = $this->_em->find('Padam87AttributeBundle:Schema', $id);

        $form = $this->get('form.factory')->create(new Form\SchemaType($this->container->getParameter('padam87_attribute')), $schema);
        $attributeForm = $this->get('form.factory')->create(new Form\AttributeType());
        $definitionForm = $this->get('form.factory')->create(new Form\DefinitionType());

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {

            $form->bindRequest($request);

            if ($form->isValid()) {
                $schema = $form->getData();

                $this->_em->persist($schema);
                $this->_em->flush();

                if (!$request->isXmlHttpRequest()) {
                    $this->get('session')->setFlash('success', $this->get('translator')->trans('messages.save.successful'));

                    return $this->redirect($this->generateUrl('padam87_attribute_schema_index'));
                }
            } else {
                if (!$request->isXmlHttpRequest()) {
                    $this->get('session')->setFlash('error', $this->get('translator')->trans('messages.save.unsuccessful'));
                }
            }
        }

        if ($request->isXmlHttpRequest()) {
            $this->_em->refresh($schema);

            $class = $schema->getClassName();

            $entity = $this->get('attribute.schema')->applyTo(new $class, $schema);

            $form = $this->get('form.factory')->create(new Form\PreviewType(), $entity);

            return $this->render('Padam87AttributeBundle:Schema:preview.html.twig', array(
                'form' => $form->createView(),
            ));
        }
        else {
            return $this->render('Padam87AttributeBundle:Schema:edit.html.twig', array(
                'form' => $form->createView(),
                'attributeForm' => $attributeForm->createView(),
                'definitionForm' => $definitionForm->createView(),
                'Schema' => $schema
            ));
        }
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $schema = $this->_em->find('Padam87AttributeBundle:Schema', $id);

        $this->_em->remove($schema);
        $this->_em->flush();

        $this->get('session')->setFlash('success', $this->get('translator')->trans('messages.delete.successful'));

        return $this->redirect($this->generateUrl('padam87_attribute_schema_index'));
    }
}
