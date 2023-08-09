<?php
namespace CPSIT\T3eventsCourse\Controller;

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

use CPSIT\T3eventsCourse\Domain\Model\Course;
use DWenzel\T3events\Controller\CategoryRepositoryTrait;
use DWenzel\T3events\Controller\DemandTrait;
use DWenzel\T3events\Controller\EntityNotFoundHandlerTrait;
use DWenzel\T3events\Controller\EventTypeRepositoryTrait;
use DWenzel\T3events\Controller\FilterableControllerInterface;
use DWenzel\T3events\Controller\FilterableControllerTrait;
use DWenzel\T3events\Controller\GenreRepositoryTrait;
use DWenzel\T3events\Controller\SearchTrait;
use DWenzel\T3events\Controller\SessionTrait;
use DWenzel\T3events\Controller\SettingsUtilityTrait;
use DWenzel\T3events\Controller\TranslateTrait;
use DWenzel\T3events\Controller\VenueRepositoryTrait;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class CourseController
 * @package CPSIT\T3eventsCourse\Controller
 */
class CourseController extends ActionController
    implements FilterableControllerInterface
{
    use  CourseDemandFactoryTrait, CourseRepositoryTrait,
        CategoryRepositoryTrait, DemandTrait,
        EventTypeRepositoryTrait, EntityNotFoundHandlerTrait,
        FilterableControllerTrait, GenreRepositoryTrait,
        SearchTrait, SessionTrait, SettingsUtilityTrait,
        TranslateTrait, VenueRepositoryTrait;

    /**
     * @const COURSE_LIST_ACTION To be used when emitting signal.
     */
    final public const COURSE_LIST_ACTION = 'listAction';

    /**
     * @const SESSION_IDENTIFIER_OVERWRITE_DEMAND Identifier for saving overwriteDemand in session:
     */
    final public const SESSION_IDENTIFIER_OVERWRITE_DEMAND = 'tx_t3events_overwriteDemand';

    /**
     * @const EXTENSION_KEY
     */
    final public const EXTENSION_KEY = 't3events_course';

    /**
     * CourseController constructor.
     */
    public function __construct()
    {
        $this->namespace = static::class;
    }

    /**
     * initializes all actions
     */
    public function initializeAction()
    {
        $this->settings = $this->mergeSettings();
        if ($this->request->hasArgument('overwriteDemand')) {
            //todo use class name or plugin namespace (see PerformanceController)
            $this->session->set(
                self::SESSION_IDENTIFIER_OVERWRITE_DEMAND,
                serialize($this->request->getArgument('overwriteDemand'))
            );
        }
    }

    /**
     * initializes filter action
     */
    public function initializeFilterAction()
    {
        if (!$this->request->hasArgument('overwriteDemand')) {
            $this->session->clean();
        }
    }

    /**
     * action list
     *
     * @param array $overwriteDemand
     * @return void
     */
    public function listAction($overwriteDemand = null)
    {
        $demand = $this->demandFactory->createFromSettings($this->settings);
        $this->overwriteDemandObject($demand, $overwriteDemand);

        $courses = $this->courseRepository->findDemanded($demand);

        if ($courses instanceof QueryResultInterface && !$courses->count()) {
            $this->addFlashMessage(
                $this->translate('message.noCoursesFound.text', 't3events_course'),
                $this->translate('message.noCoursesFound.title', 't3events_course'),
                FlashMessage::WARNING
            );
        }
        $configuration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        $templateVariables = [
            'courses' => $courses,
            'demand' => $demand,
            'settings' => $this->settings,
            'storagePid' => $configuration['persistence']['storagePid']
        ];

        $this->emitSignal(self::class, self::COURSE_LIST_ACTION, $templateVariables);

        $this->view->assignMultiple($templateVariables);
    }

    /**
     * action show
     *
     * @return void
     */
    public function showAction(Course $course)
    {
        $this->view->assign('course', $course);
    }

    /**
     * filter action
     *
     * @return void
     */
    public function filterAction()
    {
        $overwriteDemand = unserialize($this->session->get(self::SESSION_IDENTIFIER_OVERWRITE_DEMAND));
        $filterOptions = [];
        if (isset($this->settings['filter'])) {
            $filterOptions = $this->getFilterOptions($this->settings['filter']);
        }
        $this->view->assignMultiple(
            [
                'filterOptions' => $filterOptions,
                'overwriteDemand' => $overwriteDemand
            ]
        );
    }

    /**
     * Create Demand from Settings
     * This method is only for backwards compatibility
     *
     * @param array $settings
     * @deprecated Use CourseDemandFactoryTrait with $this->demandFactory->createFromSettings instead
     */
    protected function createDemandFromSettings($settings): \CPSIT\T3eventsCourse\Domain\Model\Dto\CourseDemand|\DWenzel\T3events\Domain\Model\Dto\DemandInterface
    {
        return $this->demandFactory->createFromSettings($settings);
    }
}

