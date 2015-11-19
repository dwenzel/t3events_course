<?php
namespace Cps\DakosyReservations\Domain\Model\Dto;

/**
 * Created by JetBrains PhpStorm.
 * User: wenzel
 * Date: 22.09.14
 * Time: 16:28
 * To change this template use File | Settings | File Templates.
 */
class PersonDemand extends \Webfox\T3events\Domain\Model\Dto\AbstractDemand
	implements \Webfox\T3events\Domain\Model\Dto\DemandInterface {
	/**
	 * Types
	 * @var \string
	 */
	protected $types;

	/**
	 * lesson deadline
	 * @var \DateTime Deadline of lesson (in reservation)
	 */
	protected $lessonDeadline;

	/**
	 * Date of lesson
	 *
	 * @var \DateTime Date of lesson (in reservation)
	 */
	protected $lessonDate;

	/**
	 * Period of lesson (in reservation)
	 *
	 * @var \string
	 */
	protected $lessonPeriod;
	/**
	 * get the types
	 * @return \string
	 */
	public function getTypes(){
		return $this->types;
	}

	/**
	 * sets the types
	 * @param \string $types
	 * @return void
	 */
	public function setTypes($types) {
		$this->types = $types;
	}

	/**
	 * Get the lesson deadline
	 * @return \DateTime
	 */
	public function getLessonDeadline() {
		return $this->lessonDeadline;
	}

	/**
	 * Sets the lesson deadline
	 * @var \DateTime $deadline
	 */
	public function setLessonDeadline($deadline) {
		$this->lessonDeadline=$deadline;
	}

	/**
	 * Gets the lesson date
	 *
	 * @return \DateTime
	 */
	public function getLessonDate() {
		return $this->lessonDate;
	}

	/**
	 * Sets the lesson date
	 *
	 * @param $date
	 */
	public function setLessonDate($date) {
		$this->lessonDate = $date;
	}

	/**
	 * Gets the lesson period (in reservation)
	 *
	 * @return string
	 */
	public function getLessonPeriod() {
		return $this->lessonPeriod;
	}

	/**
	 * Sets the period of the lesson (in reservation)
	 *
	 * @param \string $period
	 */
	public function setLessonPeriod($period) {
		$this->lessonPeriod = $period;
	}
}