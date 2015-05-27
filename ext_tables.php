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
    $tempColumns = array (
        'tx_bfcrmform_fieldname' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crmfield_name',
            'config' => array (
                'size' => 25,
                'type' => 'input',
                'eval' => 'trim'
            )
        )
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_powermail_domain_model_fields', $tempColumns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_powermail_domain_model_fields',
        '--div--;LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crmfield, tx_bfcrmform_fieldname',
        'input,textarea,select,radio,check,password,hidden,date,country,location',
        'after:own_marker_select'
    );

    // TCA forms modification
    $tempColumns = array (
        'tx_bfcrmform_active' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crmpush_active',
            'config' => array (
                'type' => 'check'
            )
        ),
        'tx_bfcrmform_url' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crmpush_url',
            'config' => array (
                'size' => 25,
                'type' => 'input',
                'eval' => 'trim'
            )
        ),
        'tx_bfcrmform_username' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crmpush_username',
            'config' => array (
                'size' => 25,
                'type' => 'input',
                'eval' => 'trim'
            )
        ),
        'tx_bfcrmform_accesskey' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crmpush_accesskey',
            'config' => array (
                'size' => 25,
                'type' => 'input',
                'eval' => 'trim'
            )
        ),
        'tx_bfcrmform_module' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crmpush_module',
            'config' => array (
                'size' => 25,
                'type' => 'input',
                'eval' => 'trim'
            )
        )
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_powermail_domain_model_forms', $tempColumns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_powermail_domain_model_forms',
        '--div--;LLL:EXT:bf_crm_form/Resources/Private/Language/FormWizard.xlf:crm, tx_bfcrmform_active,tx_bfcrmform_url,tx_bfcrmform_username,tx_bfcrmform_accesskey,tx_bfcrmform_module',
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