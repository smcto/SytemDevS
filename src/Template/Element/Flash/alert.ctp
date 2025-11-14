<div class="mt-4 container-alert">
	<div class="<?= @$params['class'] ?> alert-dismissible no-radius m-0 ">
		<?php if (@$params['class'] == 'alert alert-success'): ?>
			<span class="glyphicon mark-alert glyphicon-ok text-success" aria-hidden="true"></span>
		<?php elseif (@$params['class'] == 'alert alert-danger'): ?>
			<span class="glyphicon mark-alert glyphicon-exclamation-sign text-danger" aria-hidden="true"></span>
		<?php endif; ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<span class="to-xs-size "><?= @$message; ?></span>
	</div>
</div>

<style>
	.alert-dismissible .close {
		padding: 1rem 1.25rem;
	}
</style>