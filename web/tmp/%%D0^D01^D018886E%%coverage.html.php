<?php /* Smarty version 2.6.13, created on 2012-11-14 16:13:13
         compiled from application/axisweb//axisProduct/coverage.html */ ?>
<div id="breadcumb" class="wrapper">
	<h1><a href="index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a> &raquo; <a href="index.php?menu=Coverage"><?php echo $this->_tpl_vars['locale']['coverage']['title']; ?>
</a></h1>
</div><!-- end #breadcumb -->
<div id="headBanner" class="mapContainer">
    <div class="boxMap">
    	 <div class="title">
         	<h1 class="labelAxis"><?php echo $this->_tpl_vars['locale']['coverage']['makindekat']; ?>
</h1>
         </div>
         <div class="theMap">
		 <iframe width="1030" height="345" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Axis+Center,+Jakarta+Selatan,+Indonesia&amp;aq=0&amp;oq=axis&amp;sll=-6.211544,106.845172&amp;sspn=0.511959,0.96199&amp;ie=UTF8&amp;hq=Axis+Center,&amp;hnear=Jakarta+Selatan,+Jakarta+Capital+Region,+Indonesia&amp;ll=-6.353366,106.898008&amp;spn=0.516857,0.228241&amp;t=m&amp;output=embed"></iframe>
		 </div>
         <div class="shadow"></div>
    </div><!-- end .headBanner -->
</div><!-- end #headBanner -->
<div id="container">
    <div class="wrapper" id="lagiIn">
    	<div id="sidebar">
        	<div id="pilihWilayah" class="formBox">
            	<div class="headBox">
                	<h1 class="icon_wilayah"><?php echo $this->_tpl_vars['locale']['coverage']['wilayah']; ?>
</h1>
                </div><!-- end .headBox -->
                <div class="entryBox">
                    <form class="pilihWilayah">
                    	<div class="rowBtns">
                    	<select class="styled"/>
                        	<option>Bali</option>
                        	<option>DKI Jakarta</option>
                        	<option>Surabaya</option>
                        </select>
                        </div>
                        <div class="rowBtns">
                    	<select class="styled"/>
                        	<option>Denpasar</option>
                        	<option>Jakarta Selatan</option>
                        </select>
                        </div>
                 	   <h3><?php echo $this->_tpl_vars['locale']['coverage']['wow']; ?>
</h3>
                       <div class="chekedRow">
                       		<input type="checkbox"  class="styled" checked="checked"/>
                            <label><?php echo $this->_tpl_vars['locale']['coverage']['2g']; ?>
</label>
							<label><?php echo $this->_tpl_vars['locale']['coverage']['no2g']; ?>
</label>
                       </div>
                       <div class="chekedRow checkPurple">
                       		<input type="checkbox" class="styled"/>
                            <label><?php echo $this->_tpl_vars['locale']['coverage']['3g']; ?>
</label>
							 <label><?php echo $this->_tpl_vars['locale']['coverage']['no3g']; ?>
</label>
                       </div>
                    </form>
                </div><!-- end .entryBox -->
                <div class="shadow"></div>
            </div><!-- end #pilihWilayah -->
            <div class="textBox">
            	<?php echo $this->_tpl_vars['locale']['coverage']['operator']; ?>

            </div><!-- end .textBox -->
        </div><!-- end #sidebar -->
        <div id="contents">
        	<div class="theTitle">
            	<h1 class="icon_house"><?php echo $this->_tpl_vars['locale']['coverage']['lokasi']; ?>
</h1>
            </div><!-- end .theTitle -->
            <div class="shadowCtop">
                <div id="location" class="shadowCbottom">
				<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['coverage']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                	<div class="row">
                    	<div class="circles circle1">
                        	<a href="#popupMap" class="showPopup imgdetail"><img src="<?php if ($this->_tpl_vars['coverage'][$this->_sections['i']['index']]['image']): ?>public_assets/coverage/<?php echo $this->_tpl_vars['coverage'][$this->_sections['i']['index']]['image'];  else: ?>assets/content/map/map.jpg<?php endif; ?>" /></a>
                        </div><!-- end .circles -->
                        <div class="entry">
                        	<h1><?php echo $this->_tpl_vars['coverage'][$this->_sections['i']['index']]['title']; ?>
</h1>
                            <p><?php echo $this->_tpl_vars['coverage'][$this->_sections['i']['index']]['brief']; ?>
</p>
                            <a class="detail showPopup" href="#popupMap" mapsid="<?php echo $this->_tpl_vars['coverage'][$this->_sections['i']['index']]['id']; ?>
" ><?php echo $this->_tpl_vars['locale']['btn']['detail']; ?>
</a>
                        </div><!-- end .entry -->
                    </div><!-- end .row -->
                <?php endfor; endif; ?>	
                </div><!-- end #location -->
            </div><!-- end .shadowCtop -->
            <div id="coveragePaging" class="paging">
                
            </div><!-- end .paging -->
        </div><!-- end #contents -->
    </div><!-- end #lagiIn -->
</div><!-- end #container -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "application/axisweb/widgets/popup_map.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script>
	var total_rows = <?php if ($this->_tpl_vars['coverage'][0]['total_rows']):  echo $this->_tpl_vars['coverage'][0]['total_rows'];  else: ?>0<?php endif; ?>;
	var locale = "<?php if ($this->_tpl_vars['locale']['btn']['detail']):  echo $this->_tpl_vars['locale']['btn']['detail'];  else: ?>0<?php endif; ?>";
<?php echo '	
	$(document).on(\'click\',\'.detail, .imgdetail\', function(){
		var id = $(this).attr("mapsid");
		$.post("index.php?page=coverage&act=detail",{id:id},function(data){
			if(data){
				$(".mapLocation").html(data.content);
				$(".addressname").html(data.title);
				$(".placename").html(data.brief);
			}else	return false;
			return true;
		});
		
	});
	
	$(document).ready(function(){
		var pageInit = 0;
		var start = 0;
		//Init Page
		if(pageInit == 0){
			pageInit = 1;
			if(start == 0)start=1;
			kiPagination(total_rows, start, \'coveragePaging\', \'coverage_ajax\', \'coverage_ajax\', 3);
		}
	});
	
	function coverage_ajax(fungsi, start){
		$.post(\'index.php?page=coverage&act=\'+fungsi, {start : start}, function(data){
			var str=\'\';
			$.each(data, function(k,v){
				str+=\'<div class="row">\';
					str+=\'<div class="circles circle1">\';
						str+=\'<a href="#popupMap" class="showPopup"><img src="assets/content/map/map.jpg" /></a>\';
					str+=\'</div>\';
					str+=\'<div class="entry">\';
						str+=\'<h1>\'+v.title+\'</h1>\';
						str+=\'<p>\'+v.brief+\'</p>\';
						str+=\'<a class="detail showPopup" href="#popupMap" mapsid="\'+v.id+\'" >\'+locale+\'</a>\';
					str+=\'</div>\';
				str+=\'</div>\';
			});
			$(\'#location\').html(str);
		},"json");
	}
'; ?>

</script>