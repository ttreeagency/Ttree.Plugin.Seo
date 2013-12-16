<?php
namespace Ttree\Plugin\Seo\TypoScript;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Ttree.Plugin.Seo".      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Ttree\Plugin\Seo\Browser;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\TypoScript\TypoScriptObjects\AbstractTypoScriptObject;

/**
 * @Flow\Scope("prototype")
 */
class RichSnippetsImplementation extends AbstractTypoScriptObject {

	/**
	 * @Flow\Inject
	 * @var Browser
	 */
	protected $browser;

	/**
	 * @var string
	 */
	protected $page;

	/**
	 * @param string $page
	 */
	public function setPage($page) {
		$this->page = $page;
	}

	/**
	 * Just return the processed value
	 *
	 * @return mixed
	 */
	public function evaluate() {
		$pageContent = $this->tsValue('page');
		$browser = $this->browser->getBrowser();
		$response = $browser->request('http://www.google.com/webmasters/tools/richsnippets/upload', 'POST', array(
			'html' => $pageContent
		), array(), array('HTTP_CONTENT_TYPE' => 'multipart/form-data'));

		return $response->getContent();
		
	}
}