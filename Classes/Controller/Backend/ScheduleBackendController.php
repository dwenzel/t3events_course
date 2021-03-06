<?php
namespace CPSIT\T3eventsCourse\Controller\Backend;

use DWenzel\T3events\Controller\Backend\BackendViewTrait;
use DWenzel\T3events\Controller\Backend\FormTrait;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Extbase\Mvc\ResponseInterface;
use DWenzel\T3events\Controller\ModuleDataTrait;
use DWenzel\T3events\Controller\PerformanceController;
use DWenzel\T3events\Controller\SettingsUtilityTrait;

/**
 * Class ScheduleBackendController
 *
 * @package CPSIT\T3eventsCourse\Controller
 */
class ScheduleBackendController extends PerformanceController
{
    use ModuleDataTrait, SettingsUtilityTrait, BackendViewTrait, FormTrait;

    /**
     * BackendTemplateContainer
     *
     * @var BackendTemplateView
     */
    protected $view;

    /**
     * @var string Class name of the view instance which shall be injected
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

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
        $demand = $this->createDemandFromSettings($this->settings);
        $filterOptions = $this->getFilterOptions(
            $this->settings['filter']
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
            'settings' => $this->settings,
            'filterOptions' => $filterOptions
        ];

        $this->emitSignal(__CLASS__, self::PERFORMANCE_LIST_ACTION, $templateVariables);
        $this->view->assignMultiple($templateVariables);
    }

    /**
     * @return ConfigurationManagerInterface
     */
    public function getConfigurationManager()
    {
        return $this->configurationManager;
    }

}
