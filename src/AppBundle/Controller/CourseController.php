<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Entity\Enrolling;
use AppBundle\Form\CourseType;
use AppBundle\Service\Courses\CourseServiceInterface;
use AppBundle\Service\Enrollings\EnrollingServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends Controller
{

    /**
     * @var CourseServiceInterface
     */
    private $courseService;
    
    /**
     * @var EnrollingServiceInterface
     */
    private $enrollingService;

    /**
     * CourseController constructor.
     * @param CourseServiceInterface $courseService
     * @param EnrollingServiceInterface $enrollingService
     */
    public function __construct(
        CourseServiceInterface $courseService,
        EnrollingServiceInterface $enrollingService)
    {
        $this->courseService = $courseService;
        $this->enrollingService = $enrollingService;
    }

    /**
     * @Route("/create-course", name="course_create", methods={"GET"})
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        return $this->render('courses/create.html.twig',
            [
            'form' => $this
                ->createForm(CourseType::class)
                ->createView()
            ]);
    }

    /**
     * @Route("/create-course", methods={"POST"})
     * @param Request $request
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createProcess(Request $request)
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if(null !== $this
                ->courseService->findOneByTitle($form['title']->getData())) {
            $title = $this
                ->courseService->findOneByTitle($form['title']->getData())
                ->getTitle();

            $this->addFlash("errors", "Заглавието $title вече съществува!");
            return $this->render('courses/create.html.twig',
                [
                    'form' => $form->createView()
                ]);
        }

        if ($form->isValid()) {
            $this->courseService->save($course);
            $this->addFlash("info", "Курсът е създаден успешно!");
            return $this->redirectToRoute("invoices_index");
        }

        return $this->render('courses/create.html.twig',
            [
                'course' => $course,
                'form' => $form->createView()
            ]);

    }
    
    /**
     * @Route("/course/{id}", name="course_view")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view(int $id)
    {
        $course = $this->courseService->findOneById($id);

        if (null === $course){
            return $this->redirectToRoute("invoices_index");
        }
        
        $enrollings = $this->enrollingService->getAllByCourseId($id);

        return $this->render("courses/view.html.twig",
            [
                'course' => $course,
                'enrollings' => $enrollings
            ]);
    }

    /**
     * @Route("/course/edit/{id}", name="course_edit", methods={"GET"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(int $id)
    {
        $course = $this->courseService->findOneById($id);

        if (null === $course){
            return $this->redirectToRoute("invoices_index");
        }

        return $this->render("courses/edit.html.twig",
            [
                'course' => $course,
                'form' =>$this
                    ->createForm(CourseType::class)
                    ->createView()
            ]);
    }

    /**
     * @Route("/course/edit/{id}", methods={"POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editProcess(Request $request, $id) {

        $course = $this->courseService->findOneById($id);
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->courseService->update($course);
            $this->addFlash("info", "Курсът е редактиран успешно!");
            return $this->redirectToRoute("invoices_index");
        }

        $this->addFlash("errors", "Възникна грешка! Моля, опитайте отново!");
        return $this->render('courses/edit.html.twig',
            [
                'course' => $course,
                'form' =>$this
                    ->createForm(CourseType::class)
                    ->createView()
            ]);
    }

    /**
     * @Route("/course/delete/{id}", name="course_delete")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteProcess(Request $request, int $id)
    {
        $course = $this->courseService->findOneById($id);
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        $this->courseService->delete($course);
        $this->addFlash("info", "Курсът е изтрит успешно!");
        return $this->redirectToRoute("invoices_index");
    }
    
}
