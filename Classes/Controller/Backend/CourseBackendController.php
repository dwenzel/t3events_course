<?php

namespace CPSIT\T3eventsCourse\Controller\Backend;

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
use CPSIT\T3eventsCourse\Controller\CourseRepositoryTrait;
use DWenzel\T3events\CallStaticTrait;
use DWenzel\T3events\Controller\AbstractBackendController;
use DWenzel\T3events\Controller\AudienceRepositoryTrait;
use DWenzel\T3events\Controller\Backend\BackendViewTrait;
use DWenzel\T3events\Controller\Backend\FormTrait;
use DWenzel\T3events\Controller\CategoryRepositoryTrait;
use DWenzel\T3events\Controller\CompanyRepositoryTrait;
use DWenzel\T3events\Controller\DemandTrait;
use DWenzel\T3events\Controller\EventTypeRepositoryTrait;
use DWenzel\T3events\Controller\FilterableControllerInterface;
use DWenzel\T3events\Controller\FilterableControllerTrait;
use DWenzel\T3events\Controller\GenreRepositoryTrait;
use DWenzel\T3events\Controller\ModuleDataTrait;
use DWenzel\T3events\Controller\PersistenceManagerTrait;
use DWenzel\T3events\Controller\SearchTrait;
use DWenzel\T3events\Controller\SettingsUtilityTrait;
use DWenzel\T3events\Controller\SignalTrait;
use DWenzel\T3events\Controller\TranslateTrait;
use DWenzel\T3events\Controller\VenueRepositoryTrait;
use DWenzel\T3events\Domain\Model\Dto\ButtonDemand;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class CourseBackendController
 *
 * @package CPSIT\T3eventsCourse\Controller\Backend
 */
class CourseBackendController
    extends AbstractBackendController
    implements FilterableControllerInterface
{
    use AudienceRepositoryTrait, BackendViewTrait, CallStaticTrait,
        CategoryRepositoryTrait, CompanyRepositoryTrait, CourseRepositoryTrait,
        CourseDemandFactoryTrait, DemandTrait, EventTypeRepositoryTrait,
        FilterableControllerTrait, FormTrait, GenreRepositoryTrait,
        ModuleDataTrait, PersistenceManagerTrait, SearchTrait,
        SettingsUtilityTrait, SignalTrait, TranslateTrait,
        VenueRepositoryTrait;

    const COURSE_LIST_ACTION = 'listAction';

    /**
     * @const EXTENSION_KEY
     */
    const EXTENSION_KEY = 't3events_course';

    protected $buttonConfiguration = [
        [
            ButtonDemand::TABLE_KEY => 'tx_t3events_domain_model_event',
            ButtonDemand::LABEL_KEY => 'button.newAction.course',
            ButtonDemand::ACTION_KEY => 'new',
            ButtonDemand::ICON_KEY => 'ext-t3events-event',
            ButtonDemand::OVERLAY_KEY => 'overlay-new',
            ButtonDemand::ICON_SIZE_KEY => Icon::SIZE_SMALL
        ]
    ];

    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     * action list
     *
     * @param array $overwriteDemand
     * @return void
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function listAction($overwriteDemand = null)
    {
        $demand = $this->demandFactory->createFromSettings($this->settings);

        if ($overwriteDemand === null) {
            $overwriteDemand = $this->moduleData->getOverwriteDemand();
        } else {
            $this->moduleData->setOverwriteDemand($overwriteDemand);
        }

        $this->overwriteDemandObject($demand, $overwriteDemand);
        $this->moduleData->setDemand($demand);

        $courses = $this->courseRepository->findDemanded($demand);

        if ($courses instanceof QueryResultInterface && !$courses->count()) {
            $this->addFlashMessage(
                $this->translate('message.noCoursesFound.text'),
                $this->translate('message.noCoursesFound.title'),
                FlashMessage::WARNING
            );
        }
        $configuration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );
        $templateVariables = [
            'courses' => $courses,
            'demand' => $demand,
            'overwriteDemand' => $overwriteDemand,
            'filterOptions' => $this->getFilterOptions($this->settings['filter']),
            'storagePid' => $configuration['persistence']['storagePid'],
            'settings' => $this->settings
        ];

        $this->emitSignal(__CLASS__, self::COURSE_LIST_ACTION, $templateVariables);
        $this->view->assignMultiple($templateVariables);
    }

    /**
     * Redirect to new record form
     */
    public function newAction()
    {
        $this->redirectToCreateNewRecord('tx_t3events_domain_model_event');
    }

    /**
     * @return ConfigurationManagerInterface
     */
    public function getConfigurationManager()
    {
        return $this->configurationManager;
    }
}
