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

use TYPO3\CMS\Form\Domain\Model\Element\AbstractElement;

/**
 * Class TypoScriptFactory
 * @package Brainformatik\BfCrmForm\Xclass
 */
class TypoScriptFactory extends \TYPO3\CMS\Form\Domain\Factory\TypoScriptFactory {

    /**
     * Reconstitutes the domain model of the accordant element
     *
     * @param \TYPO3\CMS\Form\Domain\Model\Element\AbstractElement $element
     * @param array                                                $arguments Configuration array
     *
     * @return void
     */
    protected function reconstituteElement(AbstractElement $element, array $arguments = []) {
        if (isset($arguments['crmfield.'])) {
            $element->setAdditional('crmfield', 'TEXT', $arguments['crmfield.']);
        }

        parent::reconstituteElement($element, $arguments);
    }
}