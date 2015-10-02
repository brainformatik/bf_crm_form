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
    protected $txBfcrmformAccesskey;

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
}