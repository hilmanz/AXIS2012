<?php /* Smarty version 2.6.13, created on 2012-11-14 16:12:48
         compiled from application/axisweb/widgets/axis-login.html */ ?>
			<div id="bannerMedium">
                <div class="bannerMedium">
                    <a href="<?php if ($this->_tpl_vars['user']): ?>index.php?page=axisLife<?php else: ?>index.php?page=login<?php endif; ?>"><img src="assets/content/banner/medium/banner_login.jpg" /></a>
                </div>
                <a class="loginbtn" href="<?php if ($this->_tpl_vars['user']): ?>index.php?page=axisLife<?php else: ?>index.php?page=login<?php endif; ?>"><?php echo $this->_tpl_vars['locale']['btn']['loginyuk']; ?>
</a>
                <div class="shadow"></div>
                <div class="splashBox1"></div>
            </div><!-- end #bannerMedium -->