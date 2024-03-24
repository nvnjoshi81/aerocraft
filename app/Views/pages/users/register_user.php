<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Create User</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/users') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('Main/register_user/') ?>" method="POST"  enctype="multipart/form-data">
                <?php if($session->getFlashdata('error')): ?>
                    <div class="alert alert-danger rounded-0">
                        <?= $session->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <?php if($session->getFlashdata('success')): ?>
                    <div class="alert alert-success rounded-0">
                        <?= $session->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="name" class="control-label">First Name</label>
                    <div class="input-group rounded-0">
                        <input type="text" class="form-control rounded-0" id="name" name="name" autofocus placeholder="John" value="<?= !empty($user['name']) ? $user['name'] : '' ?>" required="required">
                        <div class="input-group-text bg-light bg-gradient rounded-0"><i class="fa fa-user"></i></div>
                    </div>
                </div>
				<div class="mb-3">
                    <label for="last_name" class="control-label">Last Name</label>
                    <div class="input-group rounded-0">
                        <input type="text" class="form-control rounded-0" id="last_name" name="last_name" autofocus placeholder="Smith" value="<?= !empty($user['last_name']) ? $user['last_name'] : '' ?>" required="required">
                        <div class="input-group-text bg-light bg-gradient rounded-0"><i class="fa fa-user"></i></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="control-label">Email</label>
                    <div class="input-group rounded-0">
                        <input type="email" class="form-control rounded-0" id="email" name="email" placeholder="jsmith@mail.com" value="<?= !empty($user['email']) ? $user['email'] : '' ?>" required="required">
                        <div class="input-group-text bg-light bg-gradient rounded-0"><i class="fa fa-at"></i></div>
                    </div>
                </div>
				<div class="mb-3">
                    <label for="country_code" class="control-label">Country Code</label>
                    <div class="input-group rounded-0">
                        <select name="country_code" id="country_code" class="form-select rounded-0" required="required">
						<?php foreach($country_array as $key=>$value){ 
						?>
							<option value="<?php echo $key; ?>" <?= isset($user['country_code']) && $user['country_code'] == $key ? 'selected' : '' ?>>+ <?php echo $key .' (' .$value. ')'; ?></option>
						<?php
						}
						?>
                        </select>
                    </div>
                </div>
				
				<div class="mb-3">
                    <label for="mobile" class="control-label">Mobile</label>
                    <div class="input-group rounded-0">
                        <input type="text" class="form-control rounded-0" id="mobile" name="mobile" autofocus placeholder="" value="<?= !empty($user['mobile']) ? $user['mobile'] : '' ?>" required="required" pattern="[0-9]+" title="number only">
                        <div class="input-group-text bg-light bg-gradient rounded-0"><i class="fa fa-mobile"></i></div>
                    </div>
                </div>
				<div class="mb-3">
                    <label for="address" class="control-label">Address</label>
                    <div class="input-group rounded-0">
						<textarea  class="form-control rounded-0" id="address" name="address" ><?= !empty($user['address']) ? $user['address'] : '' ?></textarea>
                        <div class="input-group-text bg-light bg-gradient rounded-0"><i class="fa fa-align-center"></i></div>
                    </div>
                </div>
				
				<div class="container">
				
				<div class="row">
				 <div class="mb-3 col-6">
                    <label for="gender" class="control-label">Gander</label>
				<div class="form-check">
				<?php 
				if(isset($user['gender'])&&$user['gender']=='Male'){
					$checked_m = 'checked';
					$checked_f = '';
					
				}else{
					$checked_m = '';
					$checked_f = 'checked';
					
				}
				?>
				  <input class="form-check-input" type="radio" name="gender" id="gender_m" value="Male" <?php echo $checked_m; ?>>
				  <label class="form-check-label" for="gender_m">
					Mail
				  </label>
				</div>
				<div class="form-check">
				  <input class="form-check-input" type="radio" name="gender" id="gender_f" value="Female" <?php echo $checked_f; ?>>
				  <label class="form-check-label" for="gender_f">
					Female
				  </label>
				</div>
                </div>
               <div class="mb-3 col-6">
                <label for="hobby" class="control-label">Hobby</label>
					 
				<?php
				$hobby_checkboxes = $hobby_array;
				if(isset($user['hobby']) && count($user['hobby'])>0){
					$dbHobby = $user['hobby'];
				}else{
					$dbHobby = array();					
				}
				foreach ($hobby_checkboxes as $checkbox): ?>
					<div class="form-check">
					  <input type="checkbox" class="form-check-input" value="<?= $checkbox['id'] ?>" name="hobby[<?= $checkbox['id'] ?>]" <?php if(in_array($checkbox['id'], $dbHobby)){ echo 'checked'; }else{ echo ''; } ?>><?= $checkbox['label'] ?>
					</div>
				<?php 
				endforeach;
				?>
                </div>
				 </div>
				
				<div class="row">
				 <div class="mb-3 col-6">
                    <label for="image" class="control-label">User Photo</label>
                    <div class="input-group rounded-0">
					<input type="file" name="image" size="20">
					<input type="hidden" name="type" value="1">
					<input type="hidden" name="status" value="1">
                    </div>
                </div>
				<div class="mb-3 col-6">
				<?php 
				$imagename = 'avatar.jpg';
				?>
                    <img width="100px" height="100px" src="<?php echo base_url() . '/writable/uploads/'.$imagename; ?>" alt="User Image">					
               </div>
				</div>
				
                <div class="d-grid gap-1">
                    <button class="btn rounded-0 btn-primary bg-gradient">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>