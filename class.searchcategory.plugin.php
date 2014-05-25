<?php if(!defined('APPLICATION')) exit();
/*  Copyright 2013 Franco Solerio
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
$PluginInfo['SearchCategory'] = array(
    'Name' => 'Search Category',
    'Description' => 'Filters search by category.',
    'Version' => '1.0',
    'RequiredApplications' => array('Vanilla' => '2.0.18.8'),
    'RequiredTheme' => FALSE,
    'RequiredPlugins' => FALSE,
    'MobileFriendly' => TRUE,
    'HasLocale' => FALSE,
    'RegisterPermissions' => FALSE,
    // 'SettingsUrl' => '/settings/mandrillmailer',
    // 'SettingsPermission' => 'Garden.Settings.Manage',
    'Author' => "Franco Solerio",
    'AuthorEmail' => 'franco@solerio.net',
    'AuthorUrl' => 'http://digitalia.fm',
    'License' => 'GPLv3'
);

class SearchCategoryPlugin extends Gdn_Plugin {


}

?>
