<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Roles controller for the groups module
 *
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Groups\Controllers
 *
 */
class Admin extends Admin_Controller
{

	/**
	 * Constructor method
	 */
 	protected $section='almacen';
	public function __construct()
	{
		parent::__construct();

		

		$this->load->model(array('almacen_m'));

		$this->lang->load('almacen');
        //$this->template->set_breadcrumb('Categorías','categorias');
		//$this->lang->load('permissions/permissions');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'cantidad_m',
				'label' => 'Cantidad mostrador',
				'rules' => 'trim|numeric'
			),
            array(
				'field' => 'cantidad_w',
				'label' => 'Cantidad web',
				'rules' => 'trim|numeric'
			),
            
             array(
				'field' => 'nombre',
				'label' => 'Nombre',
				'rules' => 'trim'
			),
			
		);
	}

	/**
	 * Create a new group role
	 */
	public function index()
	{
	   
        $almacen = $this->almacen_m->select('*,productos.nombre AS nombre_producto,cat_marcas.nombre AS nombre_marca,cat_modelos.nombre AS nombre_modelo,productos.id AS id')
                
                ->join('productos','productos.id=almacen.id_producto','RIGHT')
                ->join('cat_marcas','cat_marcas.id=productos.id_marca')
                ->join('cat_modelos','cat_modelos.id=productos.id_modelo')
                ->get_all();
                
        //print_r($almacen);
		$this->template->enable_parser(true)
          	->title($this->module_details['name'])
            //->append_css('advanced-datatable/media/css/demo_table.css')
            //->append_css('data-tables/DT_bootstrap.css')
            //->append_js('advanced-datatable/media/js/jquery.dataTables.js')
            //->append_js('data-tables/DT_bootstrap.js')
            //->append_js('bloodhound.js')
            //->append_js('bootstrap-typeahead.js')
            ->append_metadata('<script type="text/javascript">var productos ='.json_encode($almacen).';</script>')
            ->append_js('module::almacen.controller.js')
            ->set('almacen',$almacen)
			//->set('categorias', $categorias)
			->build('admin/index');
	}
    function load($parent=0)
    {
        $base_where = array(); 
        $categorias = $this->categoria_m->where(array('parent_id'=>$parent,'user_id'=>$this->current_user->id))->get_all();

        $breadcrumbs = $this->categoria_m->get_segments($parent);
        
        
        foreach($breadcrumbs as  $bread)
        {
             $this->template->set_breadcrumb($bread->nombre,'categorias/'.$bread->id);
        }
       
		$this->template->append_metadata($this->load->view('partials/meta_admin',array('categorias'=>$categorias),true))
		      ->enable_parser(true)
          	->title($this->module_details['name'])
           
            //->append_css('fuelux/css/tree-style.css')
            //->append_js('fuelux/js/tree.min.js')
            //->append_js('module::admin/index.js')
            ->set('parent',$parent)
			->set('categorias', $categorias)
			->build('admin/index');
    }

	/**
	 * Create a new group role
	 */
     
    function create($id=0)
    {
        $categoria = new StdClass();
        
        $breadcrumbs = $this->categoria_m->get_segments($id);
        $url_return = 'admin/categorias';
        
        foreach($breadcrumbs as  $bread)
        {
             $this->template->set_breadcrumb($bread->nombre,'categorias/'.$bread->id);
        }
        
        $this->form_validation->set_rules($this->validation_rules);
        
        if($this->form_validation->run())
		{
			unset($_POST['btnAction']);
            
            
           
            $data = array(
                'user_id' => $this->current_user->id,
                'nombre'  => $this->input->post('nombre'),
                'parent_id' => $id
            );
            
            if($this->categoria_m->insert($data))
            {
				
				$this->session->set_flashdata('success',sprintf(lang('categoria:save_success'),$this->input->post('nombre')));
				
			}
            else
            {
				$this->session->set_flashdata('error',lang('global:save_error'));
				
			}
            
            $id AND $url_return.= '/'.$id;
            
			redirect($url_return);
        }
         
       	foreach ($this->validation_rules as $rule)
		{
			$categoria->{$rule['field']} = $this->input->post($rule['field']);
		}
        
        $clasificacion = array_for_select($this->clasificacion_m->get_all(),'id','nombre');
        
        
        
        
        $this->template
			->title($this->module_details['name'], lang('categorias:create'))
            ->set_breadcrumb('Agregar categoria','')
            ->set('parent',$id)
			->set('categoria', $categoria)
            ->set('clasificacion',$clasificacion)
			->build('admin/form');
    }


	/**
	 * Edit a group role
	 *
	 * @param int $id The id of the group.
	 */
    function add($id=0)
    {
        
        if(is_numeric($id) && $id != 0)
        {
            $almacen = $result = $this->db->select('*,productos.id AS id')
                            ->join('almacen','almacen.id_producto=productos.id','LEFT')
                            ->where('productos.id',$id)->get('productos')
                            ->row();
        }
        else
        {
            $almacen = new StdClass();
        }
        
        $this->form_validation->set_rules($this->validation_rules);
        
        if($this->form_validation->run())
		{
			unset($_POST['btnAction']);
            
            $result = array();
            
            if($result['data'] = $this->almacen_m->add($id,$this->input->post()))
            {
                $result['status'] = 'success';
                $message = sprintf(lang('almacen:add_success'),$almacen->descripcion);
            }
            else
            {
                $result['status'] = 'error';
                
                $message = 'Error';
                
            } 
            
           	$result['status'] === 'success' AND $data['messages'][$result['status']] = $message;
			$result['message'] = $this->load->view('admin/partials/notices', $data, true);
            
            
            return $this->template->build_json($result);
        }
        if($_POST)
        {
            
        }
        else
        {
            foreach ($this->validation_rules as $rule)
    		{
    			$almacen->{$rule['field']} = $this->input->post($rule['field']);
    		}
        }
        
        $this->template->set_layout(false)
            ->enable_parser(false)
			->title($this->module_details['name'], lang('almacen:add'))
            ->set('almacen',$almacen)
			->build('admin/form');
    }
	public function edit($id = 0)
	{
	   
        $almacen = $result = $this->db->select('*,productos.id AS id')->join('almacen','almacen.id_producto=productos.id')
                            ->where('productos.id',$id)->get('productos')
                            ->row();
                            
        $this->form_validation->set_rules($this->validation_rules);
        
        if($this->form_validation->run())
		{
			unset($_POST['btnAction']);
            $input = $this->input->post(); 
            $data  = array(
                'id_producto'        => $id,
                'cantidad_mostrador' => $input['cantidad_m'],
                'cantidad_web'       => $input['cantidad_w'],
            );
            
            if($this->db->where('id_producto',$almacen->id_producto)->set($data)->update('almacen'))
            {
           	    $status		= 'success';
				$message	= sprintf(lang('almacen:edit_success'),$almacen->descripcion);
            }
            else
            {
           	    $status		= 'error';
				$message	= lang('global:save_error');
            }
            
            $result = array();

            $status === 'success' AND $result['messages'][$status] = $message;
            $message = $this->load->view('admin/partials/notices', $result, true);

            return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
					'data'   	=> $data,
            ));
        }
        
        
		/*role_or_die($this->section, 'edit');
        $categoria = $this->categoria_m->get($id);
        
        
        
        $this->form_validation->set_rules($this->validation_rules);
		
				
		if($this->form_validation->run())
		{
			unset($_POST['btnAction']);
            $input = array(
                'nombre' => $this->input->post('nombre')
            );
            if($this->categoria_m->update($id,$input))
            {
				
				$this->session->set_flashdata('success',sprintf(lang('categorias:save_success'),$this->input->post('nombre')));
				
			}
            else
            {
				$this->session->set_flashdata('error',lang('global:save_error'));
				
			}
			redirect('admin/categorias');
        }
        elseif($_POST)
        {
            $categoria = (Object)$_POST;
        }*/
        
        
        
        $this->template->set_layout(false)
                ->title($this->module_details['name'])
			//->set('categoria',$categoria)
            ->set('almacen',$almacen)
			->build('admin/form');
	}

	/**
	 * Delete group role(s)
	 *
	 * @param int $id The id of the group.
	 */
	public function delete($id = 0)
	{
	    $subcategorias = $this->db->where('parent_id',$id)->get('cat_categorias')->result();
        
		if ($success = $this->categoria_m->delete($id))
		{
			// Fire an event. A group has been deleted.
			//Events::trigger('group_deleted', $id);
            if($subcategorias)
            {
                foreach($subcategorias as $categoria)
                {
                    $this->db->where('id',$categoria->id)->set(array('parent_id'=>0))->update('default_cat_categorias');
                }
            }
            
            
			$this->session->set_flashdata('success', lang('categorias:delete_success'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('categorias:delete_error'));
		}

		redirect('admin/categorias');
	}
}
?>