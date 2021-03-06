<?php
/**
 * Copyright (c) Enalean, 2012. All Rights Reserved.
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
 */

class Planning_ShortAccess {

    const NUMBER_TO_DISPLAY = 5;

    /** @var bool */
    private $is_latest = false;

    /**
     * @var PFUser
     */
    private $user;

    /**
     * @var Planning
     */
    public $planning;

    /**@var int */
    public $planning_id;

    /**@var int */
    private $offset;

    /** @var int */
    public $next_offset;

    /** @var string */
    public $more;

    /** @var string */
    public $more_title;

    /**
     * @var Planning_MilestoneFactory
     */
    protected $milestone_factory;

    /**
     * @var AgileDashboard_PaneInfoFactory
     */
    protected $pane_info_factory;

    /** @var array of Planning_MilestoneLinkPresenter */
    private $presenters;

    /** @var string */
    private $theme_path;

    public function __construct(Planning $planning, PFUser $user, Planning_MilestoneFactory $milestone_factory, AgileDashboard_PaneInfoFactory $pane_info_factory, $theme_path, $offset) {
        $this->user              = $user;
        $this->planning          = $planning;
        $this->planning_id       = $planning->getId();
        $this->milestone_factory = $milestone_factory;
        $this->pane_info_factory = $pane_info_factory;
        $this->theme_path        = $theme_path;
        $this->offset            = $offset;
        $this->next_offset       = $offset + self::NUMBER_TO_DISPLAY;
        $this->more              = $GLOBALS['Language']->getText('global', 'more');
        $this->more_title        = $GLOBALS['Language']->getText('plugin_agiledashboard', 'display_five_more', self::NUMBER_TO_DISPLAY);
    }

    public function getLastOpenMilestones() {
        return array_slice($this->getMilestoneLinkPresenters(), 0, self::NUMBER_TO_DISPLAY);
    }

    /**
     * @return Planning_Milestone
     */
    public function getLastMilestoneCreated() {
        return $this->milestone_factory->getLastMilestoneCreated($this->user, $this->planning->getId());
    }

    public function hasMoreMilestone() {
        return count($this->getMilestoneLinkPresenters()) > self::NUMBER_TO_DISPLAY;
    }

    private function getMilestoneLinkPresenters() {
        if (!$this->presenters) {
            $this->presenters = array();
            $milestones = $this->milestone_factory->getLastOpenMilestones($this->user, $this->planning, $this->offset, self::NUMBER_TO_DISPLAY + 1);
            $icon_factory = new AgileDashboard_PaneIconLinkPresenterCollectionFactory($this->pane_info_factory);
            foreach ($milestones as $milestone) {
                $this->presenters[] = new Planning_ShortAccessMilestonePresenter(
                    $this,
                    $milestone,
                    $icon_factory->getIconLinkPresenterCollection($milestone),
                    $this->milestone_factory,
                    $this->user,
                    $this->theme_path
                );
            }
            if (!empty($this->presenters)) {
                end($this->presenters)->setIsLatest();
            }
            $this->presenters = array_reverse($this->presenters);
        }
        return $this->presenters;
    }

    public function planningTrackerId() {
        return $this->planning->getPlanningTrackerId();
    }

    public function planningRedirectToNew() {
        return 'planning[]['. $this->planning->getId() .']=-1';
    }

    public function setIsLatest() {
        $this->is_latest = true;
    }

    public function isLatest() {
        return $this->is_latest;
    }

    //TODO: use the one in MilestonePresenter???
    public function createNewItemToPlan() {
        $tracker = $this->planning->getPlanningTracker();
        return $GLOBALS['Language']->getText('plugin_agiledashboard', 'create_new_item_to_plan', array($tracker->getItemName()));
    }

    /**
     *
     * @return Planning
     */
    public function getPlanning() {
        return $this->planning;
    }
}
?>
