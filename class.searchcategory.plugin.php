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

    // Overridden Index method of SearchController.php to retrieve category to search into from the form data
    // and to call the overridden model's search() function with the added $CategoryFilter variable
    //
    public function SearchController_Index_Create($Sender, $Page = '') {
        $Sender->AddJsFile('search.js');
        $Sender->Title(T('Search'));

        SaveToConfig('Garden.Format.EmbedSize', '160x90', FALSE);

        list($Offset, $Limit) = OffsetLimit($Page, C('Garden.Search.PerPage', 20));
        $Sender->SetData('_Limit', $Limit);

        $CategoryToSearch = $Sender->Form->GetFormValue('CategoryID');
        
        $Search = $Sender->Form->GetFormValue('Search');
        $Mode = $Sender->Form->GetFormValue('Mode');

        if ($Mode)
            $Sender->SearchModel->ForceSearchMode = $Mode;
       try {
            $ResultSet = $Sender->SearchModel->Search($Search, $Offset, $Limit, $CategoryToSearch);
        } catch (Gdn_UserException $Ex) {
            $Sender->Form->AddError($Ex);
            $ResultSet = array();
        } catch (Exception $Ex) {
            LogException($Ex);
            $Sender->Form->AddError($Ex);
            $ResultSet = array();
        }

        Gdn::UserModel()->JoinUsers($ResultSet, array('UserID'));
        $Sender->SetData('SearchResults', $ResultSet, TRUE);
        $Sender->SetData('SearchTerm', Gdn_Format::Text($Search), TRUE);
        if($ResultSet)
            $NumResults = count($ResultSet);
        else
            $NumResults = 0;
        
        if ($NumResults == $Offset + $Limit)
            $NumResults++;

        // Build a pager
        $PagerFactory = new Gdn_PagerFactory();
        $Sender->Pager = $PagerFactory->GetPager('MorePager', $Sender);
        $Sender->Pager->MoreCode = 'More Results';
        $Sender->Pager->LessCode = 'Previous Results';
        $Sender->Pager->ClientID = 'Pager';
        $Sender->Pager->Configure(
            $Offset,
            $Limit,
            $NumResults,
            'dashboard/search/%1$s/%2$s/?Search='.Gdn_Format::Url($Search)
        );

        //      if ($Sender->_DeliveryType != DELIVERY_TYPE_ALL) {
        //         $Sender->SetJson('LessRow', $Sender->Pager->ToString('less'));
        //         $Sender->SetJson('MoreRow', $Sender->Pager->ToString('more'));
        //         $Sender->View = 'results';
        //      }

        $Sender->CanonicalUrl(Url('search', TRUE));

        $Sender->Render();
    }
        
    // This is needed to override searchmodel.php with local copy
    public function Gdn_Dispatcher_BeforeDispatch_Handler($Sender) {
        require_once 'plugins/SearchCategory/class.searchmodel.php';
    }

    // Intercept render_before to render custom view instead of original forum/search?xx page
    //
    public function SearchController_Render_Before($Sender) {
        
        $Sender->AddCssFile($this->GetResource('views/dashboard/search/style.css', FALSE, FALSE));

        $View = 'dashboard/search/index.php';
        $ThemeView = CombinePaths(array(PATH_THEMES, $Sender->Theme, strtolower($this->GetPluginFolder(false)), $View));

        if (file_exists($ThemeView))
        {
            $Sender->View = $ThemeView;
        } else {
            $Sender->View = $this->GetView($View);
        }
    }

    // Try to inject the search for category filter here (WHERE clause?)
    //
    public function SearchModel_Search_Handler($Sender) {
    
    }
}

?>

