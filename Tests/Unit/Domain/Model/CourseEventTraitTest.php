<?php

namespace CPSIT\T3eventsCourse\Tests\Unit\Domain\Model;


use CPSIT\T3eventsCourse\Domain\Model\CourseEventTrait;
use DWenzel\T3events\Domain\Model\Audience;
use TYPO3\CMS\Core\Tests\UnitTestCase;
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
    public function initializeObjectInitalizesStorageProperties()
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
    public function getAbstractInitiallyReturnsEmptyString()
    {
        $this->assertSame('', $this->subject->getAbstract());
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


}
