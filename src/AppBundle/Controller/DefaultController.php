<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Service\Courses\CourseServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @var CourseServiceInterface
     */
    private $courseService;
    
    /**
     * CourseController constructor.
     * @param CourseServiceInterface $courseService
     */
    public function __construct(
        CourseServiceInterface $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * @Route("/", name="invoices_index")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Reguest $reguest
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function indexAction(Request $request)
    {
        $courses = $this->courseService->getAll();
        
        $paginator = $this->get('knp_paginator');
                
        $courses = $paginator->paginate(
        $courses, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        4 /*limit per page*/
        );
        
        return $this->render('default/index.html.twig',
            [
                'courses' => $courses
            ]);
    }
}
