<?php
namespace CPSIT\T3eventsCourse\Tests\Unit\Controller;

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

use CPSIT\T3eventsCourse\Controller\CourseDemandFactoryTrait;
use CPSIT\T3eventsCourse\Domain\Factory\Dto\CourseDemandFactory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class CourseDemandFactoryTraitTest extends UnitTestCase {
    /**
     * @var CourseDemandFactoryTrait
     */
    protected $subject;

    /**
     * set up
     */
    public function setUp()
    {
        $this->subject = $this->getMockForTrait(
            CourseDemandFactoryTrait::class
        );
    }

    /**
     * @test
     */
    public function demandFactoryCanBeInjected()
    {
        $demandFactory = $this->getMock(
            CourseDemandFactory::class
        );
        $this->subject->injectCourseDemandFactory($demandFactory);

        $this->assertAttributeSame(
            $demandFactory,
            'demandFactory',
            $this->subject
        );
    }
}
