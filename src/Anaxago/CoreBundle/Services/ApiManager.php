<?php
/********************************
 * Created by ktroufleau.
 * Date: 23/05/2019
 * Time: 19:54
 ********************************/


namespace Anaxago\CoreBundle\Services;

use Anaxago\CoreBundle\Entity\Project;
use Anaxago\CoreBundle\Entity\Interest;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
/**
 * Class ApiManager
 * @package Anaxago\CoreBundle\Services
 */
class ApiManager
{
    public function postInterest(EntityManagerInterface $entityManager, int $projectId, float $amount, $username) {
        $interest = new Interest();
        $project = $entityManager->getRepository(Project::class)->find($projectId);
        if(empty($project)){
            return View::create(['status' => 'KO','message' => 'Projects not found'], Response::HTTP_NOT_FOUND);
        }
        $interest->setUsername($username);
        $interest->setProject($project);
        $interest->setAmount($amount);

        $entityManager->persist($interest);
        $entityManager->flush();

        $entityManager->getRepository(Project::class)->putInvested($amount, $project);
        return View::create(['status' => 'OK', 'message' => 'Interests has been added'], Response::HTTP_ACCEPTED);
    }
}