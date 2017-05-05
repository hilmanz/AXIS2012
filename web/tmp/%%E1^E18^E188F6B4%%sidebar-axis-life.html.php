<?php /* Smarty version 2.6.13, created on 2012-11-14 16:12:48
         compiled from application/axisweb/widgets/sidebar-axis-life.html */ ?>
<div id="sidebar">
			<?php if ($this->_tpl_vars['user']): ?> 
			<?php echo $this->_tpl_vars['profile_box']; ?>

			<?php echo $this->_tpl_vars['axis_new']; ?>

			<?php echo $this->_tpl_vars['social_network']; ?>

			<?php else: ?>
				<?php echo $this->_tpl_vars['axis_login']; ?>

				<?php echo $this->_tpl_vars['socialLogin']; ?>

			<?php endif; ?>
			
			
</div><!-- end #sidebar -->