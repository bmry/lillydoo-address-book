<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddressBookController extends Controller
{

    public function editAction(Request $request)
    {
        return $this->render('@App/AddressBook/edit.html.twig');
    }
}
