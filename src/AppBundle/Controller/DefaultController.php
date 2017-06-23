<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //Build form for user to make his choice
        $defaultData = array('move' => 'Rock');
        $builder = $this->createFormBuilder($defaultData);
        $builder->add('move', ChoiceType::class, array(
            'choices' => Game::$moves,
            'expanded' => true,
            'multiple' => false
        ));
        $builder->add('save', SubmitType::class, array('label' => 'Go'));
        $form = $builder->getForm();
        //Bind submitted dataq to form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "move"
            $data = $form->getData();
            //Create a game Entity.
            $game = new Game();
            $game->setUser($data['move']);
            $game->setComputer(Game::getRandomMove());
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();
            //Route to the posted view.
            return $this->render('default/index-post.html.twig', array(
                'game' => $game,
                'winmessage' => $game->getWinMessage()
            ));
        }

        //Route to the game form to start a new game.
        return $this->render('default/index.html.twig', array(
            'form' => $form->createView()
        ));

    }
}
