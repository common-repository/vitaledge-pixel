<?php 

namespace VItalEdgeInc\VeApi\VeCallbacks;

use \VitalEdgeInc\VeCore\VeBaseController;

class VeAdminCallbacks extends VeBaseController
{
    public function adminDashboard()
    {
        return require_once("$this->plugin_path/VitalEdgeTemplates/admin.php");
    }

}