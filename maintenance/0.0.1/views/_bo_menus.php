<?php if(user_can('edit','maintenance')): ?>
<li><a href="<?php echo base_url('maintenance/configure/index'); ?>" class="nav-header" data-toggle="collapse"><i class="fa fa-fw fa-dashboard"></i> Maintenance<i class="fa fa-collapse"></i></a></li>
<?php endif; ?>