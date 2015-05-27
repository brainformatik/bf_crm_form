<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Brainformatik CRM Form',
    'description' => '...',
    'category' => 'misc',
    'shy' => 0,
    'version' => '1.0.0',
    'dependencies' => '',
    'conflicts' => '',
    'priority' => 'top',
    'loadOrder' => '',
    'module' => '',
    'state' => 'alpha',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearcacheonload' => 0,
    'author' => 'Brainformatik',
    'author_email' => 'info@brainformatik.com',
    'author_company' => 'Brainformatik GmbH',
    'constraints' => array(
        'depends' => array(
            'typo3' => '6.2.9-7.1.99'
        ),
        'conflicts' => array(),
        'suggests' => array(
            'form' => '',
            'powermail' => '',
        )
    )
);