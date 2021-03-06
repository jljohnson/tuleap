<?php
/**
 * Copyright (c) Enalean, 2017. All rights reserved
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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/
 */

namespace Tuleap\Dashboard\Project;

use ForgeConfig;
use HTTPRequest;
use Tuleap\Dashboard\Widget\WidgetDashboardController;

class ProjectDashboardRouter
{
    const DASHBOARD_TYPE = 'project';

    /**
     * @var ProjectDashboardController
     */
    private $project_dashboard_controller;
    /**
     * @var WidgetDashboardController
     */
    private $widget_dashboard_controller;

    public function __construct(
        ProjectDashboardController $project_dashboard_controller,
        WidgetDashboardController $widget_dashboard_controller
    ) {
        $this->project_dashboard_controller = $project_dashboard_controller;
        $this->widget_dashboard_controller  = $widget_dashboard_controller;
    }

    /**
     * Routes the request to the correct controller
     * @param HTTPRequest $request
     * @return void
     */
    public function route(HTTPRequest $request)
    {
        if (! ForgeConfig::get('sys_use_tlp_in_dashboards')) {
            return;
        }

        $action = $request->get('action');

        switch ($action) {
            case 'delete-widget':
                $this->project_dashboard_controller->deleteWidget($request);
                break;
            case 'reorder-widgets':
                $this->widget_dashboard_controller->reorderWidgets($request, self::DASHBOARD_TYPE);
                break;
            case 'add-dashboard':
                $this->project_dashboard_controller->createDashboard($request);
                break;
            case 'edit-dashboard':
                $this->project_dashboard_controller->editDashboard($request);
                break;
            case 'delete-dashboard':
                $this->project_dashboard_controller->deleteDashboard($request);
                break;
            default:
                $this->project_dashboard_controller->display($request);
                break;
        }
    }
}
