<?php /* Smarty version 2.6.13, created on 2012-12-19 18:09:19
         compiled from application/admin/Master/new_device.html */ ?>
<div class="theContent">
    <?php if ($this->_tpl_vars['msg']): ?><div class="notibar msgalert"><p><?php echo $this->_tpl_vars['msg']; ?>
</p></div><?php endif; ?>
    <div class="theTitle">
        <h2>Add Device</h2>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable inputable">
        <tbody>
            <form>
                <tr class="head">
                    <td><strong>Type</strong></td>
                </tr>
                <tr>
                    <td><input type="text" name="type" style="width:400px;" /></td>
                </tr>
                <tr>
                    <td><input type="submit" value=" Save " class="stdbtn btn_orange">&nbsp;&nbsp; <input class="stdbtn btn_yellow" type="button" value="Cancel" onclick="javascript: window.location.href='index.php?s=master&act=list_device' ;" /></td>
                </tr>
                <input type="hidden" name="cmd" value="add" />
                <input type="hidden" name="s" value="master" />
                <input type="hidden" name="act" value="add_device" />
            </form>
    	</tbody>
	</table>
</div><!--theContent-->