<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Codeigniter Multilevel menu Class
 * Provide easy way to render multi level menu
 * 
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Paolo Castillo
 */
class CI_Menu
{
	protected $ci;
	/**
	* [$nav_tag_open tag de apertura del menu]
	* @var string
	*/
	public $nav_tag_open             = '<ul>';
	/**
	* [$nav_tag_close tag de cierre del menu]
	* @var string
	*/
	public $nav_tag_close            = '</ul>';
	/**
	* [$item_tag_open tag de apertura del item del menu]
	* @var string
	*/
	public $item_tag_open            = '<li>';
	/**
	* [$item_tag_close tag de cierre de cada item del menu]
	* @var string
	*/
	public $item_tag_close           = '</li>';
	/**
	* [$parent_tag_open tag de hijo de cada item]
	* @var string
	*/
	public $parent_tag_open          = '<li>';
	/**
	* [$parent_tag_close tag del cierre de cada item hijo]
	* @var string
	*/
	public $parent_tag_close         = '</li>';
	/**
	* [$parent_anchor link del hijo contenido en el item menu]
	* @var string
	*/
	public $parent_anchor            = '<a href="%s">%s</a>';
	
	public $parentl1_tag_open        = '';
	
	public $parentl1_tag_close       = '';
	
	public $parentl1_anchor          = '';
	/**
	* [$children_tag_open tag de apertura del menu hijo]
	* @var string
	*/
	public $children_tag_open        = '<ul>';
	/**
	* [$children_tag_close tag de cierre del menu hijo]
	* @var string
	*/
	public $children_tag_close       = '</ul>';
	/**
	* [$item_active_class Clase active del menu en tag li seleccionado]
	* @var string
	*/
	public $item_active_class        = 'active';	
	/**
	* [$item_active agregar clase adicionales]
	* @var string
	*/
	public $item_active              = '';	
	/**
	* [$item_anchor menu de tag ul con link]
	* @var string
	*/
	public $item_anchor              = '<a href="%s">%s</a>';
	/**
	* [$divided_items_list numero de item que estan divido]
	* @var array
	*/
	public $divided_items_list       = array();
	/**
	* [$divided_items_list_count contador de lista]
	* @var integer
	*/
	public $divided_items_list_count = 0;
	/**
	* [$item_divider dividir item]
	* ej: <li class                  ="divider"></li>
	* @var string
	*/
	public $item_divider            = '';
	/**
	 * [$menu_id id del menu de la db]
	 * @var string
	 */
	public $menu_id                 = 'ID_MENU';
	/**
	 * [$menu_label descripcion del menu a visualizar]
	 * @var string
	 */
	public $menu_label              = 'NOMBRE';
	/**
	 * [$menu_key url a navegar]
	 * @var string
	 */
	public $menu_key                = 'KEY';
	/**
	 * [$menu_parent si tiene un padre en el menu]
	 * @var string
	 */
	public $menu_parent             = 'PADRE';
	/**
	 * [$menu_order orden del menu]
	 * @var string
	 */
	public $menu_order              = 'ORDEN';
	/**
	 * [$menu_icon icono del menu]
	 * @var string
	 */
	public $menu_icon               = 'ICONO';
	/**
	 * [$icon_position posicion del contenido]
	 * @var string
	 */
	public $icon_position           = 'left';
	/**
	 * [$icon_img_base_url si tiene imagen en la url]
	 * @var null
	 */
	public $icon_img_base_url       = null;
	/**
	 * [$menu_icons_list lista de icono en el menu]
	 * @var null
	 */
	public $menu_icons_list         = 'PADRE';
	/**
	 * [$menu_icons_list lista de icono en el menu]
	 * @var null
	 */
	public $icons_list              = 'ATRIBUTO1';
	/**
	 * [$_additional_item agregar lista adicionales]
	 * @var array
	 */
	public $_additional_item        = array();
	/**
	 * [$item_list agregar lista adicionales]
	 * @var array
	 */
	public $item_list               = array();
	/**
	 * [$uri_segment uri de la ur /$1 ]
	 * @var integer
	 */
	public $uri_segment             = 1;
	/**
	 * [__construct constructor de la clase]
	 */
    public function __construct()
    {
    	/**
    	 * [$this->ci call la instancia del proyecto y cargar url]
    	 * @var [type]
    	 */
		$this->ci =& get_instance();
		$this->ci->load->helper('url');
    	$this->ci->load->model('M_menu','menu');
		$config["nav_tag_open"]          = '<ul class="sidebar-menu" data-widget="tree"><li class="header">MENU DE NAVEGACIÓN</li>';
		$config["parent_tag_open"]       = '<li class="treeview">';	
		$config["children_tag_open"]     = '<ul class="treeview-menu">';
		/**
		 * Inicializar la configuracion
		 */
		$item = $this->ci->menu->get_menu();
		$this->initialize($config);
		$this->set_items($item);
    }

    /**
     * [initialize inicializar menu multiple]
     * @param  array  $config [niveles de configuracion del menu]
     * @return [type]         [description]
     */
	public function initialize($config = array())
	{
		if (!empty($config)) {
			foreach ($config as $key => $value) {
				$this->$key = $value;
			}
		}
		$this->divided_items_list_count = count($this->divided_items_list);
	}
	/**
	 * [set_divided_items Especifica que item podria estar divido]
	 * @param array  $items   [array del menu key]
	 * @param [type] $divider [divicion]
	 */
	public function set_divided_items($items = array(), $divider = null)
	{
		if ( count($items) ) 
		{
			$this->divided_items_list       = $items;
			$this->item_divider             = $divider ? $divider : $this->item_divider;
			$this->divided_items_list_count = count($this->divided_items_list);
		}
	}

	/**
	 * [render crear menu]
	 * @param  array  $config             configurar la libreria del menu, si no esta difinida usa la default
	 * @param  array  $divided_items_list [item del menu que podria estar divido]
	 * @param  string $divider            [divicion del menu]
	 * @return [type]                     [description]
	 */
    public function render($config = array(), $divided_items_list = array(), $divider = '')
    {
		$html  = "";

		if ( is_array($config) ) {
			$this->initialize($config);	
		}
		elseif (is_string($config)) {
			$this->item_active = $config;
		}

    	if ( count($this->items) ) 
    	{
			$items = $this->prepare_items($this->items);		

			$this->set_divided_items($divided_items_list, $divider);
	        $this->render_item($items, $html);
    	}
        return $html;
    }
    /**
     * [set_items agregar los item al item]
     * @param array $items [description]
     */
 	public function set_items($items = array())
    {
    	$this->items = $items;
    }

    /**
     * [prepare_items preparar los item antes de inicializar]
     * @param  array  $data   [arreglo de la query]
     * @param  [type] $parent [parametro de los items]
     * @return [type]         [description]
     */
    private function prepare_items(array $data, $parent = null)
    {
    	$items = array();
		foreach ($data as $item) 
		{
			if ($item[$this->menu_parent] == $parent) 
			{
				$items[$item[$this->menu_id]] = $item;
				$items[$item[$this->menu_id]]['children'] = $this->prepare_items($data, $item[$this->menu_id]);
			}	
		}

		// antes de crear los item pasa por el constructor
		// ordenar los item
		usort($items,array($this, 'sort_by_order'));

		return $items;
    }
    /**
     * [sort_by_order order menu]
     * @param  [type] $a [a el 1st para comparar]
     * @param  [type] $b [b el 2st para comparar]
     * @return [type]    [description]
     */
    private function sort_by_order($a, $b)
    {
    	return $a[$this->menu_order] - $b[$this->menu_order];
    }
    /**
     * [render_item creacion de los item]
     * @param  [type] $items [item del menu]
     * @param  string &$html [formato html a formar]
     * @return [type]        [description]
     */
   	private function render_item($items, &$html = '')
	{
		// die(var_dump($items));
		if ( empty($html) ) {
			$nav_tag_open = true;
			$html .= $this->nav_tag_open;
			if ( !empty($this->_additional_item['first']) ) {
				$html .= $this->_additional_item['first'];
			}
		}
		else{
			$html .= $this->children_tag_open;
		}

		foreach ($items as $item) {
			if ( isset($item[$this->menu_label], $item['KEY']) ) 
	        {
	        	$label = $item[$this->menu_label];

		        // icon
		        $icon  = empty($item[$this->menu_icon]) ? '' : $item[$this->menu_icon];
		        
		        if ( isset($this->menu_icons_list[($item['KEY'])]) ) {
		        	$icon = $this->menu_icons_list[($item['KEY'])];
		        }

        		$slug  = $item[$this->menu_key];
        		$this->item_active = $item[$this->menu_key];

        		if ( $icon ) {
    				$icon = "<i class='{$item[$this->menu_icon]}'></i>";

        			if ($item[$this->icons_list] == null) {
        				$label = trim( $this->icon_position == 'right' ? ('<span>'.$label.'</span> '. $icon ) : ($icon .' <span> '. $label .'</span>') );
        			}else{
			        	$label = trim( $this->icon_position == 'right' ? ('<span>'.$label.'</span> '. $icon ) : ($icon .' <span> '. $label .'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>') );
				        if (in_array($slug, $this->divided_items_list)) {
				        	$label .= '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>';
				        }
        			}

        		}

		        // menu slug
		        $has_children = ! empty($item['children']);	        

		        // if menu item need separator 
		        if ($this->divided_items_list_count > 0 && in_array($slug, $this->divided_items_list)) {
		        	$html .= $this->item_divider;	
		        }


		        if ($has_children) 
		        {
		        	if ( is_null($item[$this->menu_parent]) && $this->parentl1_tag_open != '' ) 
		        	{
						$tag_open    =  $this->parentl1_tag_open;
						$item_anchor = $this->parentl1_anchor != '' ? $this->parentl1_anchor : $this->parent_anchor;
		        	}
		        	else 
		        	{
						$tag_open     = $this->parent_tag_open;
						$item_anchor = $this->parent_anchor;						
		        	}

					$href  = '#';				
		        }
		        else 
		        {
		        	$tag_open    = $this->item_tag_open;
					$href        = site_url($slug);
					$item_anchor = $this->item_anchor;
		        }

				$html .= $this->set_active($tag_open, $slug);	        	        

				if (substr_count($item_anchor, '%s') == 2) {
					$html .= sprintf($item_anchor, $href, $label);
				}
				else {
					$html .= sprintf($item_anchor, $label);	
				}

		        if ( $has_children ) 
		        {	        	
		            $this->render_item($item['children'], $html);

		            if ( is_null($item[$this->menu_parent]) && $this->parentl1_tag_close != '' ) {
		        		$html .= $this->parentl1_tag_close;
		        	}
		        	else {
						$html  .= $this->parent_tag_close;
		        	}	            
		        }
		        else {
		        	$html .= $this->item_tag_close; 
		        }

	        }
		}

	    if (isset($nav_tag_opened)) 
	    {
	    	if ( ! empty($this->_additional_item['last'])) {
				$html .= $this->_additional_item['last'];
			}

	    	$html .= $this->nav_tag_close; 
	    }
	    else {	   
	    	$html  .= $this->children_tag_close;
	    }
		// die(var_dump($html));
	}

	/**
	 * [inject_item injectar item adicionales]
	 * @param  [type] $item     [item del menu]
	 * @param  [type] $position [posicion]
	 * @return [type]           [description]
	 */
	public function inject_item($item, $position = null)
	{
		if (empty($position)) {
			$position = 'last';
		}

		$this->_additional_item[$position] = $item;
		return $this;
	}

	private function set_active($html, $slug)
	{
		$segment = $this->ci->uri->segment($this->uri_segment);
		// print_r($this->item_active);
		// die(var_dump($this->ci->uri->uri_string()));
		if ( ($this->item_active != '' && $slug == $this->item_active && empty($segment)) || $slug == $segment) 
		{
			$doc = new DOMDocument();
			$doc->loadHTML($html);
			foreach($doc->getElementsByTagName('*') as $tag ){
				$tag->setAttribute('class', ($tag->hasAttribute('class') ? $tag->getAttribute('class') . ' ' : '') . $this->item_active_class);
			}

			return preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $doc->saveHTML() );
		}
		return $html;
	}
}