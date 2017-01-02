<?php if(user_can('edit','maintenance')): ?>
<li><a href="<?php echo base_url('maintenance/configure/index'); ?>" class="nav-header"><i class="fa fa-fw fa-dashboard"></i> Maintenance</a></li>
<?php endif; ?>