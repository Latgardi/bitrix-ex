<?php
AddEventHandler('main', 'OnBuildGlobalMenu', Array("EventHandlers", "simplifiedGlobalMenu"));

class EventHandlers
{
	function simplifiedGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
	{
		global $USER;
		$userID = $USER->GetID();
		if (in_array(6, $USER::GetUserGroup($userID))) {
			$deleted = array();
			foreach (array_keys($aGlobalMenu) as $key) {
				if ($key == "global_menu_content") {
					continue;
				}
				unset($aGlobalMenu[$key]);
				$deleted[] = $key;
			}

			foreach ($aModuleMenu as $key => $item) {
				if (in_array($item["parent_menu"], $deleted, true)) {
					unset($aModuleMenu[$key]);
				}
				if ($item["parent_menu"]=="global_menu_content" && $item["text"]=="Новости") {
					continue;
				}
				unset($aModuleMenu[$key]);
			}
		}
	}
}