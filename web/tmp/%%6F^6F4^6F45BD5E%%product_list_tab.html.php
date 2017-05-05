<?php /* Smarty version 2.6.13, created on 2012-12-19 17:17:06
         compiled from application/admin/Product/product_list_tab.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'application/admin/Product/product_list_tab.html', 4, false),array('modifier', 'cat', 'application/admin/Product/product_list_tab.html', 28, false),array('modifier', 'date_format', 'application/admin/Product/product_list_tab.html', 34, false),array('modifier', 'intval', 'application/admin/Product/product_list_tab.html', 37, false),)), $this); ?>

<div class="theContent">
    <div class="theTitle">
        <h2>Product Desription List - Title Content Article&nbsp; : &nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['title_article'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</h2>
        <a href="index.php?s=product&act=product_add&id_content=<?php echo $this->_tpl_vars['id_content']; ?>
&start=<?php echo $this->_tpl_vars['start']; ?>
" class="btn btn_pencil"><span>Add New</span></a>
        <a href="index.php?s=product" class="btn btn_archive"><span>Back to Product</span></a>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable">
        <colgroup>
            <col class="con0" style="width: 4%" />
            <col class="con1" />
            <col class="con0" />
            <col class="con1" />
            <col class="con0" />
            <col class="con1" />
        </colgroup>
        <thead>
            <tr>        
                <th class="head0">No</th>
                <th class="head1">Title</th>
                                <th class="head1">Date</th>
                <th class="head0">Status</th>
                <th class="head1" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $this->assign('fullpath', ((is_array($_tmp=$this->_tpl_vars['baseurl'])) ? $this->_run_mod_handler('cat', true, $_tmp, 'public_assets/') : smarty_modifier_cat($_tmp, 'public_assets/'))); ?>
            <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <tr>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['no']; ?>
&nbsp;</td>
                <td width="20%"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['title']; ?>
</td>
                                <td><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
 &nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['time']['time']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['time']['time'])); ?>
</nobr></td>
                <td>
                    <select name='status' onchange='javascript:changeStatus(<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
,this.value);' id="sel-<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
" style="width:150px;">
                        <option value="0" <?php if (((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['n_status'])) ? $this->_run_mod_handler('intval', true, $_tmp) : intval($_tmp)) == 0): ?> selected="selected"<?php endif; ?>>Non Publishing</option>
                        <option value="1" <?php if (((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['n_status'])) ? $this->_run_mod_handler('intval', true, $_tmp) : intval($_tmp)) == 1): ?> selected="selected" <?php endif; ?>>Publishing</option>
                    </select>
                </td>
                <td width="4%" align="center"><a class="blue" href="index.php?s=product&act=product_edit&id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
&id_content=<?php echo $this->_tpl_vars['id_content']; ?>
&start=<?php echo $this->_tpl_vars['start']; ?>
" style="text-decoration:none;"> Edit </a></td>
                <td width="4%" align="center"><a class="red" href="index.php?s=product&act=product_hapus&id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
&id_content=<?php echo $this->_tpl_vars['id_content']; ?>
&start=<?php echo $this->_tpl_vars['start']; ?>
" style="text-decoration:none;" onclick="return confirm('Are you sure you want to delete this?')">Delete</a></td>
            </tr>
            <?php endfor; endif; ?>
        </tbody>
    </table>
    <div class="paging">
    	<?php echo $this->_tpl_vars['paging']; ?>

    </div>
</div><!--theContent-->
<?php echo '
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){

});
	function changeStatus(id,status){
		$.get(
			\'index.php?s=product&act=change_status_product&id=\'+id+\'&status=\'+status,
			{},
			function(data){
				if(data.success > 0){
					$("#sel-"+id).fadeOut(\'fast\',function(){
						$("#sel-"+id).fadeIn(\'slow\');
					});
				}else{
					alert(\'Gagal mengganti status, silakan coba lagi!\');
				}
			},
			"json"
		);
		return false;
	}
</script>
'; ?>