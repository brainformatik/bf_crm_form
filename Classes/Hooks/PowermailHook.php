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

use In2code\Powermail\Domain\Model\Mail;

use Brainformatik\BfCrmForm\Service\PushService;

/**
 * Class WizardViewHook
 * @package Brainformatik\BfCrmForm\Hooks
 */
class PowermailHook {

    /**
     * @var array
     */
    protected $_crmMetaData = [];

    /**
     * @var array
     */
    protected $_crmFormData = [];

    /**
     * @var array
     */
    protected $_allowedElementTypes = [
        'input', 'textarea', 'select', 'radio', 'check', 'password', 'hidden', 'date', 'country', 'location'
    ];

    /**
     * Convert selected values to a string which is compatible with crm field
     *
     * @param bool  $multiple
     * @param array $data
     *
     * @return string
     */
    protected function convertSelectedToString($multiple, array $data) {
        return ($multiple) ? implode(' |##| ', $data) : implode('', $data);
    }

    /**
     * Main proccess
     *
     * @param Mail   $mail
     * @param string $hash
     * @param Object $parent
     */
    public function process(Mail $mail, $hash, $parent) {
        $form = $mail->getForm();

        if (!method_exists($form, 'getTxBfcrmformActive') || !$form->getTxBfcrmformActive()) {
            return;
        }

        $this->_crmMetaData = [
            'url' => $form->getTxBfcrmformUrl(),
            'accesskey' => $form->getTxBfcrmformAccesskey()
        ];

        foreach ($mail->getAnswers() as $answer) {
            if (!method_exists($answer, 'getField') || !method_exists($answer->getField(), 'getTxBfcrmformFieldname')) {
                continue;
            }

            $field = $answer->getField();
            $fieldType = $field->getType();
            $crmField = $field->getTxBfcrmformFieldname();

            if (empty($crmField) || !in_array($fieldType, $this->_allowedElementTypes)) {
                continue;
            }

            $value = $answer->getValue();
            switch ($fieldType) {
                case 'select':
                    $value = $this->convertSelectedToString($field->getMultiselect(), $value);
                    break;
                case 'radio': // single option == bool type || single value checked == select type
                case 'check': // single option == bool type || single value checked == select type || multiple values checked == multiselect type
                    if (count($field->getModifiedSettings()) === 1) {
                        $value = !empty($value) ? 1 : 0;
                    } else if ($fieldType === 'check') {
                        $value = $this->convertSelectedToString((count($value) > 1), $value);
                    }
                    break;
                default:
            }

            // concatenate values if duplicate keys exist
            if (isset($this->_crmFormData[$crmField])) {
                $this->_crmFormData[$crmField] = $this->_crmFormData[$crmField] . ' ' . $value;
            } else {
                $this->_crmFormData[$crmField] = $value;
            }
        }

        $this->render();
    }

    /**
     * Send data to crm after trying to send the mail
     */
    protected function render() {
        $push = new PushService($this->_crmMetaData, $this->_crmFormData);
        $push->process();
    }
}