<?php

namespace VitalEdgeInc\VeCore;
use \VitalEdgeInc\VeApi\VePixelApi;

class VeDeactivate
{
	public static function deactivate() {
		flush_rewrite_rules();
		//uninstall api
		$vitaledge = new VePixelApi();
		$vitaledge->uninstall();
	}
}