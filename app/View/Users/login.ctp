<!--login modal-->
<div class="row">
<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
      	<?php echo $this->Html->image('logo.jpg', array('alt' => 'www.camas.cl', 'width'=>'120')); ?>
          <h3 class="text-center">  Login de usuario</h3>
      </div>
      <div class="modal-body">
      	<?php echo $this->Session->flash(); ?>
          <?php echo $this->Form->create('users'); ?>
            <div class="form-group">
            	<?php echo $this->Form->input('usuario', array("class"=>"form-control", "placeholder"=>"Usuario", "label"=>false, 'required'));?>
            </div>
            <div class="form-group">
            	<?php echo $this->Form->input('clave', array("type"=>"password", "class"=>"form-control", "placeholder"=>"Clave", "label"=>false, 'required'));?>
            </div>
            <div class="form-group">
              <button class="btn btn-primary  btn-block" >Ingresar</button><br/>
            </div>
          </form>
      </div>
</div>
</div>
<br/>
<br/>
<br/>
