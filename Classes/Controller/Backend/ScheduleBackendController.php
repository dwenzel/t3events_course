<?php
namespace CPSIT\T3eventsCourse\Controller\Backend;

use Webfox\T3events\Controller\ModuleDataTrait;
use Webfox\T3events\Controller\PerformanceController;
use Webfox\T3events\Controller\SettingsUtilityTrait;

/**
 * Class ScheduleBackendController
 *
 * @package CPSIT\T3eventsCourse\Controller
 */
class ScheduleBackendController extends PerformanceController {
	use ModuleDataTrait, SettingsUtilityTrait;

	/**
	 * Create Demand from Settings
	 *
	 * @param array $settings
	 * @return \Webfox\T3events\Domain\Model\Dto\PerformanceDemand
	 */
	protected function createDemandFromSettings($settings) {
        $localSettings = [];
		$controllerKey = $this->settingsUtility->getControllerKey($this);
        if (isset($settings[$controllerKey]['list'])) {
            $localSettings = $settings[$controllerKey]['list'];
        }

        $demand = parent::createDemandFromSettings($localSettings);

        return $demand;
	}
}
