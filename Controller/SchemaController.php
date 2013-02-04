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
     * @Route("/")
     * @Template()
     */
    public function indexAction($page = 1)
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $Schema = new Schema();

        $config = $this->container->getParameter('padam87_attribute');

        $form = $this->get('form.factory')->create(new SchemaListForm($config), $Schema);
        $form->bindRequest($this->get('request'));

        $filterFactory = new FilterFactory($this->getDoctrine()->getEntityManager());

        $pagination = $this->get('knp_paginator')->paginate(
            $filterFactory->create($form->getData(), 'p')->createQueryBuilder('Padam87AttributeBundle:Schema'),
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
