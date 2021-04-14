<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Enrolling;
use AppBundle\Entity\Course;
use AppBundle\Entity\Student;
use AppBundle\Form\EnrollingType;
use AppBundle\Service\Enrollings\EnrollingServiceInterface;
use AppBundle\Service\Courses\CourseServiceInterface;
use AppBundle\Service\Students\StudentServiceInterface;
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
    
    /**
     * @var CourseServiceInterface
     */
    private $courseService;
    
    /**
     * @var StudentServiceInterface
     */
    private $studentService;

    /**
     * EnrollingController constructor.
     * @param EnrollingServiceInterface $enrollingService
     * @param CourseServiceInterface $courseService
     * @param StudentServiceInterface $studentService
     */
    public function __construct(
        EnrollingServiceInterface $enrollingService,
        CourseServiceInterface $courseService,
        StudentServiceInterface $studentService)
    {
        $this->enrollingService = $enrollingService;
        $this->courseService = $courseService;
        $this->studentService = $studentService;
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
                
        $enrollings = $paginator->paginate(
        $enrollings, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        8 /*limit per page*/
        );
        
        $courses = $this->courseService->getAll();
        $students = $this->studentService->getAll();
        
        return $this->render('enrollings/all.html.twig',
            [
                'enrollings' => $enrollings,
                'courses' => $courses,
                'students'=> $students
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
    
    
    /**
     * @Route("/enrolling/delete/{id}", name="delete_invoice")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteProcess(Request $request, int $id)
    {
        $enrolling = $this->enrollingService->findOneById($id);
        $form = $this->createForm(EnrollingType::class, $enrolling);
        $form->handleRequest($request);
        $this->enrollingService->delete($enrolling);
        $this->addFlash("info", "Фактурата е изтрита успешно!");
        return $this->redirectToRoute("all_enrollings");
    }
    

}
