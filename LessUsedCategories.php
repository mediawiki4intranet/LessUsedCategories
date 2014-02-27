<?php

/**
 * LessUsedCategories extension
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @author Vitaliy Filippov [vitalif at mail.ru]
 * @copyright Copyright (C) 2014+ Vitaliy Filippov
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if (!defined('MEDIAWIKI'))
{
    die();
}

$wgExtensionCredits['specialpage'][] = array(
    'path'          => __FILE__,
    'name'          => 'LessUsedCategories',
    'version'       => '0.1',
    'author'        => 'Vitaliy Filippov',
    'description'   => 'Shows a list of less used categories',
);

$wgAutoloadClasses['SpecialLessUsedCategories'] = __DIR__.'/LessUsedCategories.class.php';
$wgSpecialPages['LessUsedCategories'] = 'SpecialLessUsedCategories';
$wgExtensionMessagesFiles['LessUsedCategories'] = __DIR__.'/LessUsedCategories.i18n.php';
