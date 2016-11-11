<?php
namespace CPSIT\T3eventsCourse\Domain\Model\Dto;

use DWenzel\T3events\Domain\Model\Dto\DemandInterface;
use DWenzel\T3events\Domain\Model\Dto\EventLocationAwareDemandInterface;
use DWenzel\T3events\Domain\Model\Dto\GenreAwareDemandInterface;
use DWenzel\T3events\Domain\Model\Dto\GenreAwareDemandTrait;
use DWenzel\T3events\Domain\Model\Dto\PerformanceDemand;

/**
 * Class ScheduleDemand
 *
 * @package CPSIT\T3eventsCourse\Domain\Model\Dto
 */
class ScheduleDemand extends PerformanceDemand
{
    /**
     * @var \DateTime
     */
    protected $deadlineBefore;

    /**
     * @var \DateTime
     */
    protected $deadlineAfter;

    /**
     * Returns the deadline
     *
     * @return \DateTime $deadline
     */
    public function getDeadlineBefore()
    {
        return $this->deadlineBefore;
    }

    /**
     * sets the deadline before
     *
     * @param \DateTime $deadline
     * @return void
     */
    public function setDeadlineBefore($deadline)
    {
        $this->deadlineBefore = $deadline;
    }

    /**
     * Returns the deadline after
     *
     * @return \DateTime $deadline
     */
    public function getDeadlineAfter()
    {
        return $this->deadlineAfter;
    }

    /**
     * sets the deadline after
     *
     * @param \DateTime $deadline
     * @return void
     */
    public function setDeadlineAfter($deadline)
    {
        $this->deadlineAfter = $deadline;
    }
}
