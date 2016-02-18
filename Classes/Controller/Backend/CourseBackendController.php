<?php
namespace CPSIT\T3eventsCourse\Controller\Backend;

use CPSIT\T3eventsCourse\Domain\Model\Dto\CourseDemand;
use Webfox\T3events\Controller\AbstractBackendController;

/**
 * Class CourseBackendController
 *
 * @package CPSIT\T3eventsCourse\Controller\Backend
 */
class CourseBackendController extends AbstractBackendController {

	/**
	 * Create Demand from Settings
	 *
	 * @param \array $settings
	 * @return \Webfox\T3events\Domain\Model\Dto\EventDemand
	 */
	protected function createDemandFromSettings($settings) {
		$demand = $this->objectManager->get(CourseDemand::class);
		$demand->setSortBy('headline');
		return $demand;
	}
}
