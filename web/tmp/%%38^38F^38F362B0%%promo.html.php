<?php /* Smarty version 2.6.13, created on 2012-11-14 16:12:55
         compiled from application/axisweb//axisProduct/promo.html */ ?>

<div id="breadcumb" class="wrapper">
	<h1><a href="index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a> &raquo; <a href="index.php?page=promo"><?php echo $this->_tpl_vars['locale']['promo']['title']; ?>
</a></h1>
</div><!-- end #breadcumb -->
<?php echo $this->_tpl_vars['slider_default']; ?>

<div id="container">
    <div class="wrapper" id="lagiIn">
    	<div id="sidebar">
		<?php echo $this->_tpl_vars['medium_banner']; ?>

               </div><!-- end #sidebar -->
        <div id="contents">
        	<div class="theTitle">
            	<h1 class="icon_horn2"><?php echo $this->_tpl_vars['locale']['promo']['hot']; ?>
</h1>
            </div>
            <div class="shadowCtop">
				<?php if ($this->_tpl_vars['promo']): ?>
                <div id="hotPromo" class="shadowCbottom">
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['promo']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                    <div class="boxPromo">
                        <div class="bannerThumb">
                            <a href="index.php?page=promo&act=detail&id=<?php echo $this->_tpl_vars['promo'][$this->_sections['i']['index']]['id']; ?>
"><img src="public_assets/banner/<?php echo $this->_tpl_vars['promo'][$this->_sections['i']['index']]['image']; ?>
"/></a>
                        </div><!-- end .bannerThumb -->
                        <div class="pitaPromo"></div>
                        <div class="shadow"></div>
                        <a class="detail" href="index.php?page=promo&act=detail&id=<?php echo $this->_tpl_vars['promo'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['locale']['btn']['detail']; ?>
</a>
                    </div><!-- end .boxPromo -->
                   <?php endfor; endif; ?>
                </div><!-- end #hotPromo -->
				<?php endif; ?>
            </div>
            <div id="promoPaging" class="paging">
                
            </div><!-- end .paging -->
        </div><!-- end #contents -->
    </div><!-- end #lagiIn -->
</div><!-- end #container -->
<script>
	var total_rows = <?php echo $this->_tpl_vars['promo'][0]['total_rows']; ?>
;
<?php echo '
	$(document).ready(function(){
		var pageInit = 0;
		var start = 0;
		//Init Page
		if(pageInit == 0){
			pageInit = 1;
			if(start == 0)start=1;
			kiPagination(total_rows, start, \'promoPaging\', \'promo_ajax\', \'promo_ajax\', 4);
		}
	});
	
	
	function promo_ajax(fungsi, start){
		$.post(\'index.php?page=promo&act=\'+fungsi, {start : start}, function(data){
			var str=\'\';
			$.each(data, function(k,v){
				str+=\'<div class="boxPromo">\';
					str+=\'<div class="bannerThumb">\';
						str+=\'<a href="index.php?page=promo&amp;act=detail&amp;id=\'+v.id+\'"><img src="public_assets/banner/\'+v.image+\'"></a>\';
					str+=\'</div>\';
					str+=\'<div class="pitaPromo"></div>\';
					str+=\'<div class="shadow"></div>\';
					str+=\'<a href="index.php?page=promo&amp;act=detail&amp;id=\'+v.id+\'" class="detail">DETAIL</a>\';
				str+=\'</div>\';
			});
			$(\'#hotPromo\').html(str);
		},"json");
	}
'; ?>

</script>