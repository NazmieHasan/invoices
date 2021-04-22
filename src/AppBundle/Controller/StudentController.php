<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use AppBundle\Entity\Enrolling;
use AppBundle\Form\StudentType;
use AppBundle\Service\Students\StudentServiceInterface;
use AppBundle\Service\Enrollings\EnrollingServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends Controller
{

    /**
     * @var StudentServiceInterface
     */
    private $studentService;
    
     /**
     * @var EnrollingServiceInterface
     */
    private $enrollingService;
    
    /**
     * StudentController constructor.
     * @param StudentServiceInterface $studentService
     * @param EnrollingServiceInterface $enrollingService
     */
    public function __construct(
        StudentServiceInterface $studentService,
        EnrollingServiceInterface $enrollingService)
    {
        $this->studentService = $studentService;
        $this->enrollingService = $enrollingService;
    }

    /**
     * @Route("/create-student", name="student_create", methods={"GET"})
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        return $this->render('students/create.html.twig',
            [
                'form' => $this
                    ->createForm(StudentType::class)
                    ->createView()
            ]);
    }

    /**
     * @Route("/create-student", methods={"POST"})
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createProcess(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        $this->uploadFile($form, $student);

        if(null !== $this
                ->studentService->findOneByPersonalNumber($form['personalNumber']->getData())) {
            $personalNumber = $this
                ->studentService->findOneByPersonalNumber($form['personalNumber']->getData())
                ->getPersonalNumber();

            $this->addFlash("errors", "ЕГН $personalNumber вече съществува!");
            return $this->render('students/create.html.twig',
                [
                    'form' => $form->createView()
                ]);
        }

        if ($form->isValid()) {
            $this->studentService->save($student);
            $this->addFlash("info", "Клиентът е създаден успешно!");
            return $this->redirectToRoute("all_students");
        }

        return $this->render('students/create.html.twig',
            [
                'student' => $student,
                'form' => $form->createView()
            ]);

    }
    
    /**
     * @Route("/student/{id}", name="student_view")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view(int $id)
    {
        $student = $this->studentService->findOneById($id);
        
        if (null === $student){
            return $this->redirectToRoute("invoices_index");
        }
        
        $enrollings = $this->enrollingService->getAllByStudentId($id);

        return $this->render("students/view.html.twig",
            [
                'student' => $student,
                'enrollings' => $enrollings
            ]);
    }
    
    
    /**
     * @Route("/students", name="all_students")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function All(Request $request)
    {
        $students = $this->studentService->getAll();
         
        if($request->isMethod("POST")) {  
        $personalNumber = $request->get('personalNumber');
        
        $em = $this->getDoctrine()->getManager();
        $students = $em->getRepository("AppBundle:Student")
                       ->findBy(
                           [
                               'personalNumber' => $personalNumber
                           ]);
        }
        
        $paginator = $this->get('knp_paginator');
                
        $students = $paginator->paginate(
        $students, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        6 /*limit per page*/
        );
            
        return $this->render('students/all.html.twig',
           [
               'students' => $students
           ]);     
    }

    /**
     * @Route("/student/edit/{id}", name="student_edit", methods={"GET"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(int $id)
    {
        $student = $this->studentService->findOneById($id);

        if (null === $student){
            return $this->redirectToRoute("invoices_index");
        }

        return $this->render("students/edit.html.twig",
            [
                'student' => $student,
                'form' =>$this
                    ->createForm(StudentType::class)
                    ->createView()
            ]);
    }

    /**
     * @Route("/student/edit/{id}", methods={"POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editProcess(Request $request, $id) 
    {

        $student = $this->studentService->findOneById($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        $this->uploadFile($form, $student);

        if ($form->isValid()) {
            $this->studentService->update($student);
            $this->addFlash("info", "Клиентът е редактиран успешно!");
            return $this->redirectToRoute("all_students");
        }

        $this->addFlash("errors", "Възникна грешка! Моля, опитайте отново!");
        return $this->render('students/edit.html.twig',
            [
                'student' => $student,
                'form' =>$this
                    ->createForm(StudentType::class)
                    ->createView()
            ]);
    }

    /**
     * @Route("/student/delete/{id}", name="student_delete")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteProcess(Request $request, int $id)
    {
        $student = $this->studentService->findOneById($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        $this->studentService->delete($student);
        $this->addFlash("info", "Клиентът е изтрит успешно!");
        return $this->redirectToRoute("all_students");
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @param Student $student
     */
    public function uploadFile(FormInterface $form, Student $student)
    {
        /** @var UploadedFile $file */
        $file = $form['image']->getData();
        
        if ($file !== null) {

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            if ($file) {
                $file->move(
                    $this->getParameter('students_directory'),
                    $fileName
                );
                $student->setImage($fileName);
            }
        }  
    }
     
}
