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

use TYPO3\Eel\Helper\StringHelper;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Utility\Unicode\Functions;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\TypoScript\TypoScriptObjects\AbstractTypoScriptObject;

/**
 * A Document Teaser Implementation
 *
 * @Flow\Scope("prototype")
 */
class DocumentTeaserImplementation extends AbstractTypoScriptObject {

	/**
	 * @var NodeInterface
	 */
	protected $documentNode;

	/**
	 * @var array
	 */
	protected $contentNodes;

	/**
	 * @var integer
	 */
	protected $maximumCharacters;

	/**
	 * @var string
	 */
	protected $suffix;

	/**
	 * @var array
	 */
	protected $nodeTypes;

	/**
	 * @param \TYPO3\TYPO3CR\Domain\Model\NodeInterface $documentNode
	 */
	public function setDocumentNode($documentNode) {
		$this->documentNode = $documentNode;
	}

	/**
	 * @param array $contentNode
	 */
	public function setContentNodes(array $contentNode) {
		$this->contentNodes = $contentNode;
	}

	/**
	 * @param int $maxCharacters
	 */
	public function setMaximumCharacters($maxCharacters) {
		$this->maximumCharacters = $maxCharacters;
	}

	/**
	 * @param string $suffix
	 */
	public function setSuffix($suffix) {
		$this->suffix = $suffix;
	}

	/**
	 * @param array $nodeTypes
	 */
	public function setNodeTypes($nodeTypes) {
		$this->nodeTypes = $nodeTypes;
	}

	/**
	 * Just return the processed value
	 *
	 * @return mixed
	 */
	public function evaluate() {
		$stringToTruncate = '';
		$maximumCharacters = $this->tsValue('maximumCharacters') ?: 600;

		foreach ($this->tsValue('contentNodes') as $contentNode) {
			/** @var NodeInterface $contentNode */
			foreach ($contentNode->getProperties() as $propertyValue) {
				if (!is_object($propertyValue) || method_exists($propertyValue, '__toString')) {
					$stringToTruncate .= (string)$propertyValue;
				}
				if (Functions::strlen($stringToTruncate) > $maximumCharacters) {
					break;
				}
			}
		}
		$stringToTruncate = $this->stripUnwantedTags($stringToTruncate);
		$stringHelper = new StringHelper();

		return $stringHelper->cropAtWord($stringToTruncate, $maximumCharacters, $this->tsValue('suffix'));
	}

	/**
	 * @param string $content The original content
	 * @return string The stripped content
	 */
	protected function stripUnwantedTags($content) {
		$content = strip_tags($content);
		$content = str_replace('&nbsp;', ' ', $content);

		return trim($content);
	}
}
