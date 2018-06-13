<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;

class VoteController extends Controller
{
    /**
     * @Get("/vote/{slug}", name="get_vote")
     */
    public function getVoteAction($slug)
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/VoteController.php',
        ]);
    }
    /**
     * @put("/vote/{slug}", name="put_vote")
     */
    public function putVoteAction($slug)
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/VoteController.php',
        ]);
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
