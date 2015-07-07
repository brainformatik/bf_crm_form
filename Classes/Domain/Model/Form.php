<?php
namespace Brainformatik\BfCrmForm\Domain\Model;

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
 * Class Form
 * @package Brainformatik\BfCrmForm\Domain\Model
 */
class Form extends \In2code\Powermail\Domain\Model\Form {

    /**
     * @var string
     */
    protected $txBfcrmformActive;

    /**
     * @var string
     */
    protected $txBfcrmformUrl;

    /**
     * @var string
     */
    protected $txBfcrmformUsername;

    /**
     * @var string
     */
    protected $txBfcrmformAccesskey;

    /**
     * @var string
     */
    protected $txBfcrmformModule;

    /**
     * @param string $txBfcrmformActive
     */
    public function setTxBfcrmformActive($txBfcrmformActive) {
        $this->txBfcrmformActive = $txBfcrmformActive;
    }

    /**
     * @return string
     */
    public function getTxBfcrmformActive() {
        return $this->txBfcrmformActive;
    }

    /**
     * @param string $txBfcrmformUrl
     */
    public function setTxBfcrmformUrl($txBfcrmformUrl) {
        $this->txBfcrmformUrl = $txBfcrmformUrl;
    }

    /**
     * @return string
     */
    public function getTxBfcrmformUrl() {
        return $this->txBfcrmformUrl;
    }

    /**
     * @param string $txBfcrmformUsername
     */
    public function setTxBfcrmformUsername($txBfcrmformUsername) {
        $this->txBfcrmformUsername = $txBfcrmformUsername;
    }

    /**
     * @return string
     */
    public function getTxBfcrmformUsername() {
        return $this->txBfcrmformUsername;
    }

    /**
     * @param string $txBfcrmformAccesskey
     */
    public function setTxBfcrmformAccesskey($txBfcrmformAccesskey) {
        $this->txBfcrmformAccesskey = $txBfcrmformAccesskey;
    }

    /**
     * @return string
     */
    public function getTxBfcrmformAccesskey() {
        return $this->txBfcrmformAccesskey;
    }

    /**
     * @param string $txBfcrmformModule
     */
    public function setTxBfcrmformModule($txBfcrmformModule) {
        $this->txBfcrmformModule = $txBfcrmformModule;
    }

    /**
     * @return string
     */
    public function getTxBfcrmformModule() {
        return $this->txBfcrmformModule;
    }
}