<?php

namespace CPSIT\T3eventsCourse\Tests\Unit\Domain\Model;


use CPSIT\T3eventsCourse\Domain\Model\Course;
use TYPO3\CMS\Core\Tests\UnitTestCase;

class CourseTest extends UnitTestCase
{
    /**
     * @var Course
     */
    protected $subject;

    /**
     * Set up subject
     * @return void
     */
    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(Course::class, ['dummy']);
    }

    /**
     * @test
     */
    public function extbaseTypeInitiallyContaintsClassConstant()
    {
        $this->assertAttributeSame(
            Course::DEFAULT_EXTBASE_TYPE,
            'extbaseType',
            $this->subject
        );
    }
}