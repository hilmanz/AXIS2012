<?php /* Smarty version 2.6.13, created on 2012-11-30 18:20:40
         compiled from application/mobile/axisku.html */ ?>
<div class="breadcrumb">
		<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a>	&raquo; <a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=axisku"><?php echo $this->_tpl_vars['locale']['nav']['axislife']; ?>
</a>	
	</div>
<div class="page-body" data-role="content">
	<div class="promo">
		<div class="page-image-heading">
			<img src="assets/images/axisku.jpg" />
		</div>
	</div>
		<div class="page-content clear">
			<div id="product-category-list" class="page-content-list">
				<ul data-role="listview" data-inset="true">
					<?php $_from = $this->_tpl_vars['category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
						<li>
							<a href="index.php?page=axisku&cid=<?php echo $this->_tpl_vars['v']['id']; ?>
" data-transition="slide">
								<span class="text"><?php echo $this->_tpl_vars['v']['category']; ?>
</span>
							</a>
						</li>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
			</div>
		</div>
		
		<div class="list-nav">
			<ul data-role="listview" data-inset="true">
				<li>
					<a href="index.php" data-transition="slide">
						<span class="icon icon-home"></span>
						Back To Home
					</a>
				</li>
			</ul>
		</div>
	</div><!-- /content -->