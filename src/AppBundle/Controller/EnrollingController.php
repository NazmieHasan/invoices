<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Enrolling;
use AppBundle\Entity\Student;
use AppBundle\Form\EnrollingType;
use AppBundle\Service\Enrollings\EnrollingServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class EnrollingController extends Controller
{

    /**
     * @var EnrollingServiceInterface
     */
    private $enrollingService;

    public function __construct(
        EnrollingServiceInterface $enrollingService)
    {
        $this->enrollingService = $enrollingService;
    }

    /**
     * @Route("/create-enrolling", name="enrolling_create", methods={"GET"})
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        return $this->render('enrollings/create.html.twig',
            [
            'form' => $this
                ->createForm(EnrollingType::class)
                ->createView()
            ]);
    }

    /**
     * @Route("/create-enrolling", methods={"POST"})
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createProcess(Request $request)
    {
        $enrolling = new Enrolling();
        $form = $this->createForm(EnrollingType::class, $enrolling);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->enrollingService->save($enrolling);
            $this->addFlash("info", "Записването е успешно!");
            return $this->redirectToRoute("all_enrollings");
        }

        return $this->render('enrollings/create.html.twig',
            [
                'enrolling' => $enrolling,
                'form' => $form->createView()
            ]);
    }
    
    /**
     * @Route("/enrollings", name="all_enrollings")
     * @param Reguest $reguest
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function All(Request $request)
    {
        $enrollings = $this->enrollingService->getAll();
        
        $paginator = $this->get('knp_paginator');
                
        $pagination = $paginator->paginate(
        $enrollings, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        8 /*limit per page*/
        );
        
        return $this->render('enrollings/all.html.twig',
            [
                'pagination' => $pagination
            ]);
    }
    
    /**
     * @Route("/enrolling/{id}/view-invoice", name="view_invoice")
     * @param $id
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function view_invoice(Request $request, int $id)
    {
    
    $enrolling = $this->enrollingService->findOneById($id);
    
    if (null === $enrolling){
            return $this->redirectToRoute("invoices_index");
        }
    
    $options = new Options();
     
    $dompdf = new Dompdf($options);
    
    $html = $this->renderView('invoices/create.html.twig',
            [
                'enrolling' => $enrolling
            ]);        
   
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    $dompdf->stream("invoice-for-enrolling-$id.pdf", 
        [
            "Attachment" => false
        ]);
    }
    
    /**
     * @Route("/enrolling/{id}/download-invoice", name="download_invoice")
     * @param $id
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function download_invoice(Request $request, int $id)
    {
    
    $enrolling = $this->enrollingService->findOneById($id);
    
    if (null === $enrolling){
            return $this->redirectToRoute("invoices_index");
        }
    
    $options = new Options();
     
    $dompdf = new Dompdf($options);
    
    $html = $this->renderView('invoices/create.html.twig',
            [
                'enrolling' => $enrolling
            ]);        
   
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    $dompdf->stream("invoice-for-enrolling-$id.pdf", 
        [
            "Attachment" => true
        ]);
    }

}
