<?php

$extensionClassesPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('bf_crm_form') . 'Classes/';
return [
    'TYPO3\\CMS\\Form\\PostProcess\\CrmpushPostProcessor' => $extensionClassesPath . 'PostProcess/CrmpushPostProcessor.php',
    'TYPO3\\CMS\\Form\\Domain\\Model\\Additional\\CrmfieldAdditionalElement' => $extensionClassesPath . 'Domain/Model/Additional/CrmfieldAdditionalElement.php',
];
