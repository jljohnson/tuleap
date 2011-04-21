<?php

/**
 * Copyright (c) STMicroelectronics, 2011. All Rights Reserved.
 *
 * This file is a part of Codendi.
 *
 * Codendi is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Codendi is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Codendi; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

require_once('common/plugin/Plugin.class.php');
require_once('common/system_event/SystemEvent.class.php');

class codextoremedyPlugin extends Plugin {

    function codextoremedyPlugin($id) {
        $this->Plugin($id);
        $this->_addHook('site_admin_option_hook', 'siteAdminHooks', false);
        $this->_addHook('cssfile', 'cssFile', false);
        $this->_addHook('site_help', 'displayForm', false);
    }

    function &getPluginInfo() {
        if (!$this->pluginInfo instanceof CodexToRemedyPluginInfo) {
            include_once('CodexToRemedyPluginInfo.class.php');
            $this->pluginInfo = new CodexToRemedyPluginInfo($this);
        }
        return $this->pluginInfo;
    }

    function siteAdminHooks($params) {
        echo '<li><a href="'.$this->getPluginPath().'/">Codex To Remedy</a></li>';
    }

    function cssFile($params) {
        if (strpos($_SERVER['REQUEST_URI'], $this->getPluginPath()) === 0) {
            echo '<link rel="stylesheet" type="text/css" href="'.$this->getThemePath().'/css/style.css" />';
        }
    }
    
    function process() {
        require_once('CodexToRemedy.class.php');
        $controler =& new CodexToRemedy();
        $controler->process();
    }

    /**
     * Display form to fill a request
     *
     * @param Array $params
     *
     * @return Void
     */
    function displayForm($params) {
?>
<form  name="request" action="index.php" method="post" enctype="multipart/form-data">
    
     <fieldset ><legend>Submit Help Request:</legend>
     Type: 
     <select name="type"> 
	     <option value"support">Support request</option>
	     <option value"enhancement">Enhancement request</option>
     </select><br />
     Severity: <select name="severity"> 
     	<option value"minor">Minor</option>
     	<option value"serious">Serious</option>
     	<option value"critical">Critical</option>
     	</select><br />
     Summary: <input type="text" name="request_summary" /><br />
     Description:  <textarea name="request_description" cols="50" rows="7"> </textarea> <br />
     
 	 <input name="submit" type="submit" value="Submit" />
	 
	 </fieldset>
</form>
<?php
    }
}
?>