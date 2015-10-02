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
 * Powermail Extension
 */
if ($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]['enablePowermail']) {
    // Include Static TypoScript
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Powermail Crm Field');

    // TCA fields modification
    $tempColumns = [
        'tx_bfcrmform_fieldname' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crmfield_name',
            'config' => [
                'size' => 25,
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_powermail_domain_model_fields', $tempColumns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_powermail_domain_model_fields',
        '--div--;LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crmfield, tx_bfcrmform_fieldname',
        'input,textarea,select,radio,check,password,hidden,date,country,location',
        'after:own_marker_select'
    );

    // TCA forms modification
    $tempColumns = [
        'tx_bfcrmform_active' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crmpush_active',
            'config' => [
                'type' => 'check'
            ]
        ],
        'tx_bfcrmform_url' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crmpush_url',
            'config' => [
                'size' => 25,
                'type' => 'input',
                'eval' => 'trim'
            ]
        ],
        'tx_bfcrmform_accesskey' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crmpush_accesskey',
            'config' => [
                'size' => 25,
                'type' => 'input',
                'eval' => 'trim'
            ]
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_powermail_domain_model_forms', $tempColumns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_powermail_domain_model_forms',
        '--div--;LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crm, tx_bfcrmform_active,tx_bfcrmform_url,tx_bfcrmform_accesskey',
        '',
        'after:css'
    );
}

/**
 * Configuration template reset
 */
if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY] = serialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
}