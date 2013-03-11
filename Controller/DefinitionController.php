<?php

namespace Padam87\AttributeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Padam87\AttributeBundle\Entity\Definition;
use Padam87\AttributeBundle\Form\DefinitionType as DefinitionForm;
use Padam87\AttributeBundle\Form\DefinitionListType as DefinitionListForm;

/**
 * @Route("/attribute-definition")
 */
class DefinitionController extends Controller
{
    /**
     * @Route("/{page}", defaults = { "page" = 1 }, requirements = { "page" = "\d+" })
     * @Template()
     */
    public function indexAction($page = 1)
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $Definition = new Definition();

        $form = $this->get('form.factory')->create(new DefinitionListForm(), $Definition);
        $form->bindRequest($this->get('request'));

        $qb = $this->get('search')
                ->createFilter($form->getData(), 'ad')
                ->createQueryBuilder('Padam87AttributeBundle:Definition');

        $pagination = $this->get('knp_paginator')->paginate(
            $qb->getQuery(),
            $page,
            10
        );

        return array(
            'pagination'	=> $pagination,
            'form'			=> $form->createView(),
        );
    }

    /**
     * @Route("/new")
     */
    public function newAction()
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $form = $this->get('form.factory')->create(new DefinitionForm(), new Definition());

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {

            $form->bindRequest($request);

            if ($form->isValid()) {
                $Definition = $form->getData();

                $this->_em->persist($Definition);
                $this->_em->flush();

                if (!$request->isXmlHttpRequest()) {
                    return $this->redirect($this->generateUrl('padam87_attribute_definition_index'));

                    $this->get('session')->setFlash('success', $this->get('translator')->trans('messages.save.successful'));
                }
            } elseif (!$request->isXmlHttpRequest()) {
                $this->get('session')->setFlash('error', $this->get('translator')->trans('messages.save.unsuccessful'));
            }
        }

        if ($request->isXmlHttpRequest()) {
            if ('POST' == $request->getMethod()) {
                return new \Symfony\Component\HttpFoundation\Response(json_encode(array(
                    'id' => $Definition->getId(),
                    'name' => $Definition->getName(),
                )));
            }
            
            return $this->render('Padam87AttributeBundle:Definition:new.ajax.twig', array(
                'form' => $form->createView(),
            ));
        }
        else {
            return $this->render('Padam87AttributeBundle:Definition:new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $Definition = $this->_em->find('Padam87AttributeBundle:Definition', $id);

        $form = $this->get('form.factory')->create(new DefinitionForm(), $Definition);

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {

            $form->bindRequest($request);

            if ($form->isValid()) {
                $Definition = $form->getData();

                $this->_em->persist($Definition);
                $this->_em->flush();

                $this->get('session')->setFlash('success', $this->get('translator')->trans('messages.save.successful'));

                return $this->redirect($this->generateUrl('padam87_attribute_definition_index'));
            } else {
                $this->get('session')->setFlash('error', $this->get('translator')->trans('messages.save.unsuccessful'));
            }
        }

        return array(
            'form' => $form->createView(),
            'Definition' => $Definition
        );
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $Definition = $this->_em->find('Padam87AttributeBundle:Definition', $id);

        $this->_em->remove($Definition);
        $this->_em->flush();

        $this->get('session')->setFlash('success', $this->get('translator')->trans('messages.delete.successful'));

        return $this->redirect($this->generateUrl('padam87_attribute_definition_index'));
    }
}
