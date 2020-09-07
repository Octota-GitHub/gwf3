<?php
final class Shadowlang
{
	private static $LANG_NPC = array();
	private static $LANG_QUEST = array();
	private static $LANG_LOCATION = array();
	private static $LANG_ITEM;
	private static $LANG_ITEM_UUID;
	private static $LANG_STAT_UUID;
	private static $LANG_HELP;
	private static $LANG_EQ;
	private static $LANG_VARS;
	private static $LANG_VARIABLES;
	
	public static function getItemFile() { return self::$LANG_ITEM; }
	public static function getHelpFile() { return self::$LANG_HELP; }
	public static function getEqFile() { return self::$LANG_EQ; }
	public static function getVarFile() { return self::$LANG_VARS; }
	public static function getVariableFile() { return self::$LANG_VARIABLES; }
	public static function getStatUUIDFile() { return self::$LANG_STAT_UUID; }
	
	public static function onLoadLanguage()
	{
		$dir = Shadowrun4::getShadowDir();
		self::$LANG_NPC = array(); # flush caches too.
		self::$LANG_QUEST = array();
		self::$LANG_LOCATION = array();
		self::$LANG_HELP = new GWF_LangTrans("{$dir}lang/help/shadowhelp");
		self::$LANG_ITEM = new GWF_LangTrans("{$dir}lang/item/shadowitems");
		self::$LANG_ITEM_UUID = new GWF_LangTrans("{$dir}data/itemuuid/itemuuid");
		self::$LANG_STAT_UUID = new GWF_LangTrans("{$dir}data/statuuid/statuuid");
		self::$LANG_EQ = new GWF_LangTrans("{$dir}lang/eq/eq");
		self::$LANG_VARS = new GWF_LangTrans("{$dir}lang/vars/vars");
		self::$LANG_VARIABLES = new GWF_LangTrans("{$dir}lang/variables/variables");
	}
	
	############
	### NPCs ###
	############
	public static function langNPC(SR_NPC $npc, SR_Player $player, $key, $args=NULL)
	{
		return self::langNPCISO($npc, $player->getLangISO(), $key, $args);
	}
	
	public static function langNPCISO(SR_NPC $npc, $iso, $key, $args=NULL)
	{
		return self::getLangNPC($npc)->langISO($iso, $key, $args);
	}
	
	public static function langRealNPC(SR_NPC $npc, $key, $args=NULL)
	{
		return self::langNPCISO($npc, 'en', $key, $args);
	}
	
	public static function langRealNPCTree(SR_NPC $npc, $key, $args=NULL)
	{
		return self::langNPC($npc)->getTrans();
	}
	
	/**
	 * Get a lang file for an NPC.
	 * @param SR_NPC $npc
	 * @return GWF_LangTrans
	 */
	public static function getLangNPC(SR_NPC $npc)
	{
		# Full classname
		$cl = $npc->getNPCClassName();
	
		# Cache hit?
		if (true === isset(self::$LANG_NPC[$cl]))
		{
			return self::$LANG_NPC[$cl];
		}
	
		# Get classname without city
		if (false === ($cls = Common::substrFrom($cl, '_', false)))
		{
			die(sprintf('NPC %s does not follow naming conventions 1!', $npc->getClassName()));
		}
		$cls = strtolower($cls);
		
		# Get cityname
		if (false === ($city = $npc->getNPCCityClass()))
		{
			die(sprintf('NPC %s does not follow naming conventions 2!', $npc->getClassName()));
		}
		$cityname = $city->getName();
		
		
		# Cache npcs here
		$path = sprintf('%scity/%s/lang/npc/%s/%s', Shadowrun4::getShadowDir(), $cityname, $cls, $cls);
		self::$LANG_NPC[$cl] = new GWF_LangTrans($path);

		# And return the langfile!
		return self::$LANG_NPC[$cl];
	}
	
	public static function hasLangNPC(SR_NPC $npc, SR_Player $player, $word)
	{
		return self::hasLangNPCISO($npc, $player->getLangISO(), $word);
	}
	
	public static function hasLangNPCISO(SR_NPC $npc, $iso, $word)
	{
		return array_key_exists($word, self::getLangNPC($npc)->getTrans($iso));
	}
	
	public static function hasLangRealNPC(SR_NPC $npc, $word)
	{
		return self::hasLangNPCISO($npc, 'en', $word);
	}
	
	##############
	### Quests ###
	##############
	
	public static function langQuest(SR_Quest $quest, SR_Player $player, $key, $args)
	{
		return self::getLangQuest($quest)->langISO($player->getLangISO(), $key, $args);
	}
	
	/**
	 * Get a lang file for a quest.
	 * @param SR_Quest $quest
	 * @return GWF_LangTrans
	 */
	private static function getLangQuest(SR_Quest $quest)
	{
		$cl = $quest->getName();
		if (!isset(self::$LANG_QUEST[$cl]))
		{
			$cll = strtolower($cl);
			$path = sprintf('%scity/%s/lang/quest/%s/%s', Shadowrun4::getShadowDir(), $quest->getCityName(), $cll, $cll);
// 			echo "Loading $path\n";
			self::$LANG_QUEST[$cl] = new GWF_LangTrans($path);
		}
		return self::$LANG_QUEST[$cl];
	}

	#################
	### Locations ###
	#################
	
	public static function langLocation(SR_Location $location, SR_Player $player, $key, $args=NULL)
	{
		return self::getLangLocation($location)->langISO($player->getLangISO(), $key, $args);
	}
	
	public static function hasLangLocation(SR_Location $location, $key)
	{
		return array_key_exists($key, self::getLangLocation($location)->getTrans('en'));
	}
	
	/**
	 * Get a lang file for a location.
	 * @param SR_Quest $quest
	 * @return GWF_LangTrans
	 */
	private static function getLangLocation(SR_Location $location)
	{
// 		$locname = $location->getName();
		$locname = $location->getLangfileName();
		if (false === isset(self::$LANG_LOCATION[$locname]))
		{
			$llocname = strtolower(Common::substrFrom($locname, '_'));
			$path = sprintf('%scity/%s/lang/location/%s/%s', Shadowrun4::getShadowDir(), $location->getCity(), $llocname, $llocname);
			self::$LANG_LOCATION[$locname] = new GWF_LangTrans($path);
		}
		return self::$LANG_LOCATION[$locname];
	}
	
	#################
	### Variables ###
	#################
	public static function langVar(SR_Player $player, $key, $args=NULL)
	{
		return self::$LANG_VARS->langISO($player->getLangISO(), $key, $args);
	}

	public static function langVariable(SR_Player $player, $key, $args=NULL)
	{
		return self::$LANG_VARIABLES->langISO($player->getLangISO(), $key, $args);
	}
	
	#############
	### Items ###
	#############
	public static function displayItemname(SR_Player $player, SR_Item $item, $colors=true)
	{
		$back = self::$LANG_ITEM->langISO($player->getLangISO(), $item->getName());
		if ($colors)
		{
			if ($item->isItemRare())
			{
				return "\X02\X035{$back}\X03\X02";
			}
			elseif (false !== SR_SetItems::getSetForItem($item->getName()))
			{
				return "\X02\X036{$back}\X03\X02";
			}
		}
		return $back;
	}
	
	public static function displayItemdescr(SR_Player $player, SR_Item $item)
	{
		return self::$LANG_ITEM->langISO($player->getLangISO(), $item->getName().'__desc__');
	}
	
	public static function displayItemnameFull(SR_Player $player, SR_Item $item, $short_mods=false, $colors=true)
	{
		$back = self::displayItemname($player, $item, false);

		if (NULL !== ($mods = $item->getItemModifiersB()))
		{
			$mod = '';
			$format = $player->lang('fmt_itemmods');
			foreach ($mods as $key => $value)
			{
				$key = $short_mods
					? Shadowfunc::shortcutVariable($player, $key)
					: Shadowfunc::translateVariable($player, $key);
				
				$mod .= sprintf($format, $key, $value);
			}
			$back = $back.$player->lang('of').ltrim($mod, ',; ');
		}
		
		if ($colors)
		{
			if ($item->isItemRare())
			{
				return "\X02\X035{$back}\X03\X02";
			}
			elseif (false !== SR_SetItems::getSetForItemNoSubstring($item->getName()))
			{
				return "\X02\X036{$back}\X03\X02";
			}
		}
		
		return $back;
	}

	public static function itemNameForSearch(SR_Item $item, $iso)
	{
		$back = self::$LANG_ITEM->langISO($iso, $item->getName());

		if (NULL !== ($mods = $item->getItemModifiersB()))
		{
			$mod = '';
		        $format = DOGMOD_Shadowlamb::instance()->langISO($iso, 'fmt_itemmods');
			foreach ($mods as $key => $value)
			{
				$key = self::$LANG_VARIABLES->langISO($iso, $key);
				$mod .= sprintf($format, $key, $value);
			}
		        $of = DOGMOD_Shadowlamb::instance()->langISO($iso, 'of');
			$back = $back.$of.ltrim($mod, ',; ');
		}
		
		return $back;
	}
	
	public static function getItemUUID(SR_Item $item)
	{
		return Shadowfunc::shortcut($item->getName(), self::$LANG_ITEM_UUID->getTrans('en'));
	}
	
	public static function getStatUUID($field)
	{
		return Shadowfunc::shortcut($field, self::$LANG_STAT_UUID->getTrans('en'));
	}
	
	public static function displayItemNameS($itemname)
	{
		return self::displayItemnameFull(Shadowrun4::getCurrentPlayer(), SR_Item::createByName($itemname, 1, false));
	}
}
?>
