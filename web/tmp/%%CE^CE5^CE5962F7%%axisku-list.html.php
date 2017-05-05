<?php /* Smarty version 2.6.13, created on 2012-12-03 10:14:22
         compiled from application/mobile/axisku-list.html */ ?>
<div class="breadcrumb">
		<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a>	&raquo; <a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=axisku"><?php echo $this->_tpl_vars['locale']['nav']['axislife']; ?>
</a> &raquo;  <a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=axisku&cid=<?php echo $this->_tpl_vars['cid']; ?>
"><?php echo $this->_tpl_vars['category'][0]['category']; ?>
</a>
</div>
<div class="page-body" data-role="content">
	<div class="page-meta">
		<h1 class="page-title"><span class="icon"></span><?php echo $this->_tpl_vars['category'][0]['category']; ?>
</h1>
		
		<div class="page-excerpt">
			<p>
				Buat kamu yang gila <?php echo $this->_tpl_vars['category'][0]['category']; ?>
, jangan lewatkan <br /> 
				semua review dan info terbaru seputar <br />
				<?php echo $this->_tpl_vars['category'][0]['category']; ?>
-<?php echo $this->_tpl_vars['category'][0]['category']; ?>
 paling seru  di sini. 
			</p>	
		</div>
	</div>
	
	<div class="page-content clear" id="axiskuList">
		<div id="life-film-list" class="page-content-list">
			<ul data-role="listview" data-inset="true">
				<?php $_from = $this->_tpl_vars['listAxis']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<li>
						<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=axisku&act=detail&cid=<?php echo $this->_tpl_vars['cid']; ?>
&id=<?php echo $this->_tpl_vars['v']['id']; ?>
" data-transition="slide" title="<?php echo $this->_tpl_vars['v']['title']; ?>
" data-ajax="false">
							<img src="<?php echo $this->_tpl_vars['basedomain']; ?>
public_assets/article/thumb_<?php echo $this->_tpl_vars['v']['image']; ?>
" title="" class="thumbnail" />
														<span class="text"><?php echo $this->_tpl_vars['v']['title']; ?>
</span>
						</a>
					</li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
		<div class="paging">
			<a class="prev" href="#">&laquo;</a>
			<a href="#">1</a>
			<a href="#">2</a>
			<a href="#">3</a>
			<a href="#" class="current">4</a>
			<a class="next" href="#">&raquo;</a>
		</div><!-- end .paging -->
	</div>
	
	<div class="list-nav">
		<ul data-role="listview" data-inset="true">
			<li>
				<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=axisku" data-transition="slide">
					<span class="icon icon-plus"></span>
					Kategori Lainnya
				</a>
			</li>
			<li>
				<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php" data-transition="slide" data-url="index.php">
					<span class="icon icon-home"></span>
					Back To Home
				</a>
			</li>
		</ul>
	</div>
</div><!-- /content -->