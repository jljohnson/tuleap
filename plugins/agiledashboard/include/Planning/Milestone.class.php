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

/**
 * A planning milestone (e.g.: Sprint, Release...)
 */
class Planning_Milestone {
    
    /**
     * @var int
     */
    protected $group_id;
    
    /**
     * @var Planning
     */
    protected $planning;
    
    /**
     * @var Tracker_Artifact
     */
    private $artifact;
    
    /**
     * @var TreeNode
     */
    private $planned_artifacts;
    
    /**
     * TODO: group_id should be replaced by project.
     * 
     * @param type $group_id
     * @param Planning $planning
     * @param Tracker_Artifact $artifact
     * @param TreeNode $planned_artifacts 
     */
    public function __construct(                 $group_id,
                                Planning         $planning,
                                Tracker_Artifact $artifact,
                                TreeNode         $planned_artifacts = null) {
        
        $this->group_id          = $group_id;
        $this->planning          = $planning;
        $this->artifact          = $artifact;
        $this->planned_artifacts = $planned_artifacts;
    }
    
    public function getGroupId() {
        return $this->group_id;
    }

    /**
     * @return Tracker_Artifact
     */
    public function getArtifact() {
        return $this->artifact;
    }
    
    /**
     * @return Boolean
     */
    public function userCanView(User $user) {
        return $this->artifact->getTracker()->userCanView($user);
    }
    
    /**
     * @return int
     */
    public function getArtifactId() {
        return $this->artifact->getId();
    }
    
    /**
     * @return string
     */
    public function getArtifactTitle() {
        return $this->artifact->getTitle();
    }
    
    /**
     * @return int
     */
    public function getId() {
        return $this->artifact->getId();
    }
    
    /**
     * @return string
     */
    public function getTitle() {
        return $this->artifact->getTitle();
    }
    
    /**
     * @return int
     */
    public function getPlanningId() {
        return $this->planning->getId();
    }
    
    /**
     * @return TreeNode
     */
    public function getPlannedArtifacts() {
        return $this->planned_artifacts;
    }
    
    public function getLinkedArtifacts() {
        return $this->artifact->getLinkedArtifacts();
    }
}

/**
 * Null-object pattern for planning milestones.
 */
class Planning_NoMilestone extends Planning_Milestone {
    
    /**
     * Instanciates a null-object compatible with the Planning_Milestone
     * interface.
     * 
     * TODO:
     *   - Rename to NullMilestone ?
     *   - Use a NullPlanning object ?
     *   - $group_id must die
     * 
     * @param int      $group_id
     * @param Planning $planning 
     */
    public function __construct($group_id, Planning $planning) {
        // not calling the super constructor allows us not enforce non nullity on the artifact
        $this->group_id          = $group_id;
        $this->planning          = $planning;
    }
    
    /**
     * @param User $user
     * @return boolean 
     */
    public function userCanView(User $user) {
        return true; // User can view milestone content, since it's empty.
    }

    /**
     * @return int
     */
    public function getArtifactId() {
        return null;
    }
    
    public function getArtifactTitle() {
        return null;
    }
    

}
?>
