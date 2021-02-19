<?php

/**
 * Import from csv bundle: Backend module for Contao CMS
 * Copyright (c) 2008-2020 Marko Cupic
 * @package import-from-csv-bundle
 * @author Marko Cupic m.cupic@gmx.ch, 2020
 * @link https://github.com/markocupic/resource-booking-bundle
 */

// legends
$GLOBALS['TL_LANG']['tl_import_from_csv']['manual'] = 'Manual/Help';
$GLOBALS['TL_LANG']['tl_import_from_csv']['settings'] = 'Settings';
$GLOBALS['TL_LANG']['tl_import_from_csv']['limitAndOffset_settings'] = "Offset and limit (max_execution_time)";
$GLOBALS['TL_LANG']['tl_import_from_csv']['cron_settings'] = "Cron settings";

// fields
$GLOBALS['TL_LANG']['tl_import_from_csv']['import_table'] = array('Import data into this table', 'Choose a table for import.');
$GLOBALS['TL_LANG']['tl_import_from_csv']['import_mode'] = array('Import mode', 'Decide if the table will be truncated before importing the data from the csv-file.');
$GLOBALS['TL_LANG']['tl_import_from_csv']['field_enclosure'] = array('Field enclosure', 'Character with which  the field-content is enclosed. Normally it is a double quote: => "');
$GLOBALS['TL_LANG']['tl_import_from_csv']['field_separator'] = array('Field separator', 'Character with which the fields are separated. Normally it is a semicolon: => ;');
$GLOBALS['TL_LANG']['tl_import_from_csv']['selected_fields'] = array('Select the fields for the import');
$GLOBALS['TL_LANG']['tl_import_from_csv']['fileSRC'] = array('Select a csv-file for the import');
$GLOBALS['TL_LANG']['tl_import_from_csv']['fileContent'] = array('File content');
$GLOBALS['TL_LANG']['tl_import_from_csv']['skipValidationFields'] = array("Skip validation for these fields", "Select field that will not be validated.");
$GLOBALS['TL_LANG']['tl_import_from_csv']['offset'] = array("Skip entries", "Please select the number of entries that will be skiped during the import process.");
$GLOBALS['TL_LANG']['tl_import_from_csv']['limit'] = array("Limit entries", "Please select the number of entries that will be imported (0 = all).");
$GLOBALS['TL_LANG']['tl_import_from_csv']['enableCron'] = array("Enable cron", "Run import as a cronjob.");
$GLOBALS['TL_LANG']['tl_import_from_csv']['cronLevel'] = array("Cron level", "Select a cron level");

//references
$GLOBALS['TL_LANG']['tl_import_from_csv']['truncate_table'] = array('truncate the target table before importing data');
$GLOBALS['TL_LANG']['tl_import_from_csv']['append_entries'] = array('only append data into the target table');

//buttons
$GLOBALS['TL_LANG']['tl_import_from_csv']['new'][0] = 'Add new import';
$GLOBALS['TL_LANG']['tl_import_from_csv']['new'][1] = 'Add a new import';
$GLOBALS['TL_LANG']['tl_import_from_csv']['launchImportButton'] = 'Launch import process';
$GLOBALS['TL_LANG']['tl_import_from_csv']['testRunImportButton'] = 'Launch  import in test mode';

// messages
$GLOBALS['TL_LANG']['tl_import_from_csv']['datarecords'] = 'Datarecords';
$GLOBALS['TL_LANG']['tl_import_from_csv']['successful_inserts'] = 'Successful inserts';
$GLOBALS['TL_LANG']['tl_import_from_csv']['failed_inserts'] = 'Failed inserts';
