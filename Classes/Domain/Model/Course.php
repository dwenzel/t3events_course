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
use Webfox\T3events\Domain\Model\Event;

/**
 * A course offer.
 */
class Course extends Event {

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
		$this->audience = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->lessons = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a Audience
	 *
	 * @param \Webfox\T3events\Domain\Model\Audience $audience
	 * @return void
	 */
	public function addAudience(\Webfox\T3events\Domain\Model\Audience $audience) {
		$this->audience->attach($audience);
	}

	/**
	 * Removes a Audience
	 *
	 * @param \Webfox\T3events\Domain\Model\Audience $audienceToRemove The Audience to be removed
	 * @return void
	 */
	public function removeAudience(\Webfox\T3events\Domain\Model\Audience $audienceToRemove) {
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
	public function setAudience(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $audience) {
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
	public function addLesson(\CPSIT\T3eventsCourse\Domain\Model\Schedule $lesson) {
		$this->lessons->attach($lesson);
	}

	/**
	 * Removes a Schedule
	 *
	 * @param \CPSIT\T3eventsCourse\Domain\Model\Schedule $lessonToRemove The Schedule to be removed
	 * @return void
	 */
	public function removeLesson(\CPSIT\T3eventsCourse\Domain\Model\Schedule $lessonToRemove) {
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
	public function setLessons(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $lessons) {
		$this->lessons = $lessons;
	}

}