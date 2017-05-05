<?php /* Smarty version 2.6.13, created on 2012-11-15 15:07:30
         compiled from application/axisweb//axisProduct/isi-ulang.html */ ?>
<div id="breadcumb" class="wrapper">
	<h1><a href="index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a> &raquo; <a href="index.php?menu=isi-ulang"><?php echo $this->_tpl_vars['locale']['isiulang']['title']; ?>
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
            	<h1 class="icon_connector"><?php echo $this->_tpl_vars['locale']['isiulang']['lokasi']; ?>
</h1>
            </div><!-- end .theTitle -->
            <div class="shadowCtop">
                <div id="location" class="shadowCbottom">
					<div class="rowSelect">
					<select id="select1" name="select1" class="styled">
					  <option value="">-Daerah-</option>
					  <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['province']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
					  <option value="<?php echo $this->_tpl_vars['province'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['province'][$this->_sections['i']['index']]['province']; ?>
</option>
					  <?php endfor; endif; ?>
					</select>
					<select id="select2" name="select2" class="styled">
					  <option value="">-Kota-</option>
					</select>
					</div>
					<span id="result" class="white_table">
					<table cellpadding="0" cellspacing="0" border="0">
					  <thead>
						<tr>
						  <td><span id="namaKota"></span></td>
						</tr>
					  </thead>
					  <tbody id="daftarLokasi">
						
					  </tbody>
					</table>
					</span>
                </div><!-- end #location -->
            </div><!-- end .shadowCtop -->
            <div id="isi_ulangPaging" class="paging">
                
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
	var locale = "<?php if ($this->_tpl_vars['locale']['btn']['detail']):  echo $this->_tpl_vars['locale']['btn']['detail'];  else: ?>0<?php endif; ?>";
	var cityID;
<?php echo '
	$(document).on(\'click\',\'.detail\', function(){
		var id = $(this).attr("mapsid");
		$.post("index.php?page=isi_ulang&act=detail",{id:id},function(data){
			if(data){
				$(".mapLocation").html(data.content);
				$(".addressname").html(data.title);
				$(".placename").html(data.brief);
			}else	return false;
			return true;
		});
		
	});
	$("#pickCity").change(function(){
		$("#formSearch").submit();
	});
	
	function initiatePaging(total_rows){
		var pageInit = 0;
		var start = 0;
		//Init Page
		if(pageInit == 0){
			pageInit = 1;
			if(start == 0)start=1;
			kiPagination(total_rows, start, \'isi_ulangPaging\', \'isi_ulang_ajax\', \'isi_ulang_ajax\', 7);
		}
	}
	
	function isi_ulang_ajax(fungsi, start){
		$.post(\'index.php?page=isi_ulang&act=\'+fungsi, {start : start, city : cityID}, function(data){
			var str=\'\';
			$.each(data, function(k,v){
				str+=\'<tr>\';
					str+=\'<td><div class="title_area">\'+v.title+\'</div>\';
					str+=\'\'+v.brief+\'</td>\';
				str+=\'</tr>\';
			});
			$(\'#daftarLokasi\').html(str);
		});
	}
	
	$(\'#select1\').change(function(){
		$(\'#select2\').html(\'<option value="">-Kota-</option>\');
		$(\'#selectselect2\').html(\'-Kota-\');
		var province = $(this).val();
		$.post(\'index.php?page=isi_ulang&act=getCitybyProvince\', {province : province}, function(city){
			var str=\'\';
			str+=\'<option value="">-Kota-</option>\';
			$.each(city, function(k,v){
				str+=\'<option value="\'+v.id+\'">\'+v.city+\'</option>\';
			});
			$(\'#select2\').html(str);
		});
	});
	
	$(document).on(\'change\',\'#select2\',function(){
		cityID = $(this).val();
		$(\'#namaKota\').html($(\'#selectselect2\').html());
		
		$.post(\'index.php?page=isi_ulang&act=getLocationIsiUlang\', {city : cityID}, function(data){
			var str=\'\';
			if(data!=false){
				initiatePaging(data[0].total_rows);
				$.each(data, function(k,v){
					str+=\'<tr>\';
					str+=\'<td><div class="title_area">\'+v.title+\'</div>\';
					str+=\'\'+v.brief+\'</td>\';
					str+=\'</tr>\';
				});
			}else{
				$(\'#isi_ulangPaging\').html(\'\');
				str+=\'<tr><td>location is not available yet.</td></tr>\'
			}
			$(\'#daftarLokasi\').html(str);
		});
	});
'; ?>
		
</script>