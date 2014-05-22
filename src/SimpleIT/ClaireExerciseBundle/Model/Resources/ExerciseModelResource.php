<?php
namespace SimpleIT\ClaireExerciseBundle\Model\Resources;

use JMS\Serializer\Annotation as Serializer;
use SimpleIT\ClaireExerciseBundle\Model\Resources\Exercise\Common\CommonExercise;
use SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\Common\CommonModel;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ExerciseModelResource
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class ExerciseModelResource extends SharedResource
{
    /**
     * @const RESOURCE_NAME = 'Exercise Model'
     */
    const RESOURCE_NAME = 'Exercise Model';

    /**
     * @const MULTIPLE_CHOICE_MODEL_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\MultipleChoice\Model'
     */
    const MULTIPLE_CHOICE_MODEL_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\MultipleChoice\Model';

    /**
     * @const GROUP_ITEMS_MODEL_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\GroupItems\Model'
     */
    const GROUP_ITEMS_MODEL_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\GroupItems\Model';

    /**
     * @const ORDER_ITEMS_MODEL_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\OrderItems\Model'
     */
    const ORDER_ITEMS_MODEL_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\OrderItems\Model';

    /**
     * @const PAIR_ITEMS_MODEL_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\PairItems\Model'
     */
    const PAIR_ITEMS_MODEL_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\PairItems\Model';

    /**
     * @const OPEN_ENDED_QUESTION_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\OpenEndedQuestion\Model'
     */
    const OPEN_ENDED_QUESTION_CLASS = 'SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\OpenEndedQuestion\Model';

    /**
     * @var int $id Id of exercise model
     * @Serializer\Type("integer")
     * @Serializer\Groups({"details", "list", "exercise"})
     * @Assert\Blank(groups={"create"})
     */
     protected $id;

    /**
     * @var string $type
     * @Serializer\Type("string")
     * @Serializer\Groups({"details", "list", "exercise"})
     * @Assert\NotBlank(groups={"create"})
     */
    protected $type;

    /**
     * @var string $title
     * @Serializer\Type("string")
     * @Serializer\Groups({"details", "list", "exercise"})
     * @Assert\NotBlank(groups={"create"})
     */
    protected $title;

    /**
     * @var CommonModel $content
     * @Serializer\Groups({"details"})
     * @Serializer\Type("SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\Common\CommonModel")
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Valid
     */
    private $content;

    /**
     * @var boolean $draft
     * @Serializer\Groups({"details", "list"})
     * @Serializer\Type("boolean")
     * @Assert\NotNull(groups={"create"})
     */
    private $draft;

    /**
     * @var boolean $complete
     * @Serializer\Groups({"details", "list"})
     * @Serializer\Type("boolean")
     * @Assert\Null(groups={"create"})
     */
    private $complete;

    /**
     * @var int
     * @Serializer\Type("integer")
     * @Serializer\Groups({"details", "list", "resource_list"})
     * @Assert\Blank(groups={"create", "edit"})
     */
    protected $author;

    /**
     * @var array $requiredExerciseResources
     * @Serializer\Type("array")
     * @Serializer\Groups({"details"})
     * @Assert\NotNull(groups={"create"})
     */
    private $requiredExerciseResources;

    /**
     * @var array $requiredKnowledges
     * @Serializer\Type("array")
     * @Serializer\Groups({"details"})
     * @Assert\NotNull(groups={"create"})
     */
    private $requiredKnowledges;

    /**
     * @var int $owner
     * @Serializer\Type("integer")
     * @Serializer\Groups({"details", "list"})
     * @Assert\Blank(groups={"create", "edit"})
     */
    protected $owner;

    /**
     * @var bool $public
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"details","list"})
     * @Assert\NotNull(groups={"create"})
     */
    protected $public;

    /**
     * @var bool $archived
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"details","list"})
     * @Assert\Null(groups={"create"})
     */
    protected $archived;

    /**
     * @var array
     * @Serializer\Type("array")
     * @Serializer\Groups({"details"})
     */
    protected $metadata;

    /**
     * @var int
     * @Serializer\Type("integer")
     * @Serializer\Groups({"details"})
     */
    protected $parent;

    /**
     * @var int
     * @Serializer\Type("integer")
     * @Serializer\Groups({"details"})
     */
    protected $forkFrom;

    /**
     * Set content
     *
     * @param \SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\Common\CommonModel $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return \SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModel\Common\CommonModel
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set requiredExerciseResources
     *
     * @param array $requiredExerciseResources
     */
    public function setRequiredExerciseResources($requiredExerciseResources)
    {
        $this->requiredExerciseResources = $requiredExerciseResources;
    }

    /**
     * Get requiredExerciseResources
     *
     * @return array
     */
    public function getRequiredExerciseResources()
    {
        return $this->requiredExerciseResources;
    }

    /**
     * Set complete
     *
     * @param boolean $complete
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;
    }

    /**
     * Get complete
     *
     * @return boolean
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * Set draft
     *
     * @param boolean $draft
     */
    public function setDraft($draft)
    {
        $this->draft = $draft;
    }

    /**
     * Get draft
     *
     * @return boolean
     */
    public function getDraft()
    {
        return $this->draft;
    }

    /**
     * Set requiredKnowledges
     *
     * @param array $requiredKnowledges
     */
    public function setRequiredKnowledges($requiredKnowledges)
    {
        $this->requiredKnowledges = $requiredKnowledges;
    }

    /**
     * Get requiredKnowledges
     *
     * @return array
     */
    public function getRequiredKnowledges()
    {
        return $this->requiredKnowledges;
    }

    /**
     * Return the item serialization class corresponding to the type
     *
     * @param string $type
     *
     * @return string
     * @throws \LogicException
     */
    public function getClass($type = null)
    {
        if ($type === null)
        {
            $type = $this->type;
        }

        switch ($type) {
            case CommonExercise::MULTIPLE_CHOICE:
                $class = self::MULTIPLE_CHOICE_MODEL_CLASS;
                break;
            case CommonExercise::GROUP_ITEMS:
                $class = self::GROUP_ITEMS_MODEL_CLASS;
                break;
            case CommonExercise::ORDER_ITEMS:
                $class = self::ORDER_ITEMS_MODEL_CLASS;
                break;
            case CommonExercise::PAIR_ITEMS:
                $class = self::PAIR_ITEMS_MODEL_CLASS;
                break;
            case CommonExercise::OPEN_ENDED_QUESTION:
                $class = self::OPEN_ENDED_QUESTION_CLASS;
                break;
            default:
                throw new \LogicException('Unknown type');
        }

        return $class;
    }
}