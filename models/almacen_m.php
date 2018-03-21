<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Almacen_m extends MY_Model {

	private $folder;
    public $segments;
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'almacen';
		
	}
    
    function add($id=0,$input)
    {
        if($result = $this->db->select('*,productos.id AS id')->join($this->_table,$this->_table.'.id_producto=productos.id','LEFT')
                            ->where('productos.id',$id)->get('productos')
                            ->row())
        {
            
            $data = array(
            
                'id_producto'        => $id,
                'cantidad_mostrador' => $input['cantidad_m'],
                'cantidad_web'       => $input['cantidad_w'],
                
            );
            if($result->id_producto)
            {
                $data['cantidad_mostrador'] = $data['cantidad_mostrador'] + $result->cantidad_mostrador;
                $data['cantidad_web']       = $data['cantidad_web'] + $result->cantidad_web;
                
                
                $this->db->where('id_producto',$id)->set($data)->update($this->_table);
                
            }
            else
            {
                $this->db->set($data)->insert($this->_table);
            }
            
            unset($data['id_producto']);
            
            return $data;
        }
        
        return false;
    }
 }
 ?>