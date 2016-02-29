<?php
namespace CPSIT\T3eventsCourse\Domain\Model\Dto;

use Webfox\T3events\Domain\Model\Dto\DemandInterface;
use Webfox\T3events\Domain\Model\Dto\PerformanceDemand;

/**
 * Class ScheduleDemand
 *
 * @package CPSIT\T3eventsCourse\Domain\Model\Dto
 */
class ScheduleDemand extends PerformanceDemand
	implements DemandInterface {

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
	 * @var string
	 */
	protected $genres;

	/**
	 * Audiences
	 *
	 * @var string
	 */
	protected $audiences;

	/**
	 * Event Types
	 *
	 * @var string
	 */
	protected $eventTypes;

	/**
	 * Returns the deadline
	 *
	 * @return \DateTime $deadline
	 */
	public function getDeadlineBefore() {
		return $this->deadlineBefore;
	}

	/**
	 * sets the deadline before
	 *
	 * @param \DateTime $deadline
	 * @return void
	 */
	public function setDeadlineBefore($deadline) {
		$this->deadlineBefore = $deadline;
	}

	/**
	 * Returns the deadline after
	 *
	 * @return \DateTime $deadline
	 */
	public function getDeadlineAfter() {
		return $this->deadlineAfter;
	}

	/**
	 * sets the deadline after
	 *
	 * @param \DateTime $deadline
	 * @return void
	 */
	public function setDeadlineAfter($deadline) {
		$this->deadlineAfter = $deadline;
	}

	/**
	 * Gets the genres
	 *
	 * @return string
	 */
	public function getGenres() {
		return $this->genres;
	}

	/**
	 * Sets the genres
	 *
	 * @param string $genres
	 * @return void
	 */
	public function setGenres($genres) {
		$this->genres = $genres;
	}

	/**
	 * Gets the audiences
	 *
	 * @return string
	 */
	public function getAudiences() {
		return $this->audiences;
	}

	/**
	 * Sets the audiences
	 *
	 * @param string $audiences
	 * @return void
	 */
	public function setAudiences($audiences) {
		$this->audiences = $audiences;
	}

	/**
	 * Returns the Event Types
	 *
	 * @return string $eventTypes
	 */
	public function getEventTypes() {
		return $this->eventTypes;
	}

	/**
	 * Set event type
	 *
	 * @param string $eventTypes
	 * @return void
	 */
	public function setEventTypes($eventTypes) {
		$this->eventTypes = $eventTypes;
	}

}