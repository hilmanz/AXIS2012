<?php /* Smarty version 2.6.13, created on 2012-12-19 18:05:47
         compiled from application/admin/Master/new_page.html */ ?>
<div class="theContent">
    <?php if ($this->_tpl_vars['msg']): ?><div class="notibar msgalert"><p><?php echo $this->_tpl_vars['msg']; ?>
</p></div><?php endif; ?>
    <div class="theTitle">
        <h2>Add Page</h2>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable inputable">
        <tbody>   
            <form>
                <tr class="head">
                    <td><strong>Page Name</strong></td>
                </tr>
                <tr>
                    <td><input type="text" name="pagename" style="width:400px;" /></td>
                </tr>
                <tr class="head">
                    <td><strong>Status</strong></td>
                </tr>
                <tr>			
                    <td colspan="2">
                        <select name="n_status" style="width:200px;">
                            <option value="0">Unpublish</option>
                            <option value="1">Publish</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value=" Save " class="stdbtn btn_orange">&nbsp;&nbsp; <input class="stdbtn btn_yellow" type="button" value="Cancel" onclick="javascript: window.location.href='index.php?s=master&act=list_page' ;" /></td>
                </tr>
                <input type="hidden" name="cmd" value="add" />
                <input type="hidden" name="s" value="master" />
                <input type="hidden" name="act" value="add_page_news" />
            </form>
    	</tbody>
	</table>
</div><!--theContent-->