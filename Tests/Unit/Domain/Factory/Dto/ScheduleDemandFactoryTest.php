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

use CPSIT\T3eventsCourse\Domain\Model\Dto\ScheduleDemand;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use CPSIT\T3eventsCourse\Domain\Factory\Dto\ScheduleDemandFactory;
/**
 * Class ScheduleDemandFactory
 * @package CPSIT\T3eventsCourse\Tests\Domain\Factory\Dto
 */
class ScheduleDemandFactoryTest extends UnitTestCase {

    /**
     * @var ScheduleDemandFactory
     */
    protected $subject;

    /**
     * set up
     */
    public function setUp()
    {
        $this->subject = $this->getMockBuilder(ScheduleDemandFactory::class)
            ->setMethods(['dummy'])
            ->getMock();
    }
    /**
     * @param $mockScheduleDemand
     */
    protected function mockObjectManager($mockScheduleDemand)
    {
        $mockObjectManager = $this->getMockBuilder(ObjectManager::class)
            ->setMethods(['get'])->getMock();
        $mockObjectManager->expects($this->once())
            ->method('get')
            ->with(ScheduleDemand::class)
            ->will($this->returnValue($mockScheduleDemand));
        $this->subject->injectObjectManager($mockObjectManager);
    }

    /**
     * @test
     */
    public function createFromSettingsReturnsScheduleDemand()
    {
        $mockScheduleDemand = $this->getMockBuilder(ScheduleDemand::class)->getMock();
        $this->mockObjectManager($mockScheduleDemand);

        $this->assertSame(
            $mockScheduleDemand,
            $this->subject->createFromSettings([])
        );
    }

    /**
     * @test
     */
    public function createFromSettingsSetsDeadLineAfterIfHideAfterDeadlineIsSet()
    {
        $settings = [
            'hideAfterDeadline' => '1'
        ];

        /** @var ScheduleDemand |\PHPUnit_Framework_MockObject_MockObject $mockScheduleDemand */
        $mockScheduleDemand = new ScheduleDemand();
        $this->mockObjectManager($mockScheduleDemand);

        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $deadLine = new \DateTime('now', $timeZone);

        $demand = $this->subject->createFromSettings($settings);
        $this->assertEquals(
            $deadLine->getTimestamp(),
            $demand->getDeadlineAfter()->getTimestamp()
        );
    }

}
