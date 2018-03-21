<div class="row" ng-controller="IndexCtrl">
    
    <div class="col-lg-12" id="box-left">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="header-title"><?php echo lang('productos:list') ?></h4>
            </header>
            
            <div class="panel-body">
            
                <!--div class="row">
                    <div class="col-md-6">
                        <form role="form" class="form-inline">
                                          <div class="form-group">
                                              <label for="exampleInputEmail2" class="sr-only">Email address</label>
                                              <input type="email" placeholder="Enter email" id="exampleInputEmail2"  class="form-control typeahead"/>
                                          </div>
                                          
                                          <button class="btn btn-success" type="submit">Sign in</button>
                        </form>
                    </div>
                </div>
                <hr /-->
                <a href="#" ng-click="open_add()">Open modal</a>
                <div class="adv-table">
                    <table  cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="hidden-table-info">
            				<thead>
            					<tr>
            						
            						<th>Descripción</th>
                                    <th class="hide">Marca</th>
                                    <th class="hide">Modelo</th>
                                    <th width="18%" title="Cantidad mostrador">Mostrador </th>
                                    <th width="18%" title="Cantidad web">Web </th>
                                    <th width="12%"></th>
            						
            					</tr>
            				</thead>
            				<!--tfoot>
            					<tr>
            						<td colspan="3">
            							<div class="inner"><?php // $this->load->view('admin/partials/pagination') ?></div>
            						</td>
            					</tr>
            				</tfoot-->
            				<tbody>
            				<?php foreach ($almacen as $row):?>
            					<tr class="gradeA">
            						<td><?php echo $row->nombre_producto; ?></td>
                                    <td class="hide"><?php echo $row->nombre_marca;?></td>
                                    <td class="hide"><?php echo $row->nombre_modelo;?></td>
            						<td class="cantidad_m"><?php echo $row->cantidad_mostrador; ?></td>
                                    <td class="cantidad_w"><?php echo $row->cantidad_web; ?></td>
                                    <td class="center">
                                        <a href="<?=base_url('admin/almacen/edit/'.$row->id)?>"  title="Modificar cantidad actual" class="btn btn-primary btn-xs btn-edit"><i class="fa fa-pencil"></i></a>
                                        <a href="<?=base_url('admin/almacen/add/'.$row->id)?>"  title="Agregar nueva cantidad a la actual" class="btn btn-success btn-xs btn-edit"><i class="fa fa-plus"></i></a>
                                        
                                    </td>
            					 	
            					</tr>
            				<?php endforeach;?>
            				</tbody>
            			</table>
               </div>
            </div>
        </section>
    </div>
    
    <div class="col-lg-4 hide fadeIn" id="box-right">
        
        <div id="notices-almacen"></div>
        <section class="panel" id="box-form">
              
        </section>
    </div>
</div>
<script type="text/ng-template" id="modalAdd.html">
    <div class="modal-header">
    <h4 class="header-title"><?php echo lang('files:details') ?> Titulo</h4>
    </div>
    <div class="modal-body">
          <div class="form-group">
            <label>Código del producto</label>
            <input type="text" class="form-control"/>
          </div>
          
          <div class="form-group">
            <label>Nombre del producto</label>
            <input type="text" class="form-control"/>
          </div> 
          <div class="form-group">
                        <label class="control-label">Cantidad</label>
                        
                            
                        <div class="input-group" >
                                                          <input type="text" value="<?=$this->method=='edit'?$almacen->cantidad_mostrador:0?>" name="cantidad_m" class="spinner-input form-control" maxlength="3"  />
                                                          <div class="spinner-buttons input-group-btn">
                                                              
                                                              <button type="button" class="btn btn-default spinner-down">
                                                                  <i class="fa fa-angle-down"></i>
                                                              </button>
                                                              <button type="button" class="btn btn-default spinner-up">
                                                                  <i class="fa fa-angle-up"></i>
                                                              </button>
                                                          </div>
                        </div>
                            
                        
          </div>                       
    </div>
    <div class="modal-footer">
                                <button ui-wave class="btn btn-flat" ng-click="cancel()">Cancelar</button>
                                <button ui-wave class="btn btn-flat btn-primary"  ng-click="save()">Guardar</button>
                                <button ui-wave class="btn btn-flat btn-primary"  ng-click="save(true)">Guardar y cerrar</button>
    </div>
</script>