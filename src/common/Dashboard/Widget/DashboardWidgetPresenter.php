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

namespace Tuleap\Dashboard\Widget;

use Widget;

class DashboardWidgetPresenter
{
    public $widget_id;
    public $title;
    public $content;
    public $is_editable;
    public $has_rss;
    public $rss_url;
    public $delete_widget_label;
    public $delete_widget_confirm;

    public function __construct(DashboardWidget $dashboard_widget, Widget $widget)
    {
        $this->widget_id   = $dashboard_widget->getId();
        $this->title       = $widget->getTitle();
        $this->content     = $widget->getContentForBurningParrot();
        $this->is_editable = strlen($widget->getPreferences()) !== 0;
        $this->has_rss     = $widget->hasRss();
        $this->rss_url     = $widget->getRssUrl($widget->owner_id, $widget->owner_type);

        $this->delete_widget_label   = _('Delete widget');
        $this->delete_widget_confirm = sprintf(
            _(
                'You are about to delete the widget "%s".
                This action is irreversible. Please confirm this deletion.'
            ),
            $this->title
        );
    }
}
