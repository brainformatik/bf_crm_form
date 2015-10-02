<?php
namespace Brainformatik\BfCrmForm\Service;

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

/**
 * Class PushService
 * @package Brainformatik\BfCrmForm\Xclass
 */
class PushService {

    /**
     * @var \TYPO3\CMS\Core\Utility\GeneralUtility
     */
    protected $logger;

    /**
     * @var string
     */
    protected $suffix = '/modules/Webforms/capture.php';

    /**
     * @var array
     */
    protected $metaData = [];

    /**
     * @var array
     */
    protected $formData = [];

    /**
     * @param array $crmMetaData
     * @param array $crmFormdata
     */
    public function __construct(array $crmMetaData, array $crmFormdata) {
        $this->metaData = $crmMetaData;
        $this->formData = $crmFormdata;
        $this->formData['publicid'] = $this->metaData['accesskey'];

        $this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['bf_crm_form']);
        $this->logger = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);

        if (!strstr($this->metaData['url'], $this->suffix)) {
            $this->metaData['url'] .= $this->suffix;
        }
    }

    /**
     * Main Process
     */
    public function process() {
        return $this->send();
    }

    /**
     * Request helper
     *
     * @return array
     */
    protected function send() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->metaData['url']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->formData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response, true);

        if ($this->extConf['enableLog']) {
            $this->logger->debug('Request', $this->formData);
            $this->logger->debug('Response', is_array($response) ? $response : [$response]);
        }

        return $response;
    }
}