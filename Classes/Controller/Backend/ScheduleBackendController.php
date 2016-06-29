<?php
namespace CPSIT\T3eventsCourse\Controller\Backend;

use Webfox\T3events\Controller\ModuleDataTrait;
use Webfox\T3events\Controller\PerformanceController;
use Webfox\T3events\Controller\SettingsUtilityTrait;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Extbase\Mvc\ResponseInterface;

/**
 * Class ScheduleBackendController
 *
 * @package CPSIT\T3eventsCourse\Controller
 */
class ScheduleBackendController extends PerformanceController {
	use ModuleDataTrait, SettingsUtilityTrait;

    /**
     * Load and persist module data
     *
     * @param \TYPO3\CMS\Extbase\Mvc\RequestInterface $request
     * @param \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function processRequest(RequestInterface $request, ResponseInterface $response)
    {
        $this->moduleData = $this->moduleDataStorageService->loadModuleData($this->getModuleKey());

        try {
            parent::processRequest($request, $response);
        } catch (StopActionException $e) {
            throw $e;
        }

        $this->moduleDataStorageService->persistModuleData($this->moduleData, $this->getModuleKey());
    }

    /**
     * action list
     *
     * @param array $overwriteDemand
     * @return void
     */
    public function listAction(array $overwriteDemand = null)
    {
        $demand = $this->createDemandFromSettings($this->settings[$this->settingsUtility->getControllerKey($this)]['list']);
        $filterOptions = $this->getFilterOptions(
            $this->settings[$this->settingsUtility->getControllerKey($this)]['list']['filter']
        );

        if ($overwriteDemand === null) {
            $overwriteDemand = $this->moduleData->getOverwriteDemand();
        } else {
            $this->moduleData->setOverwriteDemand($overwriteDemand);
        }

        $this->overwriteDemandObject($demand, $overwriteDemand);

        $templateVariables = [
                'performances' => $this->performanceRepository->findDemanded($demand),
                'overwriteDemand' => $overwriteDemand,
                'demand' => $demand,
                'filterOptions' => $filterOptions
            ];

        $this->emitSignal(__CLASS__, self::PERFORMANCE_LIST_ACTION, $templateVariables);
        $this->view->assignMultiple($templateVariables);
    }
}
