<?php /* Smarty version 2.6.13, created on 2012-12-19 17:59:36
         compiled from application/admin/Master/new_category_News.html */ ?>
<div class="theContent">
    <?php if ($this->_tpl_vars['msg']): ?><div class="notibar msgalert"><p><?php echo $this->_tpl_vars['msg']; ?>
</p></div><?php endif; ?>
    <div class="theTitle">
        <h2>Add Category News Content</h2>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable inputable">
        <tbody>
            <form>
                <tr>
                    <td width="100"><strong>Category Name</strong></td>
                    <td><input type="text" name="category"/></td>
                </tr>
                <tr>
                    <td><strong>Point</strong></td>
                    <td><input type="text" name="point"/></td>
                </tr>
                <tr>
                    <td valign="top" colspan="2"><strong>Language</strong></td>
                </tr>
                <tr>
                    <td valign="top"><strong>Indonesia</strong></td>
                    <td>
                      <input type="text" name="naming[1]"/>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><strong>Inggris</strong></td>
                    <td>
                     <input type="text" name="naming[2]"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <input type="submit" value=" Save" class="stdbtn btn_orange"/>&nbsp;&nbsp; 
                    <input type="button" value="Cancel" class="stdbtn btn_yellow" onclick="javascript: window.location.href='index.php?s=master&act=list_category' ;" />
                    </td>
                </tr>
                    <input type="hidden" name="cmd" value="add" />
                    <input type="hidden" name="s" value="master" />
                    <input type="hidden" name="act" value="add_category_news" />
            </form>
    	</tbody>
	</table>
</div><!--theContent-->