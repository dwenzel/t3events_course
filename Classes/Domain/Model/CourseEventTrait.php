<?php
namespace CPSIT\T3eventsCourse\Domain\Model;

use CPSIT\T3eventsReservation\Domain\Model\Schedule;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Webfox\T3events\Domain\Model\Audience;

/**
 * Class CourseEventTrait
 * Provides properties and method for course events
 *
 * @package CPSIT\T3eventsCourse\Domain\Model
 */
trait CourseEventTrait {

	/**
	 * abstract
	 *
	 * @var string
	 */
	protected $abstract = '';

	/**
	 * Target audience of this course.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Webfox\T3events\Domain\Model\Audience>
	 * @lazy
	 */
	protected $audience = NULL;

	/**
	 * Lessons held for this course.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\CPSIT\T3eventsCourse\Domain\Model\Schedule>
	 * @lazy
	 */
	protected $lessons = NULL;

	/**
	 * Requirements
	 *
	 * @var string
	 */
	protected $requirements;

	/**
	 * @var \DateTime
	 */
	protected $newUntil;

	/**
	 * Initializes the object
	 * This method has to be called by the constructor of parent
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->audience = new ObjectStorage();
		$this->lessons = new ObjectStorage();
	}

	/**
	 * Adds a Audience
	 *
	 * @param \Webfox\T3events\Domain\Model\Audience $audience
	 * @return void
	 */
	public function addAudience(Audience $audience) {
		$this->audience->attach($audience);
	}

	/**
	 * Removes a Audience
	 *
	 * @param \Webfox\T3events\Domain\Model\Audience $audienceToRemove The Audience to be removed
	 * @return void
	 */
	public function removeAudience(Audience $audienceToRemove) {
		$this->audience->detach($audienceToRemove);
	}

	/**
	 * Returns the audience
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Webfox\T3events\Domain\Model\Audience> $audience
	 */
	public function getAudience() {
		return $this->audience;
	}

	/**
	 * Sets the audience
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Webfox\T3events\Domain\Model\Audience> $audience
	 * @return void
	 */
	public function setAudience(ObjectStorage $audience) {
		$this->audience = $audience;
	}

	/**
	 * Returns the abstract
	 *
	 * @return string $abstract
	 */
	public function getAbstract() {
		return $this->abstract;
	}

	/**
	 * Sets the abstract
	 *
	 * @param string $abstract
	 * @return void
	 */
	public function setAbstract($abstract) {
		$this->abstract = $abstract;
	}

	/**
	 * Adds a Schedule
	 *
	 * @param \CPSIT\T3eventsCourse\Domain\Model\Schedule $lesson
	 * @return void
	 */
	public function addLesson(Schedule $lesson) {
		$this->lessons->attach($lesson);
	}

	/**
	 * Removes a Schedule
	 *
	 * @param \CPSIT\T3eventsCourse\Domain\Model\Schedule $lessonToRemove The Schedule to be removed
	 * @return void
	 */
	public function removeLesson(Schedule $lessonToRemove) {
		$this->lessons->detach($lessonToRemove);
	}

	/**
	 * Returns the lessons
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\CPSIT\T3eventsCourse\Domain\Model\Schedule> $lessons
	 */
	public function getLessons() {
		return $this->lessons;
	}

	/**
	 * Sets the lessons
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\CPSIT\T3eventsCourse\Domain\Model\Schedule> $lessons
	 * @return void
	 */
	public function setLessons(ObjectStorage $lessons) {
		$this->lessons = $lessons;
	}

	/**
	 * @return string
	 */
	public function getRequirements() {
		return $this->requirements;
	}

	/**
	 * @param string $requirements
	 */
	public function setRequirements($requirements) {
		$this->requirements = $requirements;
	}

	/**
	 * @return \DateTime
	 */
	public function getNewUntil() {
		return $this->newUntil;
	}

	/**
	 * @param \DateTime $newUntil
	 */
	public function setNewUntil($newUntil) {
		$this->newUntil = $newUntil;
	}
}