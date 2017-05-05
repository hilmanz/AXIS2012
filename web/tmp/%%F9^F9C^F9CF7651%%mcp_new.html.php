<?php /* Smarty version 2.6.13, created on 2012-12-17 16:29:40
         compiled from application/admin/mcp/mcp_new.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'application/admin/mcp/mcp_new.html', 126, false),)), $this); ?>
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.min.js"></script>
<?php echo '
<script type="text/javascript">
	tinyMCE.init({
		theme : "advanced",
        mode : "exact",
        elements : "teditor",
		plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
		paste_remove_styles: true,
		paste_auto_cleanup_on_paste : true,
		
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",

		file_browser_callback : "ajaxfilemanager",
		paste_use_dialog : true,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : true,
		apply_source_formatting : true,
		force_br_newlines : true,
		force_p_newlines : false,	
		relative_urls : true,
		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false
	});
	function ajaxfilemanager(field_name, url, type, win) {
		var ajaxfilemanagerurl = "jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
		var view = \'detail\';
		switch (type) {
			case "image":
			view = \'thumbnail\';
				break;
			case "media":
				break;
			case "flash": 
				break;
			case "file":
				break;
			default:
				return false;
		}
		tinyMCE.activeEditor.windowManager.open({
		    url: "jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php?view=" + view,
		    width: 782,
		    height: 440,
		    inline : "yes",
		    close_previous : "no"
		},{window : win, input : field_name });
	}
	
function validator(){
	tinyMCE.triggerSave();
	if( $(\'#title\').val() == \'\' ){
		alert("Please fill title");
		return false;
	}
}
	
</script>
'; ?>

<div class="theContent">
    <?php if ($this->_tpl_vars['msg']): ?><div class="notibar msgalert"><p><?php echo $this->_tpl_vars['msg']; ?>
</p></div><?php endif; ?>
    <div class="theTitle">
        <h2>Add MCP Content</h2>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable inputable">
    <tbody>
        <form method="post" action="index.php?s=mcp&act=add" enctype="multipart/form-data" onsubmit="javascript: return validator();">
        <tr class="head">
            <td width="100"><strong>Language</strong></td>
            <td colspan="2">
                <select name="lid" style="width:200px;">
                    <option value=""> - Pilih - </option>
                    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['language']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                    <option value="<?php echo $this->_tpl_vars['language'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['language'][$this->_sections['i']['index']]['language']; ?>
</option>
                    <?php endfor; endif; ?>
                </select>
            </td>
        </tr>
        <tr class="head">
            <td><strong>Category</strong></td>
            <td colspan="2">
                <select name="categoryid" style="width:200px;">
                    <option value=""> - Pilih - </option>
                    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['cat']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                    <option value="<?php echo $this->_tpl_vars['cat'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['cat'][$this->_sections['i']['index']]['category']; ?>
</option>
                    <?php endfor; endif; ?>
                </select>
            </td>
        </tr>
        <tr class="head">
            <td><strong>Title</strong></td>
            <td colspan="2"><input type="text" id="title" name="title" style="width:500px;" /></td>
        </tr>
        <tr class="head">
            <td><strong>Brief</strong></td>
            <td colspan="2"><textarea name="brief" id="brief" style="width:600px"></textarea></td>
        </tr>
        <tr class="head">
            <td><strong>Images</strong></td>
            <td colspan="2"><input type="file" name="image" size="50"/>  <em>(JPG, GIF, BMP and PNG)</em></td>
        </tr>
        <tr class="head">
            <td valign="top"><strong>Content</strong></td>
            <td colspan="2"><textarea id="teditor" name="content" style="width:800px;height:400px;"></textarea></td>
        </tr>
        <tr class="head">
            <td><strong>Price</strong></td>
            <td colspan="2"><input type="text" id="prize" name="prize" style="width:500px;" /></td>
        </tr>
        <tr class="head">
            <td><strong>Url</strong></td>
            <td colspan="2"><input type="text" id="url" name="url" style="width:500px;" /></td>
        </tr>
        <tr class="head">
            <td valign="top"><strong>Device</strong></td>
            <td>
                <div style="width: 500px; overflow: auto; height: 100px;">
                    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['device']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                        <?php if ($this->_tpl_vars['device'][$this->_sections['i']['index']]['type']): ?><div><input type="checkbox" value="<?php echo $this->_tpl_vars['device'][$this->_sections['i']['index']]['id']; ?>
" name="device[]"><?php echo ((is_array($_tmp=$this->_tpl_vars['device'][$this->_sections['i']['index']]['type'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 </div> <?php endif; ?>
                    <?php endfor; endif; ?>
                </div>
                
            </td>
        </tr>
        <tr class="head">
            <td><strong>Status</strong></td>
            <td colspan="2">
                <select name="n_status" style="width:200px;">
                    <option value="0">Inactive</option>
                    <option value="1">Publish</option>
                    <option value="2">Unpublish</option>
                </select>
            </td>
        </tr>
        <tr class="head">
            <td>
                <strong>Date range</strong>
            </td>
            <td>
                Publish &nbsp;<input type="text" name="posted_date" value="<?php echo $this->_tpl_vars['posted_date']; ?>
" style="width:150px;" class="datepicker"/>&nbsp;&nbsp;
                &nbsp;
                Unpublish &nbsp;<input type="text" name="expired_date" value="<?php echo $this->_tpl_vars['expired_date']; ?>
" style="width:150px;" class="datepicker"/>&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value=" Save " class="stdbtn btn_orange">&nbsp;&nbsp; <input type="button" value="Cancel" class="stdbtn btn_yellow" onclick="javascript: window.location.href='index.php?s=mcp' ;" /></td>
        </tr>
        <input type="hidden" name="save" value="1" />
        </form>
    </tbody>
    </table>
</div><!--theContent-->