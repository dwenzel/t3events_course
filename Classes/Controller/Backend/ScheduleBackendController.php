<?php
namespace CPSIT\T3eventsCourse\Controller\Backend;

use DWenzel\T3events\Controller\Backend\BackendViewTrait;
use DWenzel\T3events\Controller\Backend\FormTrait;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use DWenzel\T3events\Controller\ModuleDataTrait;
use DWenzel\T3events\Controller\PerformanceController;
use DWenzel\T3events\Controller\SettingsUtilityTrait;
use DWenzel\T3events\Pagination\NumberedPagination;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

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
     */
    public function processRequest(RequestInterface $request): ResponseInterface
    {
        $this->moduleData = $this->moduleDataStorageService->loadModuleData($this->getModuleKey());

        try {
            $response = parent::processRequest($request);
        } catch (StopActionException $e) {
            throw $e;
        }

        $this->moduleDataStorageService->persistModuleData($this->moduleData, $this->getModuleKey());
        return $response;
    }

    /**
     * action list
     *
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

        $performances = $this->performanceRepository->findDemanded($demand);

        // pagination
        $paginationConfiguration = $this->settings['event']['list']['paginate'] ?? [];
        $itemsPerPage = (int)(($paginationConfiguration['itemsPerPage'] ?? '') ?: 25);
        $maximumNumberOfLinks = (int)($paginationConfiguration['maximumNumberOfLinks'] ?? 0);
        
        $currentPage = max(1, $this->request->hasArgument('currentPage') ? (int)$this->request->getArgument('currentPage') : 1);
        #$paginator = new ArrayPaginator($contacts->toArray(), $currentPage, $itemsPerPage);
        $paginator = GeneralUtility::makeInstance(QueryResultPaginator::class, $performances, $currentPage, $itemsPerPage, (int)($this->settings['limit'] ?? 0), (int)($this->settings['offset'] ?? 0));
        $paginationClass = $paginationConfiguration['class'] ?? NumberedPagination::class;
        #$pagination = new SimplePagination($paginator);
        $pagination = $this->getPagination($paginationClass, $maximumNumberOfLinks, $paginator);

        $templateVariables = [
            'paginator' => $paginator,
            'pagination' => $pagination,
            'performances' => $this->performanceRepository->findDemanded($demand),
            'overwriteDemand' => $overwriteDemand,
            'demand' => $demand,
            'settings' => $this->settings,
            'filterOptions' => $filterOptions,
            'module' => 'T3eventsEvents_T3Course',
        ];

        $this->emitSignal(self::class, self::PERFORMANCE_LIST_ACTION, $templateVariables);
        $this->view->assignMultiple($templateVariables);
    }

    /**
     * @return ConfigurationManagerInterface
     */
    public function getConfigurationManager()
    {
        return $this->configurationManager;
    }

    

    /**
     * @param $paginationClass
     * @param int $maximumNumberOfLinks
     * @param $paginator
     * @return \#o#Э#A#M#C\GeorgRinger\News\Controller\NewsController.getPagination.0|NumberedPagination|mixed|\Psr\Log\LoggerAwareInterface|string|SimplePagination|\TYPO3\CMS\Core\SingletonInterface
     */
    protected function getPagination($paginationClass, int $maximumNumberOfLinks, $paginator)
    {
        if (class_exists(NumberedPagination::class) && $paginationClass === NumberedPagination::class && $maximumNumberOfLinks) {
            $pagination = GeneralUtility::makeInstance(NumberedPagination::class, $paginator, $maximumNumberOfLinks);
        } elseif (class_exists($paginationClass)) {
            $pagination = GeneralUtility::makeInstance($paginationClass, $paginator);
        } else {
            $pagination = GeneralUtility::makeInstance(SimplePagination::class, $paginator);
        }
        return $pagination;
    }

}
