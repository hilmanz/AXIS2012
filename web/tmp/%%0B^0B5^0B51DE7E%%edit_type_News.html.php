<?php /* Smarty version 2.6.13, created on 2012-12-19 17:51:41
         compiled from application/admin/Master/edit_type_News.html */ ?>
<div class="theContent">
    <div class="theTitle">
        <h2>Edit Type News Content</h2>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable inputable">
        <tbody>
        <form name="cal" method="" action="" enctype="multipart/form-data" onsubmit="javascript: return validator();">
            <tr class="head"><td><strong>Type Name</strong></td></tr>
            <tr><td><input type="text" name="type" style="width:400px;" value="<?php echo $this->_tpl_vars['type_val']; ?>
"/></td></tr>
            <tr>
                <td>
                <input type="submit" value=" Save " class="stdbtn btn_orange">&nbsp;&nbsp; 
                <input type="button" value="Cancel" class="stdbtn btn_yellow" onclick="javascript: window.location.href='index.php?s=master&act=list_type' ;" />
                </td>
            </tr>
            <input type="hidden" name="s" value="master" />
            <input type="hidden" name="act" value="edit_type_news" />
            <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id_type']; ?>
" />
        </form>
    	</tbody>
	</table>
</div><!--theContent-->