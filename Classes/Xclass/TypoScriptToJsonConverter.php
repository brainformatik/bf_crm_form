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
 * Class TypoScriptToJsonConverter
 * @package Brainformatik\BfCrmForm\Xclass
 */
class TypoScriptToJsonConverter extends \TYPO3\CMS\Form\Utility\TypoScriptToJsonConverter {

    /**
     * Create element by loading class and instantiating the object
     *
     * @param string $class Type of element
     * @param array $arguments Configuration array
     * @return \TYPO3\CMS\Form\Domain\Model\Json\AbstractJsonElement
     */
    public function createElement($class, array $arguments = array()) {
        $object = parent::createElement($class, $arguments);

        if (isset($arguments['crmfield.']) && is_array($arguments['crmfield.'])) {
            $crmfield = $arguments['crmfield.'];
            foreach ($crmfield as $key => $value) {
                $object->configuration['crmfield'][$key] = $value;
            }
        }

        return $object;
    }
}