<?php
final class Shadowlang
{
	private static $LANG_NPC = array();
	private static $LANG_QUEST = array();
	private static $LANG_LOCATION = array();
	private static $LANG_ITEM;
	private static $LANG_HELP;
	private static $LANG_VARS;
	private static $LANG_VARIABLES;
	
	public static function getItemFile() { return self::$LANG_ITEM; }
	public static function getHelpFile() { return self::$LANG_HELP; }
	public static function getVarFile() { return self::$LANG_VARS; }
	public static function getVariableFile() { return self::$LANG_VARIABLES; }
	
	public static function onLoadLanguage()
	{
		$dir = Shadowrun4::getShadowDir();
		self::$LANG_NPC = array(); # flush caches too.
		self::$LANG_QUEST = array();
		self::$LANG_LOCATION = array();
		self::$LANG_HELP = new GWF_LangTrans("{$dir}/lang/help/shadowhelp");
		self::$LANG_ITEM = new GWF_LangTrans("{$dir}/lang/item/shadowitems");
		self::$LANG_VARS = new GWF_LangTrans("{$dir}/lang/vars/vars");
		self::$LANG_VARIABLES = new GWF_LangTrans("{$dir}/lang/variables/variables");
	}
	
	############
	### NPCs ###
	############
	
	public static function langNPC(SR_NPC $npc, SR_Player $player, $key, $args=NULL)
	{
		return self::getLangNPC($npc)->langISO($player->getLangISO(), $key, $args);
	}
	
	/**
	 * Get a lang file for an NPC.
	 * @param SR_NPC $npc
	 * @return GWF_LangTrans
	 */
	private static function getLangNPC(SR_NPC $npc)
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
			die(sprintf('NPC %s does not follow naming conventions 1!'));
		}
		$cls = strtolower($cls);
		
		# Get cityname
		if (false === ($city = $npc->getNPCCityClass()))
		{
			die(sprintf('NPC %s does not follow naming conventions 2!'));
		}
		$cityname = $city->getName();
		
		
		# Cache npcs here
		$path = sprintf('%scity/%s/lang/npc/%s/%s', Shadowrun4::getShadowDir(), $cityname, $cls, $cls);
		self::$LANG_NPC[$cl] = new GWF_LangTrans($path);

		# And return the langfile!
		return self::$LANG_NPC[$cl];
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

	/**
	 * Get a lang file for a location.
	 * @param SR_Quest $quest
	 * @return GWF_LangTrans
	 */
	private static function getLangLocation(SR_Location $location)
	{
		$locname = $location->getName();
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
	public static function displayItemname(SR_Player $player, SR_Item $item)
	{
		return self::$LANG_ITEM->langISO($player->getLangISO(), $item->getName());
	}
	
	public static function displayItemdescr(SR_Player $player, SR_Item $item)
	{
		return self::$LANG_ITEM->langISO($player->getLangISO(), $item->getName().'__desc__');
	}
	
	public static function displayItemnameFull(SR_Player $player, SR_Item $item)
	{
		$back = self::displayItemname($player, $item);
		if ($this->modifiers === NULL)
		{
			return $back;
		}
		$mod = '';
		foreach ($this->modifiers as $key => $value)
		{
			$key = Shadowfunc::translateVariable($player, $key);
			$mod .= sprintf(',%s:%s', $key, $value);
		}
		return $back.$player->lang('of').substr($mod, 1);
	}
}
?>