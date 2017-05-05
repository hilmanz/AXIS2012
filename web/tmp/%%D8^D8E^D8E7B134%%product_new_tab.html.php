<?php /* Smarty version 2.6.13, created on 2012-12-19 17:17:13
         compiled from application/admin/Product/product_new_tab.html */ ?>
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
	}else if( $(\'#brief\').val() == \'\' ){
		alert("Please fill brief");
		return false;
	}else if( $(\'#teditor\').val() == \'\' ){
		alert("Please fill content");
		return false;
	}
}
	
</script>
'; ?>

<div class="theContent">
        <div class="theTitle">
        <h2>Add Product Description</h2>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable inputable">
        <tbody>
            <form method="post" action="" enctype="multipart/form-data" onsubmit="javascript: return validator();">
                <tr class="head">
                    <td><strong>Title</strong></td>
                    <td><input type="text" name="title" style="width:500px;" /></td>
                </tr>
                <tr class="head">
                    <td valign="top"><strong>Description</strong></td>
                    <td><textarea id="teditor" name="description" style="width:800px;height:400px;"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2">
                    <input type="submit" value=" Save " class="stdbtn btn_orange">&nbsp;&nbsp; 
                    <input type="button" value="Cancel" class="stdbtn btn_yellow" onclick="javascript: window.location.href='index.php?s=product&act=product_list&id=<?php echo $this->_tpl_vars['id_content']; ?>
&start=<?php echo $this->_tpl_vars['start']; ?>
' ;" />
                    </td>
                </tr>
                <input type="hidden" name="cmd" value="add" />
            </form>
        </tbody>
    </table>
</div><!--theContent-->