<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Groups module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Groups
 */
 class Module_Almacen extends Module
{

	public $version = '1.0';

	public function info()
	{
		$info= array(
			'name' => array(
				'en' => 'NS',
				
				'es' => 'Almacen',
				
			),
			'description' => array(
				'en' => 'Classifies product categories organizing it for items',
				
				'es' => 'Administra el activo y almacen de tu tienda',
				
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'tienda',
            //'name'=>'marcas:title',
            'uri' => 'admin/almacen',
			'shortcuts' => array(
        			array(
        					'name' => 'almacen:add',
        					'uri' => 'admin/almacen/add',
        					'class' => 'btn btn-primary',
                            'open-modal' => '1',
                            'modal-title' => lang('almacen:add')
       				),	
			)
            
		);
        
        
        
        
        return $info;
	}

	public function install()
	{
	    $this->dbforge->drop_table('almacen');

		$tables = array(
		    'almacen'=>array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
                //'id_categoria' => array('type' => 'INT', 'constraint' => 11,'null'=>true),
                //'id_marca' => array('type' => 'INT', 'constraint' => 11,'null'=>true),
                //'id_modelo' => array('type' => 'INT', 'constraint' => 11,'null'=>true),
				//'descripcion' => array('type' => 'VARCHAR', 'constraint' => 254,),
                
                //'precio_costo' => array('type' => 'DECIMAL', 'constraint' => array(10,2),'null'=>true),
                //'precio_venta' => array('type' => 'DECIMAL', 'constraint' => array(10,2),'null'=>true),
                
                'id_producto' => array('type' => 'INT', 'constraint' => 11,'null'=>true),
                'cantidad_mostrador' => array('type' => 'INT', 'constraint' => 11,'null'=>true),
                'cantidad_web' => array('type' => 'INT', 'constraint' => 11,'null'=>true),
				
            )
			
		);

        if ( ! $this->install_tables($tables))
		{
			return false;
		}

        return true;
        
		

		
	}

	public function uninstall()
	{
	  
        $this->dbforge->drop_table('almacen');
		return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}

}
?>