<?php
/**
 * Copyright (c) Enalean, 2017. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace Tuleap\Configuration\Etc;

use Tuleap\Configuration\Vars;

class LoadLocalInc
{

    private $base_dir;

    public function __construct($base_dir = '/etc/tuleap')
    {
        $this->base_dir = $base_dir;
    }

    /**
     * @return \Tuleap\Configuration\Vars
     */
    public function getVars()
    {
        $variables = $this->getVariablesOverrideByLocalConf();

        $vars = new Vars();
        $vars->setApplicationBaseDir($variables['tuleap_dir']);
        $vars->setApplicationUser($variables['sys_http_user']);
        $vars->setServerName($variables['sys_default_domain']);

        return $vars;
    }

    private function getVariablesOverrideByLocalConf()
    {
        $variables = $this->getVariables('/usr/share/tuleap/src/etc/local.inc.dist');
        $variables = array_merge($variables, $this->getVariables($this->base_dir.'/conf/local.inc'));
        return $variables;
    }

    private function getVariables($file_name)
    {
        if (! is_readable($file_name)) {
            throw new \Exception('Unable to read '.$file_name);
        }

        include $file_name;
        return get_defined_vars();
    }
}