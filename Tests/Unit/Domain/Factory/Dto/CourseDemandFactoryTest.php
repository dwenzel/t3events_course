<?php
namespace CPSIT\T3eventsCourse\Tests\Domain\Factory\Dto;

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

use CPSIT\T3eventsCourse\Domain\Model\Dto\CourseDemand;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use CPSIT\T3eventsCourse\Domain\Factory\Dto\CourseDemandFactory;
/**
 * Class CourseDemandFactory
 * @package CPSIT\T3eventsCourse\Tests\Domain\Factory\Dto
 */
class CourseDemandFactoryTest extends UnitTestCase {

    /**
     * @var CourseDemandFactory
     */
    protected $subject;

    /**
     * set up
     */
    public function setUp()
    {
        $this->subject = $this->getMock(
            CourseDemandFactory::class, ['dummy']
        );
    }

    /**
     * @test
     */
    public function createFromSettingsReturnsCourseDemand()
    {
        $mockCourseDemand = $this->getMock(CourseDemand::class);
        $mockObjectManager = $this->getMock(
            ObjectManager::class, ['get']
        );
        $mockObjectManager->expects($this->once())
            ->method('get')
            ->with(CourseDemand::class)
            ->will($this->returnValue($mockCourseDemand));
        $this->subject->injectObjectManager($mockObjectManager);

        $this->assertSame(
            $mockCourseDemand,
            $this->subject->createFromSettings([])
        );
    }
}
