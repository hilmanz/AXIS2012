<?php /* Smarty version 2.6.13, created on 2012-11-15 15:07:37
         compiled from application/axisweb//axisProduct/produk-detail.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'application/axisweb//axisProduct/produk-detail.html', 24, false),)), $this); ?>
<div id="breadcumb" class="wrapper">
	<h1><a href="index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a> &raquo; <a href="index.php?page=produk"><?php echo $this->_tpl_vars['locale']['product']['title']; ?>
</a> &raquo; <a href="index.php?page=produk&act=detail&type=<?php echo $this->_tpl_vars['type']; ?>
"><?php echo $this->_tpl_vars['locale']['product']['type'][$this->_tpl_vars['type']]; ?>
</a>
</div><!-- end #breadcumb -->
<?php echo $this->_tpl_vars['slider_produk']; ?>

<?php if ($this->_tpl_vars['product']): ?>
<div id="produkDetailPage">
	<div class="wrapper">
    	<div class="navTab">
        	<ul>
				<?php $_from = $this->_tpl_vars['product']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<li><a href="#tab<?php echo $this->_tpl_vars['v']['id']; ?>
" ><?php echo $this->_tpl_vars['v']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>
    </div>
    <div class="productPage">
    	<div class="wrapper" id="produkDetail">
        	<div class="tabContainer">
			<?php $_from = $this->_tpl_vars['product']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                <div class="tabContent" id="tab<?php echo $this->_tpl_vars['v']['id']; ?>
">
              
                        <?php if ($this->_tpl_vars['v']['image']): ?><img src="public_assets/product/<?php echo $this->_tpl_vars['v']['image']; ?>
" /><?php endif; ?>
                        <?php if ($this->_tpl_vars['v']['brief']): ?> <h2><?php echo $this->_tpl_vars['v']['brief']; ?>
</h2><?php endif; ?>
                        <?php if ($this->_tpl_vars['v']['content']): ?>	<div class="white_table"><?php echo ((is_array($_tmp=$this->_tpl_vars['v']['content'])) ? $this->_run_mod_handler('replace', true, $_tmp, '/public_assets/content/uploads/', '/public_html/public_assets/content/uploads/') : smarty_modifier_replace($_tmp, '/public_assets/content/uploads/', '/public_html/public_assets/content/uploads/')); ?>
</div><?php endif; ?>
                
                    <div class="accordion">
						<?php if ($this->_tpl_vars['v']['desc']): ?>
							<?php $_from = $this->_tpl_vars['v']['desc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kdesc'] => $this->_tpl_vars['vdesc']):
?>
							<h3><?php echo $this->_tpl_vars['vdesc']['title']; ?>
</h3>
								<div class="entry">
									<div class="white_table">										<?php echo ((is_array($_tmp=$this->_tpl_vars['vdesc']['description'])) ? $this->_run_mod_handler('replace', true, $_tmp, '../public_assets/content/uploads/', 'public_assets/content/uploads/') : smarty_modifier_replace($_tmp, '../public_assets/content/uploads/', 'public_assets/content/uploads/')); ?>

									</div>
								</div>
							<?php endforeach; endif; unset($_from); ?>
                        <?php endif; ?>
                    </div><!-- end .accordion -->
					
                </div><!-- end .tabContent -->
             <?php endforeach; endif; unset($_from); ?>  
            </div><!-- end .tabContainer -->
		</div><!-- end #produkDetail -->
    </div><!-- end .productPage -->
</div><!-- end #produkDetailPage -->
<?php endif; ?>
<div class="widget-product">
<?php echo $this->_tpl_vars['carousel_banner']; ?>

</div><!-- end .widget-whyAxis -->