<?php
namespace CPSIT\T3eventsCourse\Tests\Unit\Controller\Backend;

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

use ApacheSolrForTypo3\Solr\System\Configuration\ConfigurationManager;
use CPSIT\T3eventsCourse\Controller\Backend\CourseBackendController;
use CPSIT\T3eventsCourse\Domain\Factory\Dto\CourseDemandFactory;
use DWenzel\T3events\Domain\Model\Dto\DemandInterface;
use DWenzel\T3events\Domain\Model\Dto\ModuleData;
use CPSIT\T3eventsCourse\Domain\Repository\CourseRepository;
use Nimut\TestingFramework\MockObject\AccessibleMockObjectInterface;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

/**
 * Class CourseBackendControllerTest
 * @package CPSIT\T3eventsCourse\Tests\Unit\Controller\Backend
 */
class CourseBackendControllerTest extends UnitTestCase {

    /**
     * @var CourseBackendController|\PHPUnit_Framework_MockObject_MockObject|AccessibleMockObjectInterface
     */
    protected $subject;

    /**
     * @var ModuleData | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $moduleData;

    /**
     * @var ViewInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $view;

    /**
     * set up
     */
    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            CourseBackendController::class,
            ['emitSignal', 'getFilterOptions', 'overwriteDemandObject', 'addFlashMessage', 'translate'],
            [], '', false
        );
        $this->view = $this->getMockForAbstractClass(ViewInterface::class);
        $this->moduleData = $this->getMockBuilder(ModuleData::class)->getMock();
        /** @var CourseRepository|MockObject $mockCourseRepository */
        $mockCourseRepository = $this->getMockBuilder(CourseRepository::class)
            ->disableOriginalConstructor()->getMock();
        /** @var ConfigurationManagerInterface|MockObject $mockConfigurationManager */
        $mockConfigurationManager = $this->getMockForAbstractClass(ConfigurationManagerInterface::class);
        /** @var CourseDemandFactory|MockObject $mockDemandFactory */
        $mockDemandFactory = $this->getMockBuilder(CourseDemandFactory::class)
            ->setMethods(['createFromSettings'])
            ->getMock();
        $this->subject->injectCourseDemandFactory($mockDemandFactory);
        $this->subject->injectConfigurationManager($mockConfigurationManager);
        $this->inject(
            $this->subject,
            'view',
            $this->view
        );
        $this->inject(
            $this->subject,
            'moduleData',
            $this->moduleData
        );
        $this->inject(
            $this->subject,
            'settings',
            []
        );
        $this->subject->injectCourseRepository($mockCourseRepository);
    }

    /**
     * @return DemandInterface |\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockCreateDemandFromSettings()
    {
        $mockDemand = $this->getMockForAbstractClass(
            DemandInterface::class
        );

        /** @var CourseDemandFactory| \PHPUnit_Framework_MockObject_MockObject $demandFactory */
        $demandFactory = $this->subject->_get('demandFactory');
        $demandFactory->expects($this->once())
            ->method('createFromSettings')
            ->will($this->returnValue($mockDemand));

        return $mockDemand;
    }

    /**
     * @test
     */
    public function listActionCreatesDemandFromSettings()
    {

        $settings = [
            'filter' => []
        ];
        $mockDemand = $this->getMockForAbstractClass(
            DemandInterface::class
        );

        $this->inject(
            $this->subject,
            'settings',
            $settings
        );

        /** @var CourseDemandFactory| \PHPUnit_Framework_MockObject_MockObject $demandFactory */
        $demandFactory = $this->subject->_get('demandFactory');
        $demandFactory->expects($this->once())
            ->method('createFromSettings')
            ->with($settings)
            ->will($this->returnValue($mockDemand));

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function listActionGetsOverwriteDemandFromModuleData()
    {
        $this->mockCreateDemandFromSettings();
        $this->moduleData->expects($this->once())
            ->method('getOverwriteDemand');
        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function listActionSetsOverwriteDemandOnModuleData()
    {
        $overwriteDemand = ['foo'];
        $this->mockCreateDemandFromSettings();
        $this->moduleData->expects($this->once())
            ->method('setOverwriteDemand')
            ->with($overwriteDemand);

        $this->subject->listAction($overwriteDemand);
    }

    /**
     * @test
     */
    public function listActionOverwritesDemandObject()
    {
        $mockDemandObject = $this->mockCreateDemandFromSettings();
        $overwriteDemand = ['foo'];
        $this->subject->expects($this->once())
            ->method('overwriteDemandObject')
            ->with($mockDemandObject, $overwriteDemand);

        $this->subject->listAction($overwriteDemand);
    }

    /**
     * @test
     */
    public function listActionEmitsSignal()
    {
        $this->mockCreateDemandFromSettings();

        // todo can not match expectedTemplateVariables - always got an array containing all arguments as third argument.
        $this->subject->expects($this->once())
            ->method('emitSignal');

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function listActionAssignsTemplateVariablesToView()
    {
        $demandObject = $this->mockCreateDemandFromSettings();

        $expectedTemplateVariables = [
            'courses' => null,
            'overwriteDemand' => null,
            'demand' => $demandObject,
            'settings' => null,
            'filterOptions' => null
        ];

        // todo can not match expectedTemplateVariables as soon as method 'emitSignal' is called.
        $this->view->expects($this->once())
            ->method('assignMultiple');
        $this->subject->listAction();
    }

}
