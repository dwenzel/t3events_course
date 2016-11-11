<?php
namespace CPSIT\T3eventsCourse\Tests\Controller;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Tests\UnitTestCase;
use CPSIT\T3eventsCourse\Controller\CourseRepositoryTrait;
use CPSIT\T3eventsCourse\Domain\Repository\CourseRepository;

class CourseRepositoryTraitTest extends UnitTestCase
{
    /**
     * @var CourseRepositoryTrait
     */
    protected $subject;

    /**
     * set up
     */
    public function setUp()
    {
        $this->subject = $this->getMockForTrait(
            CourseRepositoryTrait::class
        );
    }

    /**
     * @test
     */
    public function courseRepositoryCanBeInjected()
    {
        $courseRepository = $this->getMock(
            CourseRepository::class, [], [], '', false
        );

        $this->subject->injectCourseRepository($courseRepository);

        $this->assertAttributeSame(
            $courseRepository,
            'courseRepository',
            $this->subject
        );
    }
}