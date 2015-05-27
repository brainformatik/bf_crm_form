<?php
namespace TYPO3\CMS\Form\PostProcess;
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Utility\FormUtility;
use TYPO3\CMS\Form\Domain\Model\Form;

use Brainformatik\BfCrmForm\Service\PushService;

/**
 * Class CrmpushPostProcessor
 * @package TYPO3\CMS\Form\PostProcess
 */
class CrmpushPostProcessor implements \TYPO3\CMS\Form\PostProcess\PostProcessorInterface {

    /**
     * @var \TYPO3\CMS\Form\Domain\Model\Form
     */
    protected $form;

    /**
     * @var array
     */
    protected $typoScript;

    /**
     * @var \TYPO3\CMS\Form\Request
     */
    protected $requestHandler;

    /**
     * @var array
     */
    protected $dirtyHeaders = array();

    /**
     * @var \TYPO3\CMS\Form\Utility\FormUtility
     */
    protected $formUtility;

    /**
     * @var array
     */
    protected $_crmMetaData = array();

    /**
     * @var array
     */
    protected $_crmFormData = array();

    /**
     * @var array
     */
    protected $_allowedElementTypes = array(
        'textline', 'textarea', 'password', 'hidden', 'checkbox', 'checkboxgroup', 'radio', 'radiogroup', 'select'
    );

    /**
     * @param \TYPO3\CMS\Form\Domain\Model\Form $form Form domain model
     * @param array $typoScript Post processor TypoScript settings
     */
    public function __construct(Form $form, array $typoScript) {
        $this->form = $form;
        $this->typoScript = $typoScript;
        $this->requestHandler = GeneralUtility::makeInstance('TYPO3\\CMS\\Form\\Request');
        $this->formUtility = FormUtility::getInstance();
    }

    /**
     * Method called by the post processor (hook)
     *
     * @return string
     */
    public function process() {
        $this->_crmMetaData = array(
            'url' => $this->typoScript['url'],
            'username' => $this->typoScript['username'],
            'accesskey' => $this->typoScript['accesskey'],
            'module' => $this->typoScript['module']
        );

        $this->prepareDataForCrm($this->form->getElements());

        return $this->render();
    }

    /**
     * Prepare data for crm
     *
     * @param $elements
     */
    protected function prepareDataForCrm($elements) {
        foreach($elements as $element) {
            $elementType = $this->formUtility->getLastPartOfClassName($element, true);

            if ($elementType === 'fieldset') {
                $this->prepareDataForCrm($element->getElements());
            }

            if (!$element->additionalIsSet('crmfield') || !in_array($elementType, $this->_allowedElementTypes)) {
                continue;
            }

            $value = '';
            switch($elementType) {
                case 'radiogroup':    // single value checked == select type
                case 'checkboxgroup': // single value checked == select type || multiple values checked == multiselect type
                    foreach($element->getElements() as $_element) {
                        $_elementType = $this->formUtility->getLastPartOfClassName($_element, true);
                        if ($_elementType === 'checkbox' || $_elementType === 'radio') {
                            if (array_key_exists('checked', $_element->getAllowedAttributes()) && $_element->hasAttribute('checked') && $_element->getAdditionalObjectByKey('label')) {
                                // multiple
                                if (strlen($value) > 0) {
                                    $value .= ' |##| ' . $_element->getAdditionalValue('label');
                                }
                                // single
                                else {
                                    $value = $_element->getAdditionalValue('label');
                                }
                            }
                        }
                    }
                    break;
                case 'radio':
                case 'checkbox':
                    $value = 0;
                    if (array_key_exists('checked', $element->getAllowedAttributes()) && $element->hasAttribute('checked')) {
                        $value = 1;
                    }
                    break;
                case 'select':
                    foreach($element->getElements() as $_element) {
                        if ($this->formUtility->getLastPartOfClassName($_element, true) === 'option') {
                            if (array_key_exists('selected', $_element->getAllowedAttributes()) && $_element->hasAttribute('selected')) {
                                // multiple
                                if (strlen($value) > 0) {
                                    $value .= ' |##| ' . $_element->getData();
                                }
                                // single
                                else {
                                    $value = $_element->getData();
                                }
                            }
                        }
                    }
                    break;
                case 'textarea':
                    $value = $element->getData();
                    break;
                case 'hidden':
                case 'password':
                case 'textline':
                    $value = ($element->hasAttribute('value')) ? $element->getAttributeValue('value') : '';
                    break;
            }

            $crmField = $element->getAdditionalValue('crmfield');

            // concatenate values if duplicate keys exist
            if (isset($this->_crmFormData[$crmField])) {
                $this->_crmFormData[$crmField] = $this->_crmFormData[$crmField] .' '. $value;
            } else {
                $this->_crmFormData[$crmField] = $value;
            }
        }
    }

    /**
     * Send data to crm after andrender a html message after trying to send the mail
     *
     * @return string HTML message from the mail view
     */
    protected function render() {
        $push = new PushService($this->_crmMetaData, $this->_crmFormData);
        $push->process();
        return '';
    }
}