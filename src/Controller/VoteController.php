<?php

namespace App\Controller;

use App\Modele\Vote;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

class VoteController extends Controller
{
    /**
     * @Get("/vote/{slug}", name="get_vote")
     */
    public function getVoteAction($slug)
    {
        $vote = $this->getDoctrine()
            ->getRepository(\App\Entity\Vote::class)
            ->find($slug);
        $view = $this->view($vote, 200)
            ->setTemplate("rating-bar")
            ->setTemplateVar('vote');
        return $this->handleView($view);
    }
    /**
     * @put("/vote/{slug}", name="put_vote")
     */
    public function putVoteAction($slug)
    {
        $vote = $this->getDoctrine()
            ->getRepository(\App\Entity\Vote::class)
            ->find($slug);
        if ($vote == null)
        {
            $entityManager = $this->getDoctrine()->getManager();
            $vote=new \App\Entity\Vote();
            $vote->setPageSlug($slug);
            $vote->setTotalValue(0);
            $vote->setTotalVotes(0);
            $entityManager->persist($vote);
            $entityManager->flush();
        }
        $view = new View();
        $view->setData($vote);
        $context = new SerializationContext();
        $context->setVersion('2.1');
        $context->setGroups(array('data'));
        $view->setSerializationContext($context);
        return $this->viewHandler->handle($view);
    }
    /**
     * @post("/vote/{slug}/{scoreValue}", name="post_vote")
     */
    public function postVoteAction($slug,$scoreValue)
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/VoteController.php',
        ]);
    }
}
