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

use CPSIT\T3eventsCourse\Controller\ScheduleDemandFactoryTrait;
use CPSIT\T3eventsCourse\Domain\Factory\Dto\ScheduleDemandFactory;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ScheduleDemandFactoryTraitTest extends UnitTestCase {
    /**
     * @var ScheduleDemandFactoryTrait
     */
    protected $subject;

    /**
     * set up
     */
    public function setUp()
    {
        $this->subject = $this->getMockForTrait(
            ScheduleDemandFactoryTrait::class
        );
    }

    /**
     * @test
     */
    public function demandFactoryCanBeInjected()
    {
        /** @var ScheduleDemandFactory|MockObject $demandFactory */
        $demandFactory = $this->getMockBuilder(ScheduleDemandFactory::class)->getMock();
        $this->subject->injectScheduleDemandFactory($demandFactory);

        $this->assertAttributeSame(
            $demandFactory,
            'demandFactory',
            $this->subject
        );
    }
}
