<?php

namespace AdirKuhn\PatoCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * Search
     *
     * @return \Symfony\Component\HttpFoundation\Response HomePage
     */
    public function searchAction(Request $request)
    {

        $searchText = $request->query->get('searchText');

        $em = $this->getDoctrine()->getManager();

        $contacts = $em->getRepository('ClientsBundle:Contact')->findContactByName($searchText);

        $paginator  = $this->get('knp_paginator');
        $paginator->setDefaultPaginatorOptions(array('pageParameterName' => 'pageContacts'));
        $contactsPagination = $paginator->paginate(
            $contacts,
            $request->query->get('pageContacts', 1) /*page number*/,
            25 /*limit per page*/
        );

        $companies = $em->getRepository('ClientsBundle:Company')->findCompanyByName($searchText);

        $paginatorCompany  = $this->get('knp_paginator');
        $paginatorCompany->setDefaultPaginatorOptions(array('pageParameterName' => 'pageCompanies'));
        $companiesPagination = $paginatorCompany->paginate(
            $companies,
            $request->query->get('pageCompanies', 1),
            25
        );

        return $this->render('PatoCoreBundle:Default:search.html.twig', [
            'contactsPagination' => $contactsPagination,
            'companiesPagination' => $companiesPagination
        ]);
    }
}
