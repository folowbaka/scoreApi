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
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;


class VoteController extends FOSRestController
{
    /**
     * @Get("/vote/{slug}", name="get_vote")
     */
    public function getVoteAction($slug)
    {
        $vote = $this->getDoctrine()
            ->getRepository(\App\Entity\Vote::class)
            ->find($slug);
        $numberVote=$vote->getTotalVotes();
        $numberVoteAlt=$numberVote;
        if($numberVote==0)
            $numberVoteAlt=1;
        $view = View::create()
            ->setTemplate('rating-bar.html.twig')
            ->setData(array('vote' => $vote,"rating_unitwidth"=>30,"units"=>5,"numberVote"=>$numberVote,"numberVoteAlt"=>$numberVoteAlt))
            ->setTemplateData(array('vote' => $vote,"ratingunitwidth"=>30,"units"=>5));
        return $this->getViewHandler()->handle($view);
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

        $view = View::create()
            ->setData(array('vote' => $vote));
        return $this->getViewHandler()->handle($view);
    }
    /**
     * @post("/vote/{slug}/{scoreValue}", name="post_vote")
     */
    public function postVoteAction($slug,$scoreValue)
    {
        $vote = $this->getDoctrine()
            ->getRepository(\App\Entity\Vote::class)
            ->find($slug);
        $vote->setTotalValue($vote->getTotalValue()+$scoreValue);
        $vote->setTotalVotes($vote->getTotalVotes()+1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $numberVote=$vote->getTotalVotes();
        $numberVoteAlt=$numberVote;
        if($numberVote==0)
            $numberVoteAlt=1;
        $view = View::create()
            ->setTemplate('rating-bar.html.twig')
            ->setData(array('vote' => $vote,"rating_unitwidth"=>30,"units"=>5,"numberVote"=>$numberVote,"numberVoteAlt"=>$numberVoteAlt))
            ->setTemplateData(array('vote' => $vote,"ratingunitwidth"=>30,"units"=>5));
        return $this->getViewHandler()->handle($view);
    }
}
