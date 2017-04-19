<?php

namespace CPSIT\T3eventsCourse\Tests\Unit\Domain\Model;


use CPSIT\T3eventsCourse\Domain\Model\Certificate;
use CPSIT\T3eventsCourse\Domain\Model\CourseEventTrait;
use DWenzel\T3events\Domain\Model\Audience;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class CourseEventTraitTest extends UnitTestCase
{
    /**
     * @var CourseEventTrait
     */
    protected $subject;

    /**
     * Set up the subject
     * @return void
     */
    public function setUp()
    {
        $this->subject = $this->getMockForTrait(
            CourseEventTrait::class
        );
    }

    /**
     * @test
     */
    public function initializeObjectInitializesStorageProperties()
    {
        $expectedStorage = new ObjectStorage();

        $this->subject->initializeObject();

        $this->assertEquals(
            $expectedStorage,
            $this->subject->getAudience()
        );

        $this->assertEquals(
            $expectedStorage,
            $this->subject->getCertificate()
        );
    }

    /**
     * @test
     */
    public function addAudienceAddsObjectToStorage()
    {
        $this->subject->initializeObject();
        $audience = $this->getMock(Audience::class);

        $this->subject->addAudience($audience);

        $this->assertTrue(
            $this->subject->getAudience()->contains($audience)
        );
    }

    /**
     * @test
     */
    public function setAudiencesSetsObjectStorage()
    {
        $objectStorage = $this->getMock(ObjectStorage::class);
        $this->subject->setAudience($objectStorage);
        $this->assertSame(
            $objectStorage,
            $this->subject->getAudience()
        );
    }

    /**
     * @test
     */
    public function removeAudienceRemovesObjectFromStorage()
    {
        $objectStorage = new ObjectStorage();
        $audience = new Audience();
        $objectStorage->attach($audience);
        $this->subject->setAudience($objectStorage);
        $this->subject->removeAudience($audience);
        $this->assertFalse(
            $this->subject->getAudience()->contains($audience)
        );
    }


    /**
     * @test
     */
    public function addCertificateAddsObjectToStorage()
    {
        $this->subject->initializeObject();
        $certificate = $this->getMock(Certificate::class);

        $this->subject->addCertificate($certificate);

        $this->assertTrue(
            $this->subject->getCertificate()->contains($certificate)
        );
    }

    /**
     * @test
     */
    public function setCertificatesSetsObjectStorage()
    {
        $objectStorage = $this->getMock(ObjectStorage::class);
        $this->subject->setCertificate($objectStorage);
        $this->assertSame(
            $objectStorage,
            $this->subject->getCertificate()
        );
    }

    /**
     * @test
     */
    public function removeCertificateRemovesObjectFromStorage()
    {
        $objectStorage = new ObjectStorage();
        $certificate = new Certificate();
        $objectStorage->attach($certificate);
        $this->subject->setCertificate($objectStorage);
        $this->subject->removeCertificate($certificate);
        $this->assertFalse(
            $this->subject->getCertificate()->contains($certificate)
        );
    }

    /**
     * @test
     */
    public function getAbstractInitiallyReturnsNull()
    {
        $this->assertNull($this->subject->getAbstract());
    }

    /**
     * @test
     */
    public function setAbstractSetsAbstract()
    {
        $abstract = 'foo';
        $this->subject->setAbstract($abstract);
        $this->assertSame(
            $abstract,
            $this->subject->getAbstract()
        );
    }

    /**
     * @test
     */
    public function getRequirementsInitiallyReturnsNull()
    {
        $this->assertNull($this->subject->getRequirements());
    }

    /**
     * @test
     */
    public function setRequirementsSetsRequirements()
    {
        $requirements = 'foo';
        $this->subject->setRequirements($requirements);
        $this->assertSame(
            $requirements,
            $this->subject->getRequirements()
        );
    }

    /**
     * @test
     */
    public function getExamRemarksInitiallyReturnsNull()
    {
        $this->assertNull($this->subject->getExamRemarks());
    }

    /**
     * @test
     */
    public function setExamRemarksSetsExamRemarks()
    {
        $examRemarks = 'foo';
        $this->subject->setExamRemarks($examRemarks);
        $this->assertSame(
            $examRemarks,
            $this->subject->getExamRemarks()
        );
    }

    /**
     * @test
     */
    public function getTargetGroupDescInitiallyReturnsNull()
    {
        $this->assertNull($this->subject->getTargetGroupDesc());
    }

    /**
     * @test
     */
    public function setTargetGroupDescSetsTargetGroupDesc()
    {
        $targetGroupDesc = 'foo';
        $this->subject->setTargetGroupDesc($targetGroupDesc);
        $this->assertSame(
            $targetGroupDesc,
            $this->subject->getTargetGroupDesc()
        );
    }

    /**
     * @test
     */
    public function getNewUntilInitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getNewUntil()
        );
    }

    /**
     * @test
     */
    public function newUntilCanBeSet()
    {
        $date = new \DateTime();

        $this->subject->setNewUntil($date);
        $this->assertSame(
            $date,
            $this->subject->getNewUntil()
        );
    }

    /**
     * @test
     */
    public function getDegreeTypeInitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getDegreeType()
        );
    }

    /**
     * @test
     */
    public function degreeTypeCanBeSet()
    {
        $degreeType = 5;
        $this->subject->setDegreeType($degreeType);
        $this->assertSame(
            $degreeType,
            $this->subject->getDegreeType()
        );
    }

    /**
     * @test
     */
    public function getExamCostsInitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getExamCosts()
        );
    }

    /**
     * @test
     */
    public function examCostsCanBeSet()
    {
        $examCosts = 500.50;
        $this->subject->setExamCosts($examCosts);
        $this->assertSame(
            $examCosts,
            $this->subject->getExamCosts()
        );
    }
    
    /**
     * @test
     */
    public function getModeInstructionFormInitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getModeInstructionForm()
        );
    }

    /**
     * @test
     */
    public function modeInstructionFormCanBeSet()
    {
        $modeInstructionForm = 5;
        $this->subject->setModeInstructionForm($modeInstructionForm);
        $this->assertSame(
            $modeInstructionForm,
            $this->subject->getModeInstructionForm()
        );
    }
    
}
