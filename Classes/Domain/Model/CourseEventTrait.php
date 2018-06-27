<?php
namespace CPSIT\T3eventsCourse\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use DWenzel\T3events\Domain\Model\Audience;

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
	protected $abstract;

	/**
	 * Target audience of this course.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\T3events\Domain\Model\Audience>
	 * @lazy
	 */
	protected $audience;

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
	 * @var int
	 */
	protected $degreeType;

	/**
	 * @var string
	 */
	protected $targetGroupDesc;

	/**
	 * @var \double
	 */
	protected $examCosts;

	/**
	 * @var string
	 */
	protected $examRemarks;

	/**
	 * @var int
	 */
	protected $modeInstructionForm;

	/**
	 * Certificates held for this course.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\CPSIT\T3eventsCourse\Domain\Model\Certificate>
	 * @lazy
	 */
	protected $certificate;


	/**
	 * Initializes the object
	 * This method has to be called by the constructor of parent
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->audience = new ObjectStorage();
		$this->certificate = new ObjectStorage();
	}

	/**
	 * Adds a Audience
	 *
	 * @param \DWenzel\T3events\Domain\Model\Audience $audience
	 * @return void
	 */
	public function addAudience(Audience $audience) {
		$this->audience->attach($audience);
	}

	/**
	 * Removes a Audience
	 *
	 * @param \DWenzel\T3events\Domain\Model\Audience $audienceToRemove The Audience to be removed
	 * @return void
	 */
	public function removeAudience(Audience $audienceToRemove) {
		$this->audience->detach($audienceToRemove);
	}

	/**
	 * Returns the audience
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\T3events\Domain\Model\Audience> $audience
	 */
	public function getAudience() {
		return $this->audience;
	}

	/**
	 * Sets the audience
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\T3events\Domain\Model\Audience> $audience
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

	/**
	 * @return int
	 */
	public function getDegreeType() {
		return $this->degreeType;
	}

	/**
	 * @param int $degreeType
	 */
	public function setDegreeType($degreeType) {
		$this->degreeType = $degreeType;
	}

	/**
	 * @return string
	 */
	public function getTargetGroupDesc() {
		return $this->targetGroupDesc;
	}

	/**
	 * @param string $targetGroupDesc
	 */
	public function setTargetGroupDesc($targetGroupDesc) {
		$this->targetGroupDesc = $targetGroupDesc;
	}

	/**
	 * @return float
	 */
	public function getExamCosts() {
		return $this->examCosts;
	}

	/**
	 * @param float $examCosts
	 */
	public function setExamCosts($examCosts) {
		$this->examCosts = $examCosts;
	}

	/**
	 * @return string
	 */
	public function getExamRemarks() {
		return $this->examRemarks;
	}

	/**
	 * @param string $examRemarks
	 */
	public function setExamRemarks($examRemarks) {
		$this->examRemarks = $examRemarks;
	}

	/**
	 * @return int
	 */
	public function getModeInstructionForm() {
		return $this->modeInstructionForm;
	}

	/**
	 * @param int $modeInstructionForm
	 */
	public function setModeInstructionForm($modeInstructionForm) {
		$this->modeInstructionForm = $modeInstructionForm;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\CPSIT\T3eventsCourse\Domain\Model\Certificate>
	 */
	public function getCertificate() {
		return $this->certificate;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\CPSIT\T3eventsCourse\Domain\Model\Certificate> $certificate
	 */
	public function setCertificate($certificate) {
		$this->certificate = $certificate;
	}

    /**
     * Adds a Certificate
     *
     * @param \CPSIT\T3eventsCourse\Domain\Model\Certificate
     * @return void
     */
    public function addCertificate(Certificate $certificate) {
        $this->certificate->attach($certificate);
    }

    /**
     * Removes a Certificate
     *
     * @param \CPSIT\T3eventsCourse\Domain\Model\Certificate $certificateToRemove The Certificate to be removed
     * @return void
     */
    public function removeCertificate(Certificate $certificateToRemove) {
        $this->certificate->detach($certificateToRemove);
    }

}
