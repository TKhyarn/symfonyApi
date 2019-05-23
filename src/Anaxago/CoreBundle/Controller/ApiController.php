<?php declare(strict_types = 1);
/********************************
 * Created by ktroufleau.
 * Date: 18/05/2019
 * Time: 17:09
 ********************************/


namespace Anaxago\CoreBundle\Controller;

use Anaxago\CoreBundle\Entity\Project;
use Anaxago\CoreBundle\Entity\Interest;
use Anaxago\CoreBundle\Services\ApiManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\View;



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
    public function postInterestAction(Request $request, EntityManagerInterface $entityManager, ApiManager $apiManager)
    {
        $username = $this->getUser();
        $projectId = $request->get('project_id');
        $amount = $request->get('amount');
        return $apiManager->postInterest($entityManager, $projectId, $amount, $username);
    }
}