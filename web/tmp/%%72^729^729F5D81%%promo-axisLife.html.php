<?php /* Smarty version 2.6.13, created on 2012-11-29 15:57:25
         compiled from application/mobile/promo-axisLife.html */ ?>
<div class="page-body" data-role="content">	
	<div class="page-meta">
		<h1 class="page-title">HOT DI AXIS LIFE</h1>
		
		<div class="page-excerpt">
			<p>
				LIHAT PROMO-PROMO SERU TERBARU <br />
				DARI AXIS YANG GAK ABIS-ABIS!
			</p>	
		</div>
	</div>
	
	<div class="page-content" class="clear">
		<div id="product-category-list" class="page-content-list">
			<ul data-role="listview" data-inset="true">
				<?php $_from = $this->_tpl_vars['promo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<li>
						<a href="index.php?page=promo&act=axisLife&id=<?php echo $this->_tpl_vars['v']['id']; ?>
" data-transition="slide">
							<span class="text"><?php echo $this->_tpl_vars['v']['title']; ?>
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
				<a href="index.php?page=promo&act=hot" data-transition="slide">
					<span class="icon icon-smile"></span>
					Hot Promo
				</a>
			</li>
			<li>
				<a href="index.php" data-transition="slide" data-url="index.php">
					<span class="icon icon-home"></span>
					Back To Home
				</a>
			</li>
		</ul>
	</div>
</div><!-- /content -->