<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

/**
 * Configuration template access
 */
if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
}

/**
 * TYPO3 Form
 */
if ($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]['enableForm']) {
    // Xclass json to typoScript converter
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Form\\Domain\\Factory\\JsonToTypoScript'] = [
        'className' => 'Brainformatik\\BfCrmForm\\Xclass\\JsonToTypoScript',
    ];

    // Xclass typoScript to json converter
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Form\\Utility\\TypoScriptToJsonConverter'] = [
        'className' => 'Brainformatik\\BfCrmForm\\Xclass\\TypoScriptToJsonConverter',
    ];

    // Xclass typoscript factory for reconstitute data
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Form\\Domain\\Factory\\TypoScriptFactory'] = [
        'className' => 'Brainformatik\\BfCrmForm\\Xclass\\TypoScriptFactory',
    ];

    // Wizard Hook
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['form']['hooks']['renderWizard'][] = 'Brainformatik\\BfCrmForm\\Hooks\\WizardViewHook->initialize';

    // Wizard PageTS
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/PageTS/FormWizards.ts">'
    );
}

/**
 * Powermail Extension
 */
if ($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]['enablePowermail']) {
    $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
    $signalSlotDispatcher->connect(
        'In2code\\Powermail\\Controller\\FormController', 'createActionAfterSubmitView', 'Brainformatik\\BfCrmForm\\Hooks\\PowermailHook', 'process', false
    );
}

/**
 * Configuration template reset
 */
if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY] = serialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
}