<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 30/12/2019
 * Time: 16:09
 */

namespace humhub\modules\map;

class AccessFiles extends \humhub\libs\BasePermission
{

    /**
     * @inheritdoc
     */
    public $defaultAllowedGroups = [
        Space::USERGROUP_OWNER,
        Space::USERGROUP_ADMIN,
        Space::USERGROUP_MODERATOR,
        Space::USERGROUP_MEMBER,
    ];

    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
        Space::USERGROUP_USER
    ];

    /**
     * @inheritdoc
     */
    protected $title = "Geospatial Exploration";


    /**
     * @inheritdoc
     */
    protected $description = "Allows the user to access his files";

    /**
     * @inheritdoc
     */
    protected $moduleId = 'map';

}
