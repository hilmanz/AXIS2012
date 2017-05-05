<?php /* Smarty version 2.6.13, created on 2012-12-19 17:56:27
         compiled from application/admin/Master/edit_category_News.html */ ?>
<div class="theContent">
    <div class="theTitle">
        <h2>Edit Category News Content</h2>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable inputable">
        <tbody>
            <form name="cal" method="" action="" enctype="multipart/form-data" onsubmit="javascript: return validator();">
                <tr>
                    <td><strong>Category Name</strong></td>
                    <td><input type="text" name="category" style="width:400px;" value="<?php echo $this->_tpl_vars['cat_val']; ?>
"/></td>
                </tr>
                <tr>
                    <td><strong>Point</strong></td>
                    <td><input type="text" name="point" style="width:70px;text-align:right;" value="<?php echo $this->_tpl_vars['point']; ?>
"/></td>
                </tr>
                <tr>
                    <td valign="top" colspan="2"><strong>Language</strong></td>
                </tr>
                <tr>
                    <td valign="top"><strong>Indonesia</strong></td>
                    <td>
                       <input type="text" name="naming[1]" style="width:200px;" value="<?php echo $this->_tpl_vars['naming']['1']; ?>
"/>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><strong>Inggris</strong></td>
                    <td>
                      <input type="text" name="naming[2]" style="width:200px;" value="<?php echo $this->_tpl_vars['naming']['2']; ?>
"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <input type="submit" value=" Save" class="stdbtn btn_orange"/>&nbsp;&nbsp; 
                    <input type="button" value="Cancel" class="stdbtn btn_yellow" onclick="javascript: window.location.href='index.php?s=master&act=list_category' ;" />
                    </td>
                </tr>
                <input type="hidden" name="s" value="master" />
                <input type="hidden" name="act" value="edit_category_news" />
                <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id_cat']; ?>
" />
            </form>
    	</tbody>
	</table>
</div><!--theContent-->