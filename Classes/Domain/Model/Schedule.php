<?php
namespace CPSIT\T3eventsCourse\Domain\Model;

/***************************************************************
 *  Copyright notice
 *  (c) 2014 Dirk Wenzel <dirk.wenzel@cps-it.de>, CPS-IT
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use Webfox\T3events\Domain\Model\Performance;

/**
 * A lesson.
 */
class Schedule extends Performance {

	/**
	 * Registration deadline
	 *
	 * @var \DateTime
	 */
	protected $deadline = NULL;

	/**
	 * Duration of the lesson
	 *
	 * @var string
	 */
	protected $duration = '';

	/**
	 * Price per participant
	 *
	 * @var float
	 */
	protected $price = 0.0;

	/**
	 * Available places (How many participants are allowed to register)
	 *
	 * @var integer
	 */
	protected $places = 0;

	/**
	 * Course to which the lesson belongs
	 *
	 * @var \CPSIT\T3eventsCourse\Domain\Model\Course
	 */
	protected $course;

	/**
	 * Participants of this course.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\CPSIT\T3eventsReservation\Domain\Model\Person>
	 */
	protected $participants = NULL;

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->participants = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the deadline
	 *
	 * @return \DateTime $deadline
	 */
	public function getDeadline() {
		return $this->deadline;
	}

	/**
	 * Sets the deadline
	 *
	 * @param \DateTime $deadline
	 * @return void
	 */
	public function setDeadline(\DateTime $deadline) {
		$this->deadline = $deadline;
	}

	/**
	 * Returns the duration
	 *
	 * @return string $duration
	 */
	public function getDuration() {
		return $this->duration;
	}

	/**
	 * Sets the duration
	 *
	 * @param string $duration
	 * @return void
	 */
	public function setDuration($duration) {
		$this->duration = $duration;
	}

	/**
	 * Returns the price
	 *
	 * @return float $price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * Sets the price
	 *
	 * @param float $price
	 * @return void
	 */
	public function setPrice($price) {
		$this->price = $price;
	}

	/**
	 * Returns the places
	 *
	 * @return integer $places
	 */
	public function getPlaces() {
		return $this->places;
	}

	/**
	 * Sets the places
	 *
	 * @param integer $places
	 * @return void
	 */
	public function setPlaces($places) {
		$this->places = $places;
	}

	/**
	 * Returns the course
	 *
	 * @return \CPSIT\T3eventsCourse\Domain\Model\Course
	 */
	public function getCourse() {
		return $this->course;
	}

	/**
	 * Sets the course
	 *
	 * @var \CPSIT\T3eventsCourse\Domain\Model\Course $course
	 */
	public function setCourse($course) {
		$this->course = $course;
	}

	/**
	 * Adds a Participant


*
*@param \CPSIT\T3eventsReservation\Domain\Model\Person $participant
	 * @return void
	 */
	public function addParticipant(\CPSIT\T3eventsReservation\Domain\Model\Person $participant) {
		$this->participants->attach($participant);
	}

	/**
	 * Removes a Participant


*
*@param \CPSIT\T3eventsReservation\Domain\Model\Person $participantToRemove The Participant to be removed
	 * @return void
	 */
	public function removeParticipant(\CPSIT\T3eventsReservation\Domain\Model\Person $participantToRemove) {
		$this->participants->detach($participantToRemove);
	}

	/**
	 * Returns the participants
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\CPSIT\T3eventsReservation\Domain\Model\Person> $participants
	 */
	public function getParticipants() {
		return $this->participants;
	}

	/**
	 * Sets the participants
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\CPSIT\T3eventsReservation\Domain\Model\Person> $participants
	 * @return void
	 */
	public function setParticipants(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $participants) {
		$this->participants = $participants;
	}

	/**
	 * Returns the number of free places
	 *
	 * @return \int
	 */
	public function getFreePlaces() {
		return $this->getPlaces() - $this->getParticipants()->count();
	}
}