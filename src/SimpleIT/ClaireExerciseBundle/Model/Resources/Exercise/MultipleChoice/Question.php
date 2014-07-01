<?php

namespace SimpleIT\ClaireExerciseBundle\Model\Resources\Exercise\MultipleChoice;

use JMS\Serializer\Annotation as Serializer;
use SimpleIT\ClaireExerciseBundle\Model\Resources\Exercise\Common\CommonItem;
use SimpleIT\ClaireExerciseBundle\Model\Resources\Exercise\Common\Markable;

/**
 * An ExerciseQuestion is a question of multiple choice in its final version,
 * ready to be used in an exercise. All the propositions will be used and the order of the
 * propositions is the one to use for the formatting of the exercise. This order can be
 * shuffled with the function shufflePropositionsOrder().
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class Question extends CommonItem implements Markable
{
    /**
     * @var string $question The wording of this question
     * @Serializer\Type("string")
     * @Serializer\Groups({"details", "corrected", "not_corrected", "item_storage"})
     */
    private $question;

    /**
     * @var array $propositions An array of Proposition
     * @Serializer\Type("array<SimpleIT\ClaireExerciseBundle\Model\Resources\Exercise\MultipleChoice\Proposition>")
     * @Serializer\Groups({"details", "corrected", "not_corrected", "item_storage"})
     */
    private $propositions = array();

    /**
     * @var boolean
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"details", "corrected", "item"})
     */
    private $doNotShuffle;

    /**
     * Shuffle the order of the propositions
     */
    public function shufflePropositionsOrder()
    {
        if ($this->doNotShuffle !== true) {
            shuffle($this->propositions);
        }
    }

    /**
     * Get question
     *
     * @return string Th wording of the question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set question
     *
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * Add an proposition
     *
     * @param boolean $right True if this is a right proposition, false else.
     * @param string  $text  The proposition text
     * @param null    $ticked
     */
    public function addProposition($right, $text, $ticked = null)
    {
        $this->propositions[] = new Proposition($text, $right, $ticked);
    }

    /**
     * Get propositions
     *
     * @return array An array of Proposition.
     */
    public function getPropositions()
    {
        return $this->propositions;
    }

    /**
     * Tick or detick one proposition
     *
     * @param int     $key
     * @param boolean $tick
     */
    public function setTicked($key, $tick)
    {
        $this->propositions[$key]->setTicked($tick);
    }

    /**
     * Set doNotShuffle
     *
     * @param boolean $doNotShuffle
     */
    public function setDoNotShuffle($doNotShuffle)
    {
        $this->doNotShuffle = $doNotShuffle;
    }

    /**
     * Get doNotShuffle
     *
     * @return boolean
     */
    public function getDoNotShuffle()
    {
        return $this->doNotShuffle;
    }
}
