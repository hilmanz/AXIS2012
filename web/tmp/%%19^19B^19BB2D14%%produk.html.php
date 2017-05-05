<?php /* Smarty version 2.6.13, created on 2012-11-15 16:50:18
         compiled from application/axisweb//axisProduct/produk.html */ ?>
<div id="breadcumb" class="wrapper">
	<h1><a href="index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a> &raquo; <a href="index.php?page=produk"><?php echo $this->_tpl_vars['locale']['product']['title']; ?>
</a>
</div><!-- end #breadcumb -->
<?php echo $this->_tpl_vars['slider_produk']; ?>

<div id="productPage">
    <div class="productPage">
    	<div class="wrapper" id="produk">
            <div class="produkbox produk1">
            	<a href="index.php?page=produk&act=detail" class="icon_globe">&nbsp;</a>
                <div class="entry">
                	<?php echo $this->_tpl_vars['locale']['product']['internet']; ?>

                </div><!-- end .entry -->
           		<a class="detail" href="index.php?page=produk&act=detail&type=internet"><?php echo $this->_tpl_vars['locale']['btn']['detail']; ?>
</a>
            </div><!-- end .produk -->
            <div class="produkbox produk2">
            	<a href="index.php?page=produk&act=detail" class="icon_iphone">&nbsp;</a>
                <div class="entry">
					<?php echo $this->_tpl_vars['locale']['product']['telepon']; ?>
                	
                </div><!-- end .entry -->
           		<a class="detail" href="index.php?page=produk&act=detail&type=telepon"><?php echo $this->_tpl_vars['locale']['btn']['detail']; ?>
</a>
            </div><!-- end .produk -->
            <div class="produkbox produk3">
            	<a href="index.php?page=produk&act=detail" class="icon_bundle">&nbsp;</a>
                <div class="entry">
					<?php echo $this->_tpl_vars['locale']['product']['bundling']; ?>
                	
                </div><!-- end .entry -->
           		<a class="detail" href="index.php?page=produk&act=detail&type=bundling"><?php echo $this->_tpl_vars['locale']['btn']['detail']; ?>
</a>
            </div><!-- end .produk -->
            <div class="produkbox produk4">
            	<a href="index.php?page=produk&act=detail" class="icon_simcard">&nbsp;</a>
                <div class="entry">
					<?php echo $this->_tpl_vars['locale']['product']['kartuaxis']; ?>
                	
                </div><!-- end .entry -->
           		<a class="detail" href="index.php?page=produk&act=detail&type=kartu"><?php echo $this->_tpl_vars['locale']['btn']['detail']; ?>
</a>
            </div><!-- end .produk -->
		</div><!-- end #produk -->
    </div><!-- end .productPage -->
</div><!-- end #productPage -->
<div class="widget-product">
<?php echo $this->_tpl_vars['carousel_banner']; ?>

</div><!-- end .widget-whyAxis -->