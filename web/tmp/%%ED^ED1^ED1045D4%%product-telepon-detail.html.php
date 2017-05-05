<?php /* Smarty version 2.6.13, created on 2012-11-29 11:49:31
         compiled from application/mobile/product-telepon-detail.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'application/mobile/product-telepon-detail.html', 22, false),)), $this); ?>
<div class="page-body" data-role="content">
		
	<div class="page-image-heading">	
		<?php if ($this->_tpl_vars['product'][0]['image']): ?><img src="<?php echo $this->_tpl_vars['basedomain']; ?>
public_assets/product/small_<?php echo $this->_tpl_vars['product'][0]['image']; ?>
" /><?php endif; ?>
	</div>
	
	<div class="page-meta">
		<h1 class="page-title"><span class="icon"></span><?php echo $this->_tpl_vars['product'][0]['title']; ?>
</h1>
		
		<div class="page-content clear">
			<article>
			<?php if (! $this->_tpl_vars['product'][0]['image']): ?>
				<?php if ($this->_tpl_vars['product'][0]['brief']): ?> <h2><?php echo $this->_tpl_vars['product'][0]['brief']; ?>
</h2><?php endif; ?>
				<?php if ($this->_tpl_vars['product'][0]['content']): ?><div class="white_table"><?php echo $this->_tpl_vars['product'][0]['content']; ?>
</div><?php endif; ?>
			<?php endif; ?>
			<div class="accordion">
				<?php if ($this->_tpl_vars['product'][0]['desc']): ?>
					<?php $_from = $this->_tpl_vars['product'][0]['desc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kdesc'] => $this->_tpl_vars['vdesc']):
?>
					<h3><?php echo $this->_tpl_vars['vdesc']['title']; ?>
</h3>
						<div class="entry">
							<div class="white_table">
								<?php echo ((is_array($_tmp=$this->_tpl_vars['vdesc']['description'])) ? $this->_run_mod_handler('replace', true, $_tmp, '../public_assets/content/uploads/', 'public_assets/content/uploads/') : smarty_modifier_replace($_tmp, '../public_assets/content/uploads/', 'public_assets/content/uploads/')); ?>

							</div>
						</div>
					<?php endforeach; endif; unset($_from); ?>
				<?php endif; ?>
			</div><!-- end .accordion -->
			</article>
		</div>
	</div>
	
	<div class="list-nav">
		<ul data-role="listview" data-inset="true">
			<li>
				<a href="index.php?page=product&act=telepon" data-transition="slide" data-rel="back">
					<span class="icon icon-plus"></span>
					Produk Telepon &amp; SMS Lainnya
				</a>
			</li>
			<li>
				<a href="index.php?page=product" data-transition="slide">
					<span class="icon icon-home"></span>
					Back To Produk
				</a>
			</li>
		</ul>
	</div>
</div><!-- /content -->