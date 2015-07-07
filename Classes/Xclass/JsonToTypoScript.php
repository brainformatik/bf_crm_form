<?php
namespace Brainformatik\BfCrmForm\Xclass;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class JsonToTypoScript
 * @package Brainformatik\BfCrmForm\Xclass
 */
class JsonToTypoScript extends \TYPO3\CMS\Form\Domain\Factory\JsonToTypoScript {

    /**
     * Set configuration for crmfield
     *
     * @param array $element
     * @param array $parent
     * @param int   $elementCounter
     * @param bool  $childrenWithParentName
     */
    protected function setConfiguration(array $element, array &$parent, $elementCounter, $childrenWithParentName = false) {
        parent::setConfiguration($element, $parent, $elementCounter, $childrenWithParentName);

        if (isset($element['configuration']['crmfield'])) {
            $this->setCrmfield($element['configuration']['crmfield'], $parent, $elementCounter);
        }
    }

    /**
     * Set crmfield values
     *
     * @param array $crmfield
     * @param array $parent
     * @param int   $elementCounter
     */
    protected function setCrmfield(array $crmfield, array &$parent, $elementCounter) {
        if ($crmfield['value']) {
            $parent[$elementCounter . '.']['crmfield'] = [];
            foreach ($crmfield as $key => $value) {
                $parent[$elementCounter . '.']['crmfield'][$key] = $value;
            }
        }
    }
}