<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Georg Ringer <typo3@ringerge.org>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
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

/**
 * Get the translations of records
 *
 * @package TYPO3
 * @subpackage tx_insertrecordfix
 */
class user_insertrecordfix {

	/**
	 * Change the source of content element "Insert record" to get translated records
	 * 
	 * @param string $content
	 * @param array $conf
	 * @return string modificated list
	 */
	public function insertrecordfix($content, $conf) {

		if ($GLOBALS['TSFE']->sys_language_uid == 0) {
			return FALSE;
		}

		$newIds = array();
		$idSplit = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $this->cObj->data['records'], TRUE);

		// go through every item
		foreach ($idSplit as $oldId) {
			// split tt_content_123 into array('tt_content', 123)
			$tableIdSplit = \TYPO3\CMS\Backend\Utility\BackendUtility::splitTable_Uid($oldId);

			$oldId = (int) $tableIdSplit[1];
			if ($oldId > 0) {
				$translatedRecord = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
								'uid', $tableIdSplit[0], 'l18n_parent=' . $oldId . ' AND sys_language_uid=' . $GLOBALS['TSFE']->sys_language_uid . $this->cObj->enableFields($tableIdSplit[0])
				);

				// if a translation is found, override default
				if (is_array($translatedRecord[0])) {
					$oldId = $translatedRecord[0]['uid'];
				}
			}
			$newIds[] = $tableIdSplit[0] . '_' . $oldId;
		}

		return implode(',', $newIds);
	}

}


?>