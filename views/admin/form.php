<?php echo form_open('','class="form-horizontal tasi-form" id="form-ajax"')?>
            <header class="panel-heading">
                <?php echo lang('almacen:'.$this->method) ?>
            </header>
            <div class="panel-body">
                    <div class="alert alert-info"><?=$almacen->nombre?></div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Cantidad Mostrador</label>
                        <div class="col-md-8">
                            <div id="spinner3">
                                                      <div class="input-group" style="width:150px;">
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
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Cantidad Web</label>
                        <div class="col-md-8">
                            <div id="spinner3">
                                                      <div class="input-group" style="width:150px;">
                                                          <input type="text" value="<?=$this->method=='edit'?$almacen->cantidad_web:0?>" name="cantidad_w" class="spinner-input form-control" maxlength="3" />
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
                    </div>
                    
                   
           
            </div>
            <?php if($this->method=='add'):?>
            <header class="panel-heading">Anterior</header>
            <div class="panel-body">
                 <dl class="dl-horizontal">
                        
                        <dt>Cantidad Mostrador:</dt>
                        <dd><?=$almacen->cantidad_mostrador?$almacen->cantidad_mostrador:0?></dd>
                        <dt>Cantidad Web:</dt>
                        <dd><?=$almacen->cantidad_web?$almacen->cantidad_web:0?></dd>
                        
                       
                       
                    </dl>
                    
            </div>
            <header class="panel-heading">Ahora</header>
            <div class="panel-body">
            
                <dl class="dl-horizontal">
                        <dt>Cantidad Mostrador:</dt>
                        <dd>0</dd>
                        <dt>Cantidad Web:</dt>
                        <dd>0</dd>
                </dl>
                
            </div>
            <?php endif; ?>
            <p class="text-center action-buttons">
                       
                        	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
            </p>
            <br />
<?php echo form_close();?>  