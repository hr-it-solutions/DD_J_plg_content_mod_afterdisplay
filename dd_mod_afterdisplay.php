<?php
/**
 * @package    DD_Mod_AfterDisplay
 *
 * @author     HR IT-Solutions Florian Häusler <info@hr-it-solutions.com>
 * @copyright  Copyright (C) 2017 - 2017 Didldu e.K. | HR IT-Solutions
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 **/

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');
jimport('joomla.access.access');

/**
 * Class PlgContentDD_YouTube_Video
 *
 * @since  Version  1.0.0.0
 */
class PlgContentDD_Mod_AfterDisplay extends JPlugin
{
	/**
	 * onContentAfterDisplay
	 *
	 * @param   string   $context  The context of the content being passed to the plugin
	 * @param   object   &$row     The article object
	 * @param   object   &$params  The article params
	 * @param   integer  $page     The 'page' number
	 *
	 * @return  string|boolean  HTML string containing the html for the module if loaded else boolean false
	 *
	 * @since   1.0.0
	 */
	public function onContentAfterDisplay($context, &$row, &$params, $page = 0)
	{
		// Don't run this plugin when the content is being indexed
		if ($context === 'com_finder.indexer')
		{
			return true;
		}

		// Get plugin parameter
		$customposition  = (string) $this->params->get('customposition');

		return $this->_load($customposition);
	}

	/**
	 * Loads and renders the module into $this->html
	 *
	 * @param   string  $position  The position assigned to the module
	 * @param   string  $style     The style assigned to the module
	 *
	 * @return  boolean|string  HTML string containing the html for the module if loaded else boolean false
	 *
	 * @since   1.0.0.0
	 */
	protected function _load($position, $style = 'none')
	{
		$modules = JModuleHelper::getModules($position);
		$params  = array('style' => $style);

		if (count($modules))
		{
			$modules = array_chunk($modules, 2);

			ob_start();

			foreach ($modules as $modulegroup)
			{
				echo '<div class="row-fluid">';

				foreach ($modulegroup as $module) :
					echo '<div class="span12">';
					echo JModuleHelper::renderModule($module, $params);
					echo '</div>';
				endforeach;

				echo '</div>';
			}

			return ob_get_clean();
		}
		else
		{
			return false;
		}
	}
}
