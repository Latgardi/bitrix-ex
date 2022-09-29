<?php
global $adminMenu;
global $USER;

$userID = $USER->GetID();
if (in_array(6, $USER::GetUserGroup($userID))) {
	unset($adminMenu->aGlobalMenu["global_menu_crm_site_master"]);
	unset($adminMenu->aGlobalMenu["global_menu_b24connector"]);
}