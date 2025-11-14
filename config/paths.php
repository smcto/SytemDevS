<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       MIT License (https://opensource.org/licenses/mit-license.php)
 */

/**
 * Use the DS to separate the directories in other defines
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/**
 * The full path to the directory which holds "src", WITHOUT a trailing DS.
 */
define('ROOT', dirname(__DIR__));

/**
 * The actual directory name for the application directory. Normally
 * named 'src'.
 */
define('APP_DIR', 'src');

/**
 * Path to the application's directory.
 */
define('APP', ROOT . DS . APP_DIR . DS);

/**
 * Path to the config directory.
 */
define('CONFIG', ROOT . DS . 'config' . DS);

/**
 * File path to the webroot directory.
 */
define('WWW_ROOT', ROOT . DS . 'webroot' . DS);

/**
 * Path to the tests directory.
 */
define('TESTS', ROOT . DS . 'tests' . DS);

/**
 * Path to the temporary files directory.
 */
define('TMP', ROOT . DS . 'tmp' . DS);

/**
 * Path to the logs directory.
 */
define('LOGS', ROOT . DS . 'logs' . DS);

/**
 * Path to the cache files directory. It can be shared between hosts in a multi-server setup.
 */
define('CACHE', TMP . 'cache' . DS);

/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 * CakePHP should always be installed with composer, so look there.
 */
define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');

/**
 * Path to the cake directory.
 */
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);


/**
 * UPLOADS
 */
define('PATH_TMP',WWW_ROOT . 'uploads' . DS . 'tmp'.DS);
define('PATH_CONTACTS',WWW_ROOT . 'uploads' . DS . 'contacts'.DS);
define('PATH_DOCUMENTATIONS',WWW_ROOT . 'uploads' . DS . 'documentations'.DS);
define('PATH_FACTURES',WWW_ROOT . 'uploads' . DS . 'factures'.DS);
define('PATH_ANTENNES',WWW_ROOT . 'uploads' . DS . 'antenne'.DS);
define('PATH_MODELES_MAILS_PJS',WWW_ROOT . 'uploads' . DS . 'pjs'.DS);
define('PATH_ACTU_BORNES',WWW_ROOT . 'uploads' . DS . 'actubornes'.DS);
define('PATH_ACTU_MATERIELS',WWW_ROOT . 'uploads' . DS . 'materiel'.DS);
define('PATH_MODEL_BORNES',WWW_ROOT . 'uploads' . DS . 'model_bornes'.DS);

define('PATH_STRIPES_CSV',WWW_ROOT . 'uploads' . DS . 'stripes_csv'.DS);

define('PATH_CATALOG_PRODUITS',WWW_ROOT . 'uploads' . DS . 'catalogue_produits'.DS);
define('PATH_DOC_EQUIP',WWW_ROOT . 'uploads' . DS . 'doc_equipements'.DS);

define('PATH_DEVIS',WWW_ROOT . 'uploads' . DS . 'devis'.DS);
define('PATH_BC',WWW_ROOT . 'uploads' . DS . 'bc'.DS);
define('PATH_DEVIS_FACTURES',WWW_ROOT . 'uploads' . DS . 'factures_vente'.DS);
define('PATH_AVOIRS',WWW_ROOT . 'uploads' . DS . 'avoirs'.DS);

define('ZIP_TMP_FILES', WWW_ROOT . 'uploads' . DS . 'zip_tmp' .DS. 'files');
define('ZIP_TMP_COMPRESSED', WWW_ROOT . 'uploads' . DS . 'zip_tmp' .DS. 'compressed');
