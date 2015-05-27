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

use TYPO3\CMS\Core\Http\HttpRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PushService
 * @package Brainformatik\BfCrmForm\Xclass
 */
class PushService {

    /**
     * @var \TYPO3\CMS\Core\Http\HttpRequest
     */
    protected $client;

    /**
     * @var \TYPO3\CMS\Core\Utility\GeneralUtility
     */
    protected $logger;

    /**
     * @var string
     */
    protected $suffix = '/webservice.php';

    /**
     * @var array
     */
    protected $metaData = array();

    /**
     * @var array
     */
    protected $formData = array();

    /**
     * @var array
     */
    protected $session = array();

    /**
     * @param array $crmMetaData
     * @param array $crmFormdata
     */
    public function __construct(array $crmMetaData, array $crmFormdata) {
        $this->metaData = $crmMetaData;
        $this->formData = $crmFormdata;
        $this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['bf_crm_form']);
        $this->logger = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);

        if (!strstr($this->metaData['url'], $this->suffix)) {
            $this->metaData['url'] .= $this->suffix;
        }

        $this->client = new HttpRequest($this->metaData['url']);
    }

    /**
     * Main Process
     */
    public function process() {
        if ($this->getToken() && $this->login()) {
            $this->createEntity();
            $this->logout();
        }
    }

    /**
     * Get a valid token for a user
     *
     * @return bool
     */
    protected function getToken() {
        $response = $this->send(
            array(
                'operation' => 'getchallenge',
                'username'  => $this->metaData['username']
            ),
            HttpRequest::METHOD_GET
        );

        if ($response['success']) {
            $this->session['token'] = $response['result']['token'];
        }

        return $response['success'];
    }

    /**
     * Get a valid user session
     *
     * @return bool
     */
    protected function login() {
        $response = $this->send(
            array(
                'operation' => 'login',
                'username'  => $this->metaData['username'],
                'accessKey' => md5($this->session['token'].$this->metaData['accesskey'])
            ),
            HttpRequest::METHOD_POST
        );

        if ($response['success']) {
            $this->session['userid']     = $response['result']['userId'];
            $this->session['sessionkey'] = $response['result']['sessionName'];
        }

        return $response['success'];
    }

    /**
     * Close a valid user session
     *
     * @return bool
     */
    protected function logout() {
        $response = $this->send(
            array(
                'operation'   => 'logout',
                'sessionName' => $this->session['sessionkey'],
            ),
            HttpRequest::METHOD_POST
        );

        return $response['success'];
    }

    /**
     * Send data to crm
     *
     * @return bool
     */
    protected function createEntity() {
        // special filter for assigned_user_id
        if (!isset($this->formData['assigned_user_id']) || empty($this->formData['assigned_user_id'])) {
            $this->formData['assigned_user_id'] = $this->session['userid'];
        } else if (is_numeric($this->formData['assigned_user_id'])) {
            $this->formData['assigned_user_id'] = '19x' . $this->formData['assigned_user_id'];
        }

        $response = $this->send(
            array(
                'operation'   => 'create',
                'sessionName' => $this->session['sessionkey'],
                'element'     => json_encode($this->formData),
                'elementType' => $this->metaData['module']
            ),
            HttpRequest::METHOD_POST
        );

        return $response['success'];
    }

    /**
     * Request helper
     *
     * @param array $data
     * @param string $method
     *
     * @return array
     */
    protected function send(array $data, $method) {
        if ($method === HttpRequest::METHOD_POST) {
            $this->client->setMethod(HttpRequest::METHOD_POST);
            $this->client->addPostParameter($data);
        } else {
            $this->client->setMethod(HttpRequest::METHOD_GET);
            $url = $this->client->getUrl();
            $url->setQueryVariables($data);
        }

        $response = $this->client->send()->getBody();
        $response = json_decode($response, true);

        if ($this->extConf['enableLog']) {
            $this->logger->debug('Request', $data);
            $this->logger->debug('Response', is_array($response) ? $response : array($response));
        }

        return $response;
    }
}