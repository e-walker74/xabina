<?php

class XBreadcrumbsForModule extends CWidget
{
	/**
	 * @var string the tag name for the breadcrumbs container tag. Defaults to 'div'.
	 */
	public $tagName='div';
	/**
	 * @var array the HTML attributes for the breadcrumbs container tag.
	 */
	public $htmlOptions=array('class'=>'module-breadcrumbs');
	/**
	 * @var boolean whether to HTML encode the link labels. Defaults to true.
	 */
	public $encodeLabel=true;
	/**
	 * @var string the first hyperlink in the breadcrumbs (called home link).
	 * If this property is not set, it defaults to a link pointing to {@link CWebApplication::homeUrl} with label 'Home'.
	 * If this property is false, the home link will not be rendered.
	 */
	public $homeLink;
	/**
	 * @var array list of hyperlinks to appear in the breadcrumbs. If this property is empty,
	 * the widget will not render anything. Each key-value pair in the array
	 * will be used to generate a hyperlink by calling CHtml::link(key, value). For this reason, the key
	 * refers to the label of the link while the value can be a string or an array (used to
	 * create a URL). For more details, please refer to {@link CHtml::link}.
	 * If an element's key is an integer, it means the element will be rendered as a label only (meaning the current page).
	 *
	 * The following example will generate breadcrumbs as "Home > Sample post > Edit", where "Home" points to the homepage,
	 * "Sample post" points to the "index.php?r=post/view&id=12" page, and "Edit" is a label. Note that the "Home" link
	 * is specified via {@link homeLink} separately.
	 *
	 * <pre>
	 * array(
	 *     'Sample post'=>array('post/view', 'id'=>12),
	 *     'Edit',
	 * )
	 * </pre>
	 */
	public $links=array();
	/**
	 * @var string String, specifies how each active item is rendered. Defaults to
	 * "<a href="{url}">{label}</a>", where "{label}" will be replaced by the corresponding item
	 * label while "{url}" will be replaced by the URL of the item.
	 * @since 1.1.11
	 */
	public $activeLinkTemplate='{subMenu}<a class="{class}" href="{url}">{label}</a>';
	/**
	 * @var string String, specifies how each inactive item is rendered. Defaults to
	 * "<span>{label}</span>", where "{label}" will be replaced by the corresponding item label.
	 * Note that inactive template does not have "{url}" parameter.
	 * @since 1.1.11
	 */
	public $inactiveLinkTemplate='<span class="{class}">{label}</span>';
	/**
	 * @var string the separator between links in the breadcrumbs. Defaults to ' &raquo; '.
	 */
	public $separator='<span class="del"></span>';

    public $subMenuTemplate = '<span class="relative">
            <a href="#" data-toggle="dropdown" class="s-crumb"></a>
            <ul class="dropdown-menu menu-b-wa list-unstyled" role="menu">
                <li class="arr"></li>
                {links}
            </ul>
        </span>';

    public $subMenuLinkTemplate = '<li class="clearfix {class}"><a href="{url}">{label}</a></li>';

	/**
	 * Renders the content of the portlet.
	 */
	public function run()
	{
        $back = '';
        if(count($this->links) > 1){
            $back = CHtml::link('', '', array('class' => 'back'));
            $this->bindBackButton();
        }

		echo $back . CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		$links=array();
		$i = 1;
		foreach($this->links as $label=>$params)
		{
            if(!isset($params['url']) || !is_array($params['url'])){
                continue;
            }
            $class = 'crumb';
            if($i == (count($this->links) - 1)){
                $class = 'pre crumb';
            }
            $i++;
            $links[]=strtr($this->activeLinkTemplate,array(
                '{class}'=>$class,
                '{url}'=>CHtml::normalizeUrl($params['url']),
                '{label}'=>$this->encodeLabel ? CHtml::encode($label) : $label,
                '{subMenu}' => (isset($params['subMenu']) && is_array($params['subMenu'])) ? $this->generateSubMenu($params['subMenu']) : '',
            ));
		}
		echo implode($this->separator,$links);
		echo CHtml::closeTag($this->tagName);
	}

    public function generateSubMenu($subUrls){
        $links = array();
        $i = 0;
        foreach($subUrls as $label => $url){
            $links[]=strtr($this->subMenuLinkTemplate,array(
                '{class}'=>($i) ? '' : 'no-border',
                '{url}'=>CHtml::normalizeUrl($url),
                '{label}'=>$this->encodeLabel ? CHtml::encode($label) : $label,
            ));
            $i++;
        }

        $html = implode('', $links);

        return strtr($this->subMenuTemplate,array(
            '{links}'=>$html,
        ));
    }

    public function bindBackButton(){
        Yii::app()->clientScript->registerScript('bindBackButton', '
            $(".module-breadcrumbs-panel .back").click(function(){
                window.location = $(".module-breadcrumbs .crumb.pre").attr("href")
                return false;
            })
        ', CClientScript::POS_END);
    }
}