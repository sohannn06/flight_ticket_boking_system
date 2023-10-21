<?php for($i = 0; $i < $_GET['count']; $i++ ): ?>
<hr>
<div class="row">
	<div class="col-md-6">
		<label class="control-label">Name</label>
		<input type="text" name="name[]" class="form-control" required>
	</div>
	<div class="col-md-6">
		<label class="control-label">Passport</label>
		<input type="text" name="passport[]" class="form-control" required>
	</div>
	<div class="col-md-6">
		<label class="control-label">Contact Number</label>
		<input type="text" name="contact[]" class="form-control" required>
	</div>
</div>

<div class="row">
<div class="form-group col-md-12">
	<label class="control-label">Address</label>
	<textarea name="address[]" id="" cols="30" rows="2" class="form-control" required></textarea>
</div>
</div>

<?php endfor; ?>