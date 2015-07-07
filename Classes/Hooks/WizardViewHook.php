<?php
namespace Brainformatik\BfCrmForm\Hooks;

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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Class WizardViewHook
 * @package Brainformatik\BfCrmForm\Hooks
 */
class WizardViewHook {

    /**
     * @var \TYPO3\CMS\Form\View\Wizard\WizardView
     */
    protected $wizardView;

    /**
     * Initialization
     *
     * @param array                                  $params
     * @param \TYPO3\CMS\Form\View\Wizard\WizardView $wizardView
     */
    public function initialize($params, $wizardView) {
        $this->wizardView = $wizardView;
        $this->loadLocalization();
        $this->loadJavascript();
    }

    /**
     * Load localization
     */
    public function loadLocalization() {
        $wizardLabels = $GLOBALS['LANG']->includeLLFile('EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf', false, true);
        $this->wizardView->doc->getPageRenderer()->addInlineLanguageLabelArray($wizardLabels['default']);
    }

    /**
     * Load javascript
     */
    public function loadJavascript() {
        $baseUrl = ExtensionManagementUtility::extRelPath('bf_crm_form') . 'Resources/Public/JavaScript/Wizard/';
        $javascriptFiles = [
            'Viewport/Left/Options/Panel.js',
            'Viewport/Left/Options/Forms/Crmfield.js',
            'Viewport/Left/Form/PostProcessors/Crmpush.js',
        ];

        foreach ($javascriptFiles as $javascriptFile) {
            $this->wizardView->doc->getPageRenderer()->addJsFile($baseUrl . $javascriptFile, 'text/javascript', true, false);
        }
    }
}