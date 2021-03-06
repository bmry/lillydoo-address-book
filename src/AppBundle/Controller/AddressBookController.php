<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AddressBook;
use AppBundle\Form\Type\AddressBookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddressBookController extends Controller
{

    public function editAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        if(null == $id){
            $addressBook = new AddressBook();
        }else{
            $addressBook = $em->getRepository('AppBundle:AddressBook')->findOneBy(['id' => $id]);
        }
        $form = $this->createForm(AddressBookType::class, $addressBook);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($addressBook);
            $em->flush();
            $translator = $this->get('translator');
            $message = $translator->trans('address.success.message');
            $this->addFlash('success', $message);
            return $this->redirect($this->generateUrl('app_address_book_list'));
        }

        return $this->loadEditPage($form, $addressBook);
    }

    public function listAction()
    {
        $addressRepo = $this->getDoctrine()->getManager()->getRepository('AppBundle:AddressBook');
        $addresses = $addressRepo->findAll(array(), array('createdAt' => 'desc'));

        return $this->render('@App/AddressBook/list.html.twig',array('addresses' => $addresses));

    }

    public function viewAction($id)
    {
        $addressRepo = $this->getDoctrine()->getManager()->getRepository('AppBundle:AddressBook');
        $address = $addressRepo->findOneBy(array('id' => $id));
        $response =$this->verifyRecordExist($address);
        if($response instanceof Response){
            return $response;
        }

        return $this->render('@App/AddressBook/view.html.twig',array('address' => $address));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $addressRepo = $em->getRepository('AppBundle:AddressBook');
        $address = $addressRepo->findOneBy(array('id' => $id));

        $response =$this->verifyRecordExist($address);
        if($response instanceof Response){
            exit;
            return $response;
        }
        $em->remove($address);
        $em->flush();

        $translator = $this->get('translator');
        $message = $translator->trans('address.delete.success.message');
        $this->addFlash('success', $message);
        return $this->redirect($this->generateUrl('app_address_book_list'));
    }


    protected function loadEditPage($form, AddressBook $addressBook){

        return $this->render('@App/AddressBook/edit.html.twig', array('form' => $form->createView(), 'object' =>$addressBook,));
    }

    private function verifyRecordExist(AddressBook $addressBook = null)
    {
        $response = null;
        $translator = $this->get('translator');
        $message = $translator->trans('address.error.record_not_found');
        if(!$addressBook){
            $this->addFlash('error',$message );
            $response = $this->redirect($this->generateUrl('app_address_book_list'));
        }
        return $response;
    }
}
