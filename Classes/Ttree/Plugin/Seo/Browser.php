<?php
namespace Ttree\Plugin\Seo;

/*                                                                        *
 * This script belongs to the Flow package "Ttree.Plugin.Seo".            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * @author  Dominique Feyer <dfeyer@ttree.ch>
 * @Flow\Scope("singleton")
 */
class Browser {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Http\Client\Browser
	 */
	protected $browser;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Http\Client\CurlEngine
	 */
	protected $browserRequestEngine;

	/**
	 * Initialize object
	 */
	public function initializeObject() {
		$this->browser->setRequestEngine($this->browserRequestEngine);
	}

	/**
	 * @return \TYPO3\Flow\Http\Client\Browser
	 */
	public function getBrowser() {
		return $this->browser;
	}
}

?>