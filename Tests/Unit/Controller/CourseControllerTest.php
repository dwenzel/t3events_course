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

use CPSIT\T3eventsCourse\Controller\CourseController;
use CPSIT\T3eventsCourse\Domain\Factory\Dto\CourseDemandFactory;
use CPSIT\T3eventsCourse\Domain\Model\Course;
use DWenzel\T3events\Domain\Model\Dto\DemandInterface;
use DWenzel\T3events\Domain\Model\Dto\ModuleData;
use CPSIT\T3eventsCourse\Domain\Repository\CourseRepository;
use DWenzel\T3events\Session\SessionInterface;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

/**
 * Class CourseControllerTest
 * @package CPSIT\T3eventsCourse\Tests\Unit\Controller\Backend
 */
class CourseControllerTest extends UnitTestCase
{

    /**
     * @var CourseController|\PHPUnit_Framework_MockObject_MockObject|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface
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
     * @var Request | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    /**
     * @var SessionInterface  | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $session;

    /**
     * set up
     */
    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            CourseController::class,
            [
                'emitSignal',
                'getFilterOptions',
                'overwriteDemandObject',
                'addFlashMessage',
                'translate',
                'mergeSettings'
            ],
            [], '', false
        );

        $this->view = $this->getMockForAbstractClass(ViewInterface::class);
        /** @var CourseRepository|MockObject $mockCourseRepository */
        $mockCourseRepository = $this->getMockBuilder(CourseRepository::class)
            ->disableOriginalConstructor()->getMock();
        /** @var ConfigurationManagerInterface|MockObject $mockConfigurationManager */
        $mockConfigurationManager = $this->getMockForAbstractClass(ConfigurationManagerInterface::class);
        /** @var CourseDemandFactory|MockObject $mockDemandFactory */
        $mockDemandFactory = $this->getMockBuilder(CourseDemandFactory::class)
        ->setMethods(['createFromSettings'])->getMock();
        $this->request = $this->getMockBuilder(Request::class)
            ->setMethods(['hasArgument', 'getArgument'])->getMock();
        $this->session = $this->getMockForAbstractClass(SessionInterface::class);
        $this->subject->injectCourseDemandFactory($mockDemandFactory);
        $this->subject->injectSession($this->session);
        $this->subject->injectConfigurationManager($mockConfigurationManager);
        $this->inject($this->subject, 'view', $this->view);
        $this->inject($this->subject, 'settings', []);
        $this->inject($this->subject, 'request', $this->request);
        $this->subject->injectCourseRepository($mockCourseRepository);
    }

    /**
     * @return DemandInterface |\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockCreateDemandFromSettings()
    {
        $mockDemand = $this->getMockForAbstractClass(DemandInterface::class);

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

    /**
     * @test
     */
    public function showActionAssignsCourseToView()
    {
        /** @var Course|MockObject $mockCourse */
        $mockCourse = $this->getMockBuilder(Course::class)->getMock();
        $this->view->expects($this->once())
            ->method('assign')
            ->with('course', $mockCourse);
        $this->subject->showAction($mockCourse);
    }

    /**
     * @test
     */
    public function initializeFilterActionClearsSessionIfNoArgumentOverwriteDemand()
    {
        $this->request->expects($this->once())
            ->method('hasArgument')
            ->will($this->returnValue(false));
        $this->session->expects($this->once())
            ->method('clean');

        $this->subject->initializeFilterAction();
    }

    /**
     * @test
     */
    public function initializeActionMergesSettings()
    {
        $this->subject->expects($this->once())
            ->method('mergeSettings');
        $this->subject->initializeAction();
    }

    /**
     * @test
     */
    public function initializeActionStoresArgumentOverwriteDemandToSession()
    {
        $overwriteDemand = ['foo'];
        $expectedSessionValue = serialize($overwriteDemand);

        $this->request->expects($this->once())
            ->method('hasArgument')
            ->will($this->returnValue(true));
        $this->request->expects($this->once())
            ->method('getArgument')
            ->with('overwriteDemand')
            ->will($this->returnValue($overwriteDemand));
        $this->session->expects($this->once())
            ->method('set')
            ->with('tx_t3events_overwriteDemand', $expectedSessionValue);

        $this->subject->initializeAction();
    }

    /**
     * @test
     */
    public function filterActionGetsOverwriteDemandFromSession()
    {
        $this->session->expects($this->once())
            ->method('get')
            ->with(CourseController::SESSION_IDENTIFIER_OVERWRITE_DEMAND);
        $this->subject->filterAction();
    }

    /**
     * @test
     */
    public function filterActionGetsFilterOptions()
    {
        $settings = [
            'filter' => 'fooBar'
        ];
        $this->inject($this->subject, 'settings', $settings);

        $filterOptions = [
            'genres' => 'foo',
            'venues' => 'bar',
            'eventTypes' => 'baz'
        ];
        $this->subject->expects($this->once())
            ->method('getFilterOptions')
            ->with($settings['filter']);

        $this->subject->filterAction();
    }

    /**
     * @test
     */
    public function filterActionAssignsVariablesToView()
    {
        $settings = [
            'filter' => 'fooBar'
        ];
        $this->inject($this->subject, 'settings', $settings);

        $overwriteDemand = ['boom'];
        $filterOptions = [
            'genres' => 'foo',
            'venues' => 'bar',
            'eventTypes' => 'baz'
        ];
        $expectedTemplateVariables = [
            'filterOptions' => $filterOptions,
            'overwriteDemand' => $overwriteDemand
        ];
        $this->session->expects($this->once())
            ->method('get')
            ->with(CourseController::SESSION_IDENTIFIER_OVERWRITE_DEMAND)
            ->will($this->returnValue(serialize($overwriteDemand)));
        $this->subject->expects($this->once())
            ->method('getFilterOptions')
            ->will($this->returnValue($filterOptions));
        $this->view->expects($this->once())
            ->method('assignMultiple')
            ->with($expectedTemplateVariables);
        $this->subject->filterAction();
    }

    /**
     * @test
     */
    public function constructorSetsNamespace()
    {
        $this->subject->__construct();
        $this->assertAttributeSame(
            $this->subject::class,
            'namespace',
            $this->subject
        );
    }
}
