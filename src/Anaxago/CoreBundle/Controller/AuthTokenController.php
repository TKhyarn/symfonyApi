<?php
/********************************
 * Created by ktroufleau.
 * Date: 20/05/2019
 * Time: 21:30
 ********************************/


namespace Anaxago\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Anaxago\CoreBundle\Form\Type\CredentialsType;
use Anaxago\CoreBundle\Entity\AuthToken;
use Anaxago\CoreBundle\Entity\Credentials;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthTokenController
 * @Route ("/api")
 * @package Anaxago\CoreBundle\Controller
 */
class AuthTokenController extends Controller
{
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"auth-token"})
     * @Rest\Post("/auth-tokens")
     *
     * @param Request $request
     *
     * @return AuthToken|\FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
     *
     * @throws \Exception
     */
    public function postAuthTokensAction(Request $request)
    {
        $credentials = new Credentials();
        $form = $this->createForm(CredentialsType::class, $credentials);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }

        $em = $this->get('doctrine.orm.entity_manager');

        $user = $em->getRepository('AnaxagoCoreBundle:User')
            ->findOneByEmail($credentials->getLogin());

        if (!$user) { // L'utilisateur n'existe pas
            return $this->invalidCredentials();
        }

        $encoder = $this->get('security.password_encoder');
        $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());

        if (!$isPasswordValid) { // Le mot de passe n'est pas correct
            return $this->invalidCredentials();
        }

        $authToken = new AuthToken();
        $authToken->setValue(base64_encode(random_bytes(50)));
        $authToken->setCreatedAt(new \DateTime('now'));
        $authToken->setUser($user);

        $em->persist($authToken);
        $em->flush();

        return $authToken;
    }

    /**
     * @return \FOS\RestBundle\View\View
     */
    private function invalidCredentials()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
    }
}