<?php
namespace Cps\DakosyReservations\Domain\Model\Dto;

class LessonDemand extends \Webfox\T3events\Domain\Model\Dto\PerformanceDemand
 implements \Webfox\T3events\Domain\Model\Dto\DemandInterface{
	/**
	 * @var \DateTime
	 */
	protected $deadlineBefore;

	/**
	 * @var \DateTime
	 */
	protected $deadlineAfter;

	/**
	 * Genres
	 *
	 * @var \string
	 */
	protected $genres;

	/**
	 * Audiences
	 *
	 * @var \string
	 */
	protected $audiences;

	/**
	 * Event Types
	 *
	 * @var \string
	 */
	protected $eventTypes;

	/**
	 * Returns the deadline
	 * @return \DeadlineTime $deadline
	 */
	public function getDeadlineBefore() {
		return $this->deadlineBefore;
	}

	/**
	 * sets the deadline before
	 * @param \DateTime $deadline
	 * @return void
	 */
	public function setDeadlineBefore($deadline){
		$this->deadlineBefore = $deadline;
	}

	/**
	 * Returns the deadline after
	 * @return \DeadlineTime $deadline
	 */
	public function getDeadlineAfter() {
		return $this->deadlineAfter;
	}

	/**
	 * sets the deadline after
	 * @param \DateTime $deadline
	 * @return void
	 */
	public function setDeadlineAfter($deadline){
		$this->deadlineAfter = $deadline;
	}

	/**
	 * Gets the genres
	 * @return \string
	 */
	public function getGenres() {
		return $this->genres;
	}

	/**
	 * Sets the genres
	 * @param \string $genres
	 * @return void
	 */
	public function setGenres($genres) {
		$this->genres = $genres;
	}

	/**
	 * Gets the audiences
	 * @return \string
	 */
	public function getAudiences() {
		return $this->audiences;
	}

	/**
	 * Sets the audiences
	 * @param \string $audiences
	 * @return void
	 */
	public function setAudiences($audiences) {
		$this->audiences = $audiences;
	}

	/**
	 * Returns the Event Types
	 *
	 * @return \string $eventTypes
	 */
	public function getEventTypes() {
		return $this->eventTypes;
	}

	/**
	 * Set event type
	 *
	 * @param \string $eventTypes
	 * @return void
	 */
	public function setEventTypes($eventTypes) {
		$this->eventTypes = $eventTypes;
	}

}