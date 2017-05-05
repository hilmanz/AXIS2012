<?php /* Smarty version 2.6.13, created on 2012-12-03 10:24:16
         compiled from application/mobile/costumerCare.html */ ?>
<div class="breadcrumb">
		<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a>	&raquo; <a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=kontak"><?php echo $this->_tpl_vars['locale']['nav']['customercare']; ?>
</a>	
	</div>

<div class="page-body" data-role="content">
		
		<div class="page-image-heading">
			<img src="assets/images/ask_axis.jpg" />
		</div>
		
		<div class="page-meta">
			<h1 class="page-title"><span class="icon"></span>PERLU BANTUAN?</h1>
		
			<div class="page-content clear">
                <div class="customerbox">
					<div class="entry">
						<?php echo $this->_tpl_vars['locale']['customercare']['melaluitelepon']; ?>

                    </div><!-- end .entry -->
                    <span class="callNumber"><?php echo $this->_tpl_vars['locale']['customercare']['melaluiteleponnomer']; ?>
</span>
				</div><!-- end .customerbox -->
                <form id="contactForm" action="index.php?page=kontak&act=saveMessage" class="theForm validate" method="POST">
                    <div class="entryTitle">
                       <?php echo $this->_tpl_vars['locale']['customercare']['lewatemail']; ?>

                    </div><!-- end .entryTitle -->
                    <div class="w300 rowBtns">
						<div id="success" style="display: none;color: green;">Your message has been sent.</div>
						<div id="fail" style="display: none;color: #ff0000;">Please complete/fill the form.</div>
                        <input type="text" name="txtName" value="<?php echo $this->_tpl_vars['locale']['customercare']['nama']; ?>
" onBlur="if(this.value=='')this.value='<?php echo $this->_tpl_vars['locale']['customercare']['nama']; ?>
';" onFocus="if(this.value=='<?php echo $this->_tpl_vars['locale']['customercare']['nama']; ?>
')this.value='';$('#txtName_error').hide()" class="alpha required" />
                        <input type="text" name="txtEmail" value="Email" onBlur="if(this.value=='')this.value='Email';" onFocus="if(this.value=='Email')this.value='';$('#txtEmail_error').hide()" class="email required" />
                        <input type="text" name="txtTelepon" value="<?php echo $this->_tpl_vars['locale']['customercare']['noaxis']; ?>
" onBlur="if(this.value=='')this.value='<?php echo $this->_tpl_vars['locale']['customercare']['noaxis']; ?>
';" onFocus="if(this.value=='<?php echo $this->_tpl_vars['locale']['customercare']['noaxis']; ?>
')this.value='';$('#txtTelepon_error').hide()" class="numeric required" />
                        <select id="select1" name="txtPropinisi" class="styled required">
                            <option value="" ><?php echo $this->_tpl_vars['locale']['customercare']['propinsi']; ?>
</option>
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
                        <select id="select2" name="txtKota" class="styled required">
                            <option ="">Kota</option>
                        </select>
                        <select name="txtTipe"  class="styled required">
                            <option =""><?php echo $this->_tpl_vars['locale']['customercare']['jenispertanyaan']; ?>
</option>
							<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['msgType']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
								<option value='<?php echo $this->_tpl_vars['msgType'][$this->_sections['i']['index']]['type']; ?>
'><?php echo $this->_tpl_vars['msgType'][$this->_sections['i']['index']]['type']; ?>
</option>
							<?php endfor; endif; ?>
                        </select>
                    </div>
                    <div class="w600">
                        <textarea name="txtMessage" onFocus="$('#txtMessage_error').hide()" class="required"></textarea>
                        <label><input type="checkbox" id="checkthis" name="checkTXT"  class="styled" /> <?php echo $this->_tpl_vars['locale']['customercare']['custos']; ?>
</label>
                        <input type="submit" class="kirim" value="KIRIM" />
                    </div>
               </form>
			</div>
		</div>
		
		<div class="list-nav">
			<ul data-role="listview" data-inset="true">
				<li>
					<a href="index.php" data-transition="slide" data-url="index.php">
						<span class="icon icon-home"></span>
						Back To Home
					</a>
				</li>
			</ul>
		</div>
	</div><!-- /content -->

<script>
var kota = '<?php echo $this->_tpl_vars['locale']['customercare']['kota']; ?>
';
<?php echo '
	var required = v2.Validator.get(\'required\').getMessage();
	
	$("#contactForm").submit(function(){
		$(\'html, body\').animate({scrollTop: \'800px\'}, 800);
		
		$(this).ajaxSubmit(function(data) { 
			if(data.result) {
				$(\'#success\').fadeIn();
				$(\'#success\').delay(10000).fadeOut();
			}else {
				$(\'#fail\').fadeIn();
				$(\'#fail\').delay(10000).fadeOut();
			}
		});
		return false; 
	});

	$(\'#select1\').change(function(){
		$(\'#select2\').html(\'<option value="">\'+kota+\'</option>\');
		$(\'#selectselect2\').html(kota);
		var province = $(this).val();
		$.post(\'index.php?page=kontak&act=getCitybyProvince\', {province : province}, function(city){
			var str=\'\';
			str+=\'<option value="">\'+kota+\'</option>\';
			$.each(city, function(k,v){
				str+=\'<option value="\'+v.id+\'">\'+v.city+\'</option>\';
			});
			$(\'#select2\').html(str);
		});
	});
'; ?>

</script>