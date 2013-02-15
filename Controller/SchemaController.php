<?php

namespace Padam87\AttributeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Padam87\SearchBundle\Filter\FilterFactory;

use Padam87\AttributeBundle\Entity\Schema;
use Padam87\AttributeBundle\Form\SchemaType as SchemaForm;
use Padam87\AttributeBundle\Form\SchemaListType as SchemaListForm;

/**
 * @Route("/attribute-schema")
 */
class SchemaController extends Controller
{
    /**
     * @Route("/{page}", defaults = { "page" = 1 }, requirements = { "page" = "[^new]" })
     * @Template()
     */
    public function indexAction($page = 1)
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $Schema = new Schema();

        $config = $this->container->getParameter('padam87_attribute');

        $form = $this->get('form.factory')->create(new SchemaListForm($config), $Schema);
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
     * @Route("/new")
     * @Template()
     */
    public function newAction()
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $form = $this->get('form.factory')->create(new SchemaForm($this->container->getParameter('padam87_attribute')), new Schema());

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {

            $form->bindRequest($request);

            if ($form->isValid()) {
                $Schema = $form->getData();
                $Schema->setUpdatedAt(new \DateTime());
                
                $this->_em->persist($Schema);
                $this->_em->flush();

                $this->get('session')->setFlash('success', $this->get('translator')->trans('messages.save.successful'));

                return $this->redirect($this->generateUrl('padam87_attribute_schema_index'));
            } else {
                $this->get('session')->setFlash('error', $this->get('translator')->trans('messages.save.unsuccessful'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $Schema = $this->_em->find('Padam87AttributeBundle:Schema', $id);

        $form = $this->get('form.factory')->create(new SchemaForm($this->container->getParameter('padam87_attribute')), $Schema);

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {

            $form->bindRequest($request);

            if ($form->isValid()) {
                $Schema = $form->getData();
                $Schema->setUpdatedAt(new \DateTime());

                $this->_em->persist($Schema);
                $this->_em->flush();

                $this->get('session')->setFlash('success', $this->get('translator')->trans('messages.save.successful'));

                return $this->redirect($this->generateUrl('padam87_attribute_schema_index'));
            } else {
                $this->get('session')->setFlash('error', $this->get('translator')->trans('messages.save.unsuccessful'));
            }
        }

        return array(
            'form' => $form->createView(),
            'Schema' => $Schema
        );
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $Schema = $this->_em->find('Padam87AttributeBundle:Schema', $id);

        $this->_em->remove($Schema);
        $this->_em->flush();

        $this->get('session')->setFlash('success', $this->get('translator')->trans('messages.delete.successful'));

        return $this->redirect($this->generateUrl('padam87_attribute_schema_index'));
    }
}
