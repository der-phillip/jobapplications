<?php
	/***************************************************************
	 *  Copyright notice
	 *
	 *  (c) 2019
	 *  All rights reserved
	 *
	 *  This script is part of the TYPO3 project. The TYPO3 project is
	 *  free software; you can redistribute it and/or modify
	 *  it under the terms of the GNU General Public License as published by
	 *  the Free Software Foundation; either version 3 of the License, or
	 *  (at your option) any later version.
	 *
	 *  The GNU General Public License can be found at
	 *  http://www.gnu.org/copyleft/gpl.html.
	 *
	 *  This script is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 *  GNU General Public License for more details.
	 *
	 *  This copyright notice MUST APPEAR in all copies of the script!
	 ***************************************************************/

	namespace ITX\Jobapplications\Widgets;

	use ITX\Jobapplications\Domain\Model\Posting;
	use ITX\Jobapplications\Domain\Repository\ApplicationRepository;
	use TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException;
	use TYPO3\CMS\Backend\Routing\UriBuilder;
	use TYPO3\CMS\Core\Utility\DebugUtility;
	use TYPO3\CMS\Dashboard\Widgets\AbstractBarChartWidget;

	/**
	 * Class ApplicationsPerPostingBarChart
	 *
	 * @package ITX\Jobapplications\Widgets
	 */
	class ApplicationsPerPostingBarChart extends AbstractBarChartWidget
	{
		/** @var string */
		protected $title = 'LLL:EXT:jobapplications/Resources/Private/Language/locallang_backend.xlf:be.widget.applications_per_posting.title';

		/** @var string */
		protected $description = 'LLL:EXT:jobapplications/Resources/Private/Language/locallang_backend.xlf:be.widget.applications_per_posting.description';

		/** @var string  */
		protected $buttonText = 'LLL:EXT:jobapplications/Resources/Private/Language/locallang_backend.xlf:be.widget.applications_per_posting.button';

		/** @var array */
		protected $labels = [];

		/**
		 * @var int
		 */
		protected $width = 4;

		/**
		 * @var int
		 */
		protected $height = 4;

		public function initializeView(): void
		{
			if (!$GLOBALS['BE_USER']->check('modules', 'web_jobapplications_backend'))
			{
				parent::initializeView();

				return;
			}

			/** @var UriBuilder $uriBuilder */
			$uriBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(UriBuilder::class);

			try
			{
				$this->buttonLink = $uriBuilder->buildUriFromRoute('web_JobapplicationsBackend', [
					'tx_jobapplications_web_jobapplicationsbackend[submit]' => 'Filter',
					'tx_jobapplications_web_jobapplicationsbackend[action]' => 'listApplications',
					'tx_jobapplications_web_jobapplicationsbackend[controller]' => 'Backend'
				]);
			}
			catch (RouteNotFoundException $e)
			{
				$this->buttonLink = null;
				$this->buttonText = null;
			}
			parent::initializeView();
		}

		/**
		 * @inheritDoc
		 * @throws \TYPO3\CMS\Extbase\Object\Exception
		 */
		protected function prepareChartData(): void
		{
			/** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectmanager */
			$objectmanager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);

			/** @var \ITX\Jobapplications\Domain\Repository\PostingRepository $postingRepo */
			$postingRepo = $objectmanager->get(\ITX\Jobapplications\Domain\Repository\PostingRepository::class);

			/** @var ApplicationRepository $applicationRepo */
			$applicationRepo = $objectmanager->get(ApplicationRepository::class);

			$postings = $postingRepo->findAllIncludingHiddenAndDeleted();

			$data = [];

			/** @var Posting $posting */
			foreach ($postings as $posting)
			{
				$applicationCount = $applicationRepo->findByPostingIncludingHiddenAndDeleted($posting->getUid())->count();
				$this->labels[] = $posting->getTitle();
				$data[] = $applicationCount;
			}

			$this->chartData = [
				'labels' => $this->labels,
				'datasets' => [
					[
						'label' => $this->getLanguageService()->sL('LLL:EXT:jobapplications/Resources/Private/Language/locallang_backend.xlf:be.widget.applications_per_posting.label'),
						'backgroundColor' => '#E62E29',
						'border' => 0,
						'data' => $data
					]
				]
			];
		}
	}