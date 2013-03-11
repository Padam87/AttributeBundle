<?php

namespace Padam87\AttributeBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Padam87\AttributeBundle\Entity;
use Padam87\AttributeBundle\Form;

/**
 * @Route("/attribute-group")
 */
class GroupController extends Controller
{
    /**
     * @Route("/new/{schemaId}")
     * @Template()
     */
    public function newAction($schemaId)
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $schema = $this->_em->find('Padam87AttributeBundle:Schema', $schemaId);
        
        $group = new Entity\Group();
        $group->setSchema($schema);
        
        $form = $this->get('form.factory')->create(new Form\GroupType(), $group);

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {

            $form->bindRequest($request);

            if ($form->isValid()) {
                $group = $form->getData();

                $this->_em->persist($group);
                $this->_em->flush();

                return new Response(json_encode(array(
                    'id' => $group->getId(),
                    'name' => $group->getName()
                )));
            } else {
                $this->get('session')->setFlash('error', $this->get('translator')->trans('messages.save.unsuccessful'));
            }
        }

        return array(
            'form' => $form->createView(),
            'group' => $group
        );
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
        $this->_em = $this->getDoctrine()->getEntityManager();

        $group = $this->_em->find('Padam87AttributeBundle:Group', $id);

        $this->_em->remove($group);
        $this->_em->flush();

        return new Response(json_encode(array(
            'id' => $id,
        )));
    }
}
