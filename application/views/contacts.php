<br />
<div class="container">
	<div class="row">
		<div class="col-xs-6">
			<? $this->load->view('partials/form_add_contact'); ?>
			<? $this->load->view('partials/form_edit_contact'); ?>
			<? $this->load->view('partials/form_delete_contact'); ?>
		</div>
		<div class="col-xs-6">
			<div class="form-group pull-right">
				<input class="js-search search form-control" type='text' placeholder="Search" />	
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<? $this->load->view('partials/contact_list'); ?>	
		</div>
	</div>	
</div>