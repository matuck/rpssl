<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 */
class Game
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="User", type="string", length=8)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="Computer", type="string", length=8)
     */
    private $computer;

    /**
     * @var string
     *
     * @ORM\Column(name="Winner", type="string", length=8)
     */
    private $winner;

    /**
     * @var array of valid moves
     */
    public static $moves = array(
        'Rock' => 'Rock',
        'Paper' => 'Paper',
        'Scissors' => 'Scissors',
        'Spock' => 'Spock',
        'Lizard' => 'Lizard'
    );

    private $messages = array(
        'Rock' => array(
            'Scissors' => 'Rock crushes scissors',
            'Lizard'   => 'Rock crushes lizard'
        ),
        'Paper' => array(
            'Rock'  => 'Paper covers rock',
            'Spock' => 'Paper disproves Spock'
        ),
        'Scissors' => array(
            'Paper'  => 'Scissors cut paper',
            'Lizard' => 'Scissors decapitate lizard'
        ),
        'Lizard' => array(
            'Spock' => 'Lizard poisons Spock',
            'Paper' => 'Lizard eats paper'
        ),
        'Spock' => array(
            'Scissors' => 'Spock smashes scissors',
            'Rock' => 'Spock vaporizes rock'
        )
    );
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return Game
     */
    public function setUser($user)
    {
        $this->user = $user;
        $this->setWinner();
        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set computer
     *
     * @param string $computer
     * @return Game
     */
    public function setComputer($computer)
    {
        $this->computer = $computer;
        $this->setWinner();
        return $this;
    }

    /**
     * Get computer
     *
     * @return string 
     */
    public function getComputer()
    {
        return $this->computer;
    }

    /**
     * Set winner
     *
     * @return Game
     */
    public function setWinner()
    {
        if($this->user != null && $this->computer != null) {
            if(isset($this->messages[$this->user][$this->computer])) {
                $this->winner = 'User';
            } elseif (isset($this->messages[$this->computer][$this->user])) {
                $this->winner = 'Computer';
            } else {
                $this->winner = 'Tie';
            }
        } else {
            $this->winner = null;
        }

        return $this;
    }

    /**
     * Get winner
     *
     * @return string 
     */
    public function getWinner()
    {
        return $this->winner;
    }


    public function getWinMessage()
    {
        $message = "";
        if($this->winner == 'User') {
            $message = $this->messages[$this->user][$this->computer];
        } elseif ($this->winner == 'Computer') {
            $message = $this->messages[$this->computer][$this->user];
        } else {
            $message = 'Tie Game!';
        }
        return $message;
    }
    /**
     * Gets a random move
     *
     * @return string "Rock", "Paper", "Scissors", "Spock", "Lizard"
     */
    public static function getRandomMove()
    {
        return array_rand(Game::$moves);
    }
}
