<?php
namespace CPSIT\T3eventsCourse\Domain\Model;

/**
 * Class CourseScheduleTrait
 * Provides properties and methods for course schedules
 *
 * @package CPSIT\T3eventsCourse\Domain\Model
 */
trait CourseScheduleTrait {
	/**
	 * Duration of the lesson
	 *
	 * @var string
	 */
	protected $duration = '';

	/**
	 * @var string
	 */
	protected $classTime;

	/**
	 * @return string
	 */
	public function getClassTime() {
		return $this->classTime;
	}

	/**
	 * @param string $classTime
	 */
	public function setClassTime($classTime) {
		$this->classTime = $classTime;
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

}