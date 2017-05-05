<?php /* Smarty version 2.6.13, created on 2013-01-25 14:58:12
         compiled from common/admin/dashboard.html */ ?>
<div class="theContent">
    <div class="theTitle">
        <h2>AXISWORLD</h2>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable inputable">
        <tbody>
            <tr>
                <td>
                	<a href="index.php?s=article" class="btn btn_document"><span>News & Article List</span></a>
                	<a href="index.php?s=article&act=userpost" class="btn btn_users"><span>User Content</span></a>
                	<a href="index.php?s=banner" class="btn btn_flag"><span>Banner</span></a>
                	<a href="index.php?s=product" class="btn btn_folder"><span>Product</span></a>
                	<a href="index.php?s=mcp" class="btn btn_clip"><span>MCP Content</span></a>
                	<a href="index.php?s=coverage" class="btn btn_world"><span>Coverage Area Content</span></a>
                	<a href="index.php?s=isi_pulsa" class="btn btn_marker"><span>Lokasi Isi Ulang Content</span></a>
                	<a href="index.php?s=popup_article" class="btn btn_tag"><span>Popup Article</span></a>
                </td>
            </tr>
        </tbody>
    </table><br /><br />
    <div class="theTitle">
        <h2>ARTICLE STATISTIK</h2>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable inputable">
        <tbody>
            <tr>
                <td>
					<font size="3" style="font-weight: bold;">Total Article Unpublish (<?php echo $this->_tpl_vars['jml_unpublish']; ?>
)</font>&nbsp;&nbsp;&nbsp;<font size="3" style="font-weight: bold;">|</font>&nbsp;&nbsp;&nbsp;
					<font size="3" style="font-weight: bold;">Total Article Publish (<?php echo $this->_tpl_vars['jml_publish']; ?>
)</font>&nbsp;&nbsp;&nbsp;<font size="3" style="font-weight: bold;">|</font>&nbsp;&nbsp;&nbsp;
					<font size="3" style="font-weight: bold;">Total Article Inactive (<?php echo $this->_tpl_vars['jml_inactive']; ?>
)</font>&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
        </tbody>
    </table><br /><br />
    <div class="theTitle">
        <h2>CORPORATE</h2>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable inputable">
        <tbody>
            <tr>
                <td><a href="index.php?s=coorporate_blog" class="btn btn_rss"><span>Blog Entry</span></a>
                	<a href="index.php?s=coorporate_news" class="btn btn_note"><span>News Entry</span></a>
                    <a href="index.php?s=coorporate_career" class="btn btn_users"><span>Career Entry</span></a>
                    <a href="index.php?s=distributor_resmi" class="btn btn_link"><span>Distributor Resmi Entry</span></a>
                    <a href="index.php?s=kualitaslayanan" class="btn btn_mouse"><span>Kulitas Layanan Entry</span></a>
                    <a href="index.php?s=galeri" class="btn btn_paint"><span>Gallery Entry</span></a>
                    <a href="index.php?s=division" class="btn btn_user"><span>Division</span></a>
                </td>
            </tr>
        </tbody>
    </table>
</div><!--theContent-->