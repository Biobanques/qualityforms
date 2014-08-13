<?php
/**
 * HelpDivWidget class file.<br>
 * widget ti display a cliquable div showing a contextual help.
 *
 * @author Malservet Nicolas <nicolas.malservet@inserm.fr>
 * @copyright Copyright &copy; 2014 Biobanques
 */
class HelpDivComponent
{
        
        public static function getHtml($uniqueId,$textLabel)
	{
		$html= "<script>function toggleHelp(eltId)
                {
                var elt = document.getElementById(eltId);
                elt.style.display = (elt.style.display == \"block\") ? \"none\" : \"block\";
                }</script>";
		$html.= "<a   style=\"margin: 0px 0px 0px 5px;\" onclick=\"toggleHelp('".$uniqueId."')\">";
		$html.=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
		$html.="</a>";
		$html.="
		<!-- div aide advanced search -->
		<div id=\"".$uniqueId."\" style=\"display:none;margin-top: 5px;border:1px solid blueviolet;background: #eeeeee;padding:5px;\">
                    <img src=\"".Yii::app()->request->baseUrl.'/images/'."help.png\"/ style=\"margin-right: 5px;\">
		<p style=\"display:inline;\">
		".$textLabel."
		</p>
		</div>";
                return $html;
	}
}
