<?php
/**
 * BreadcrumbList
 * Breadcrumbs with microdata
 *
 * PHP version 5.4
 *
 * @category Extension
 * @package  BreadcrumbList
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GPL http://www.gnu.org/licenses/gpl.html
 * @link     https://github.com/ShakePeers/mediawiki-BreadcrumbList
 * */
$wgExtensionCredits['validextensionclass'][] = array(
   'name' => 'BreadcrumbList',
   'author' =>'ShakePeers', 
   'url' => 'http://shakepeers.org/'
);

/**
 * Display breadcrumbs
 *
 * @param OutputPage $out HTML page
 * 
 * @return void
 * */
function breadcrumbList(&$out)
{
    global $wgScriptPath, $wgTitle, $wgScriptPath, $wgSitename;
    $NsTitle = Title::newFromText($wgTitle->getNsText());
    $html = '
    <ol class="breadcrumb_list">
        <li itemscope id="bread_wiki" ';
    if (isset($NsTitle)) {
        $html .= 'itemref="bread_ns"';
    } else {
        $html .= 'itemref="bread_title"';
    }
    $html .= ' itemtype="http://data-vocabulary.org/Breadcrumb">
        <a itemprop="url" href="'.$wgScriptPath.'/">
            <span itemprop="title">'.$wgSitename.'</span></a>
        </li>';
    if (isset($NsTitle)) {
        $html .= ' › <li id="bread_ns" itemscope
                itemprop="child" itemref="bread_title"
                itemtype="http://data-vocabulary.org/Breadcrumb">
            <a itemprop="url" href="'.$NsTitle->getLocalURL().'">
                <span itemprop="title">'.$NsTitle->getBaseText().'</span></a>
            </li>';
    }
    $html .= ' › <li id="bread_title" itemscope itemprop="child" ';
    if ($wgTitle->isSubpage()) {
        $html .= 'itemref="bread_sub"';
    }
    $html .= ' itemtype="http://data-vocabulary.org/Breadcrumb">
        <a itemprop="url" href="'.$wgTitle->getBaseTitle()->getLocalURL().'">
            <span itemprop="title">'.$wgTitle->getBaseText().'</span></a>
        </li>';
    if ($wgTitle->isSubpage()) {
        $html .= ' › <li id="bread_sub" itemscope itemprop="child"
                itemtype="http://data-vocabulary.org/Breadcrumb">
            <a itemprop="url" href="'.$wgTitle->getLocalURL().'">
            <span itemprop="title">'.$wgTitle->getSubpageText().'</span></a>
            </li>';
    }
    $html .= '</ol>';
    $out->prependHTML($html);
    $out->addStyle($wgScriptPath.'/extensions/BreadcrumbList/breadcrumb.css');
}

$wgHooks['BeforePageDisplay'][] = 'breadcrumbList';
?>
