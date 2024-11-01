<?php

namespace VitalEdgeInc\VeCore;
use \VitalEdgeInc\VeApi\VePixelApi;

class VeActivate
{
	public static function activate() {
		flush_rewrite_rules();
		//install endpoint
		$vitaledge = new VePixelApi();
		$vitaledge->install();
	}
}