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
use CPSIT\T3eventsCourse\Domain\Repository\CourseRepository;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use DWenzel\T3events\Controller\AbstractBackendController;
use DWenzel\T3events\Controller\FilterableControllerInterface;
use DWenzel\T3events\Controller\FilterableControllerTrait;

/**
 * Class CourseBackendController
 *
 * @package CPSIT\T3eventsCourse\Controller\Backend
 */
class CourseBackendController
	extends AbstractBackendController
	implements FilterableControllerInterface {
	use FilterableControllerTrait, CourseDemandFactoryTrait;

    const COURSE_LIST_ACTION = 'listAction';

	/**
	 * courseRepository
	 *
	 * @var \CPSIT\T3eventsCourse\Domain\Repository\CourseRepository
	 * @inject
	 */
	protected $courseRepository;

    /**
     * Injects the course repository
     *
     * @param CourseRepository $courseRepository
     */
    public function injectCourseRepository(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

	/**
	 * action list
	 *
	 * @param array $overwriteDemand
	 * @return void
	 */
	public function listAction($overwriteDemand = null) {
		$demand = $this->demandFactory->createFromSettings($this->settings);

		if ($overwriteDemand === null) {
			$overwriteDemand = $this->moduleData->getOverwriteDemand();
		} else {
			$this->moduleData->setOverwriteDemand($overwriteDemand);
		}

		$this->overwriteDemandObject($demand, $overwriteDemand);
		$this->moduleData->setDemand($demand);

		$courses = $this->courseRepository->findDemanded($demand);

		if (($courses instanceof QueryResultInterface AND !$courses->count())
			OR !count($courses)
		) {
			$this->addFlashMessage(
				$this->translate('message.noCoursesFound.text'),
				$this->translate('message.noCoursesFound.title'),
				FlashMessage::WARNING
			);
		}
		$configuration = $this->configurationManager->getConfiguration(
			ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
		);
        $templateVariables = 			[
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
	 * Create Demand from Settings
     * This method is only for backwards compatibility
	 *
	 * @param array $settings
	 * @return \DWenzel\T3events\Domain\Model\Dto\EventDemand
     * @deprecated Use CourseDemandFactoryTrait with $this->demandFactory->createFromSettings instead
	 */
	protected function createDemandFromSettings($settings) {
        return $this->demandFactory->createFromSettings($settings);
	}
}
