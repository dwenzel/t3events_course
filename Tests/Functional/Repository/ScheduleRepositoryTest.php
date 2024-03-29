<?php

namespace CPSIT\T3eventsCourse\Tests\Functional\Repository;

use CPSIT\T3eventsCourse\Domain\Model\Dto\ScheduleDemand;
use CPSIT\T3eventsCourse\Domain\Repository\ScheduleRepository;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

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

/**
 * Class ScheduleRepositoryTest
 * Functional tests for CPSIT\T3eventsCourse\Domain\Repository\ScheduleRepository
 */
class ScheduleRepositoryTest extends FunctionalTestCase  {

    /** @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface The object manager */
    protected $objectManager;

    /**
     * @var ScheduleRepository
     */
    protected $scheduleRepository;

    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/t3events', 'typo3conf/ext/t3events_course'];


    /**
     * set up
     */
    public function setUp()
    {
        parent::setUp();
        $this->objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        $this->scheduleRepository = $this->objectManager->get(ScheduleRepository::class);
        $this->importDataSet(__DIR__ . '/../Fixtures/schedules.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/courses.xml');
    }

    /**
     * @test
     */
    public function findSchedulesByGenre()
    {
        $this->markTestSkipped();
        /** @var ScheduleDemand $scheduleDemand */
        $scheduleDemand = $this->objectManager->get(ScheduleDemand::class);
        $scheduleDemand->setGenres('1');
        $scheduleDemand->setStoragePages('1');

        /** @var QueryResultInterface $schedules */
        $schedules = $this->scheduleRepository->findDemanded($scheduleDemand);
        $this->assertEquals(
            $schedules->getFirst()->getEvent()->getHeadline(),
            'courseWithGenre1'
        );
    }
}
