<?php declare(strict_types = 1);
/********************************
 * Created by ktroufleau.
 * Date: 18/05/2019
 * Time: 17:09
 ********************************/


namespace Anaxago\CoreBundle\Controller;

use Anaxago\CoreBundle\Entity\Project;
use Anaxago\CoreBundle\Entity\Interest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 * @Route ("/api")
 */
class ApiController extends Controller
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Rest\View()
     *
     * @Get("/projects")
     *
     * @param EntityManagerInterface
     */
    public function getProjectsAction()
    {
        $projects = $this->entityManager->getRepository(Project::class)->findAll();
        if (empty($projects)) {
            return View::create(['status' => 'KO','message' => 'Projects not found'], Response::HTTP_NOT_FOUND);
        }
        return $projects;
    }
    /**
     * @Rest\View()
     *
     * @Get("/projects/{id}")
     *
     * @param EntityManagerInterface
     * @param Request
     */
    public function getProjectAction(Request $request)
    {

        $project = $this->entityManager->getRepository(Project::class)->find($request->get('id'));
        if (empty($project)) {
            return View::create(['status' => 'KO','message' => 'Projects not found'], Response::HTTP_NOT_FOUND);
        }
        return $project;
    }

    /**
     * @Rest\View()
     *
     * @Get("/interests")
     *
     * @param EntityManagerInterface
     * @param Request
     */
    public function getInterestAction(Request $request)
    {

        $interest = $this->entityManager->getRepository(Interest::class)->getInterests($this->getUser()->getId());
        if (empty($interest)) {
            return View::create(['status' => 'KO', 'message' => 'Interests not found'], Response::HTTP_NOT_FOUND);
        }
        return $interest;
    }

    /**
     * @Rest\View()
     *
     * @POST("/interests")
     *
     * @param EntityManagerInterface
     * @param Request
     */
    public function postInterestAction(Request $request, EntityManagerInterface $entityManager)
    {
        $interest = new Interest();
        $username = $this->getUser();
        $project = $entityManager->getRepository(Project::class)->find($request->get('project_id'));

        $interest->setUsername($username);
        $interest->setProject($project);
        $interest->setAmount($request->get('amount'));

        $entityManager->persist($interest);
        $entityManager->flush();

        $entityManager->getRepository(Project::class)->putInvested($request->get('amount'),$request->get('project_id'));
        return View::create(['status' => 'OK', 'message' => 'Interests has been added'], Response::HTTP_ACCEPTED);
    }
}