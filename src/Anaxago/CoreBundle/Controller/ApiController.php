<?php declare(strict_types = 1);
/********************************
 * Created by ktroufleau.
 * Date: 18/05/2019
 * Time: 17:09
 ********************************/


namespace Anaxago\CoreBundle\Controller;

use Anaxago\CoreBundle\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class ApiController
 * @Route ("/api")
 */

class ApiController extends Controller
{
    /**
     * @Rest\View()
     * @Get("/projects")
     */
    public function getProjectsAction(Request $request, EntityManagerInterface $entityManager)
    {
        $projects = $entityManager->getRepository(Project::class)->findAll();
        if (empty($projects)) {
            return new JsonResponse(['message' => 'Projects not found'], Response::HTTP_NOT_FOUND);
        }
        $view = View::create($projects);
        $view->setFormat('json');
        return $view;
    }
    /**
     * @Rest\View()
     * @Get("/projects/{id}")
     */
    public function getProjectAction(Request $request, EntityManagerInterface $entityManager) {
        $project = $entityManager->getRepository(Project::class)->find($request->get('id'));
        if (empty($projects)) {
            return new JsonResponse(['message' => 'Projects not found'], Response::HTTP_NOT_FOUND);
        }
        $view = View::create($project);
        $view->setFormat('json');
        return $view;
    }
}