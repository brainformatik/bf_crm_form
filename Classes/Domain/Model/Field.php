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
 * Class Field
 * @package Brainformatik\BfCrmForm\Domain\Model
 */
class Field extends \In2code\Powermail\Domain\Model\Field {

    /**
     * @var string
     */
    protected $txBfcrmformFieldname;

    /**
     * @param string $txBfcrmformFieldname
     */
    public function setTxBfcrmformFieldname($txBfcrmformFieldname) {
        $this->txBfcrmformFieldname = $txBfcrmformFieldname;
    }

    /**
     * @return string
     */
    public function getTxBfcrmformFieldname() {
        return $this->txBfcrmformFieldname;
    }
}