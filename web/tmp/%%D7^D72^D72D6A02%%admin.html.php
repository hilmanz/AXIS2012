<?php /* Smarty version 2.6.13, created on 2013-01-25 15:04:18
         compiled from common/admin/admin.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'common/admin/admin.html', 414, false),)), $this); ?>
<!--flash loader -->
<?php echo '
<script language="JavaScript" type="text/javascript">
<!--
//v1.7
// Flash Player Version Detection
// Detect Client Browser type
// Copyright 2005-2008 Adobe Systems Incorporated.  All rights reserved.
var isIE  = (navigator.appVersion.indexOf("MSIE") != -1) ? true : false;
var isWin = (navigator.appVersion.toLowerCase().indexOf("win") != -1) ? true : false;
var isOpera = (navigator.userAgent.indexOf("Opera") != -1) ? true : false;
function ControlVersion()
{
	var version;
	var axo;
	var e;
	// NOTE : new ActiveXObject(strFoo) throws an exception if strFoo isn\'t in the registry
	try {
		// version will be set for 7.X or greater players
		axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
		version = axo.GetVariable("$version");
	} catch (e) {
	}
	if (!version)
	{
		try {
			// version will be set for 6.X players only
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");
			
			// installed player is some revision of 6.0
			// GetVariable("$version") crashes for versions 6.0.22 through 6.0.29,
			// so we have to be careful. 
			
			// default to the first public version
			version = "WIN 6,0,21,0";
			// throws if AllowScripAccess does not exist (introduced in 6.0r47)		
			axo.AllowScriptAccess = "always";
			// safe to call for 6.0r47 or greater
			version = axo.GetVariable("$version");
		} catch (e) {
		}
	}
	if (!version)
	{
		try {
			// version will be set for 4.X or 5.X player
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");
			version = axo.GetVariable("$version");
		} catch (e) {
		}
	}
	if (!version)
	{
		try {
			// version will be set for 3.X player
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");
			version = "WIN 3,0,18,0";
		} catch (e) {
		}
	}
	if (!version)
	{
		try {
			// version will be set for 2.X player
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
			version = "WIN 2,0,0,11";
		} catch (e) {
			version = -1;
		}
	}
	
	return version;
}
// JavaScript helper required to detect Flash Player PlugIn version information
function GetSwfVer(){
	// NS/Opera version >= 3 check for Flash plugin in plugin array
	var flashVer = -1;
	
	if (navigator.plugins != null && navigator.plugins.length > 0) {
		if (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]) {
			var swVer2 = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";
			var flashDescription = navigator.plugins["Shockwave Flash" + swVer2].description;
			var descArray = flashDescription.split(" ");
			var tempArrayMajor = descArray[2].split(".");			
			var versionMajor = tempArrayMajor[0];
			var versionMinor = tempArrayMajor[1];
			var versionRevision = descArray[3];
			if (versionRevision == "") {
				versionRevision = descArray[4];
			}
			if (versionRevision[0] == "d") {
				versionRevision = versionRevision.substring(1);
			} else if (versionRevision[0] == "r") {
				versionRevision = versionRevision.substring(1);
				if (versionRevision.indexOf("d") > 0) {
					versionRevision = versionRevision.substring(0, versionRevision.indexOf("d"));
				}
			}
			var flashVer = versionMajor + "." + versionMinor + "." + versionRevision;
		}
	}
	// MSN/WebTV 2.6 supports Flash 4
	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.6") != -1) flashVer = 4;
	// WebTV 2.5 supports Flash 3
	else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.5") != -1) flashVer = 3;
	// older WebTV supports Flash 2
	else if (navigator.userAgent.toLowerCase().indexOf("webtv") != -1) flashVer = 2;
	else if ( isIE && isWin && !isOpera ) {
		flashVer = ControlVersion();
	}	
	return flashVer;
}
// When called with reqMajorVer, reqMinorVer, reqRevision returns true if that version or greater is available
function DetectFlashVer(reqMajorVer, reqMinorVer, reqRevision)
{
	versionStr = GetSwfVer();
	if (versionStr == -1 ) {
		return false;
	} else if (versionStr != 0) {
		if(isIE && isWin && !isOpera) {
			// Given "WIN 2,0,0,11"
			tempArray         = versionStr.split(" "); 	// ["WIN", "2,0,0,11"]
			tempString        = tempArray[1];			// "2,0,0,11"
			versionArray      = tempString.split(",");	// [\'2\', \'0\', \'0\', \'11\']
		} else {
			versionArray      = versionStr.split(".");
		}
		var versionMajor      = versionArray[0];
		var versionMinor      = versionArray[1];
		var versionRevision   = versionArray[2];
        	// is the major.revision >= requested major.revision AND the minor version >= requested minor
		if (versionMajor > parseFloat(reqMajorVer)) {
			return true;
		} else if (versionMajor == parseFloat(reqMajorVer)) {
			if (versionMinor > parseFloat(reqMinorVer))
				return true;
			else if (versionMinor == parseFloat(reqMinorVer)) {
				if (versionRevision >= parseFloat(reqRevision))
					return true;
			}
		}
		return false;
	}
}
function AC_AddExtension(src, ext)
{
  if (src.indexOf(\'?\') != -1)
    return src.replace(/\\?/, ext+\'?\'); 
  else
    return src + ext;
}
function AC_Generateobj(objAttrs, params, embedAttrs) 
{ 
  var str = \'\';
  if (isIE && isWin && !isOpera)
  {
    str += \'<object \';
    for (var i in objAttrs)
    {
      str += i + \'="\' + objAttrs[i] + \'" \';
    }
    str += \'>\';
    for (var i in params)
    {
      str += \'<param name="\' + i + \'" value="\' + params[i] + \'" /> \';
    }
    str += \'</object>\';
  }
  else
  {
    str += \'<embed \';
    for (var i in embedAttrs)
    {
      str += i + \'="\' + embedAttrs[i] + \'" \';
    }
    str += \'> </embed>\';
  }
  document.write(str);
}
function AC_FL_RunContent(){
  var ret = 
    AC_GetArgs
    (  arguments, ".swf", "movie", "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
     , "application/x-shockwave-flash"
    );
  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);
}
function AC_SW_RunContent(){
  var ret = 
    AC_GetArgs
    (  arguments, ".dcr", "src", "clsid:166B1BCA-3F9C-11CF-8075-444553540000"
     , null
    );
  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);
}
function AC_GetArgs(args, ext, srcParamName, classid, mimeType){
  var ret = new Object();
  ret.embedAttrs = new Object();
  ret.params = new Object();
  ret.objAttrs = new Object();
  for (var i=0; i < args.length; i=i+2){
    var currArg = args[i].toLowerCase();    
    switch (currArg){	
      case "classid":
        break;
      case "pluginspage":
        ret.embedAttrs[args[i]] = args[i+1];
        break;
      case "src":
      case "movie":	
        args[i+1] = AC_AddExtension(args[i+1], ext);
        ret.embedAttrs["src"] = args[i+1];
        ret.params[srcParamName] = args[i+1];
        break;
      case "onafterupdate":
      case "onbeforeupdate":
      case "onblur":
      case "oncellchange":
      case "onclick":
      case "ondblclick":
      case "ondrag":
      case "ondragend":
      case "ondragenter":
      case "ondragleave":
      case "ondragover":
      case "ondrop":
      case "onfinish":
      case "onfocus":
      case "onhelp":
      case "onmousedown":
      case "onmouseup":
      case "onmouseover":
      case "onmousemove":
      case "onmouseout":
      case "onkeypress":
      case "onkeydown":
      case "onkeyup":
      case "onload":
      case "onlosecapture":
      case "onpropertychange":
      case "onreadystatechange":
      case "onrowsdelete":
      case "onrowenter":
      case "onrowexit":
      case "onrowsinserted":
      case "onstart":
      case "onscroll":
      case "onbeforeeditfocus":
      case "onactivate":
      case "onbeforedeactivate":
      case "ondeactivate":
      case "type":
      case "codebase":
      case "id":
        ret.objAttrs[args[i]] = args[i+1];
        break;
      case "width":
      case "height":
      case "align":
      case "vspace": 
      case "hspace":
      case "class":
      case "title":
      case "accesskey":
      case "name":
      case "tabindex":
        ret.embedAttrs[args[i]] = ret.objAttrs[args[i]] = args[i+1];
        break;
      default:
        ret.embedAttrs[args[i]] = ret.params[args[i]] = args[i+1];
    }
  }
  ret.objAttrs["classid"] = classid;
  if (mimeType) ret.embedAttrs["type"] = mimeType;
  return ret;
}
// -->
</script>
'; ?>

<!-- with design -->
<!--
<script src="../Scripts/scriptaculous/lib/prototype.js"></script>
<script src="../Scripts/scriptaculous/src/scriptaculous.js"></script>
<script src="../Scripts/scriptaculous/src/effects.js"></script>
<script src="../Scripts/scriptaculous/src/controls.js"></script>
-->
<!-- phototags -->
<!--
<link rel="stylesheet" href="css/jqueryPhotoTags/style.css" type="text/css" media="screen" title="no title" charset="utf-8"/>
<script src="../Scripts/jqueryPhotoTags/jquery-1.3.2.min.js"></script>
<script src="../Scripts/jqueryPhotoTags/jquery.imgareaselect-0.7.min.js"></script>
<script src="../Scripts/jqueryPhotoTags/jquery.load.js"></script>
-->
<!-- /phototags -->


<script>
    <?php echo '
    function preview(str){
        //var popup = window.open ("preview.php","preview");
        //popup.document.getElementById(\'mainContent\').innerHTML = str;
        //alert(popup.document.getElementById(\'mainContent\').innerHTML);
        $(\'popup_preview\').style.display=\'block\';
        var foo = document.viewport.getScrollOffsets();
        new Effect.Move(\'popup_preview\', { x: foo.left, y: foo.top, mode: \'absolute\' });
        //alert(\'yey\');
        $(\'preview\').innerHTML = "";
        new Ajax.Updater(\'preview\', \'preview.php?\'+Math.random(100000), {
            parameters: { CONTENT: str }
        });

        //$(\'popup_preview\').style.top=window.scrollTop;
    }
    function close_preview(){
        $(\'popup_preview\').style.top=0;
        $(\'popup_preview\').style.display=\'none\';

    }
    '; ?>

    <?php echo '
    function confirmDialog(sURL,t){
        var f = false;
        if(t=="delete"){
            if(confirm("By removing this page, all the pages under this page will be inaccessible. Are you sure to delete this Page ?"							)){
                f = true;
            }
        }else if(t=="remove_group"){
            if(confirm("By removing this group, all the contents under the group will be inaccessible. Are you sure to delete this group ? ")){
                f = true;
            }
        }else{
            if(confirm("Are you sure ? ")){
                f = true;
            }
        }
        if(f){
            document.location=sURL;
        }else{
            return false;
        }
    }
    '; ?>

</script>
<div id="body">
	<div id="header">
    	<div class="logo-block">
        	<a class="logo" href="index.php">&nbsp;</a>
        </div><!-- .logo-block -->
        <div class="infoPage">
        	<h3>ADMINISTRATOR</h3>
        </div>
    </div><!-- #header -->
	<div id="main-container">
        <div id="container">
        	<div class="top">
            	<div class="block-info">
                    <!-- css menu tree -->
                    <div class="nav">
                        <ul class="menu" id="menu">
                           <li>
                                <a href="#">Users</a>
                                <ul>
                                    <li><a href="index.php?s=axisuser">User Profile</a></li>
								</ul>
                            </li>
                           <li>
                                <a href="#">Contents</a>
                                <ul>
                                    <li><a href="index.php?s=article">News & Article List</a></li>
									<li><a href="index.php?s=article_user">User Content</a></li>
									<li><a href="index.php?s=banner">Banner</a></li>
									<li><a href="index.php?s=product">Product</a></li>
									<li><a href="index.php?s=mcp">MCP Content</a></li>
									<li><a href="index.php?s=coverage">Coverage Area Content</a></li>
									<li><a href="index.php?s=isi_pulsa">Lokasi Isi Ulang Content</a></li>
									<li><a href="index.php?s=popup_article">Popup Article</a></li>
								</ul>
                            </li>
							<li>
                                <a href="#">Messaging</a>
                                <ul>
                                    <!-- <li><a href="index.php?s=message">User to CS Message</a></li> -->
                                    <li><a href="index.php?s=message_cscorporate">CS Corporate</a></li>
                                    <li><a href="index.php?s=message_cswebsite">CS Website</a></li>
                                    								</ul>
                            </li>
							<li>
                                <a href="#">Corporate</a>
                                <ul>
                                    <li><a href="index.php?s=coorporate_blog">Blog Entry</a></li>
									<li><a href="index.php?s=coorporate_news">News Entry</a></li>
									<li><a href="index.php?s=coorporate_career">Career Entry</a></li>
									<li><a href="index.php?s=distributor_resmi">Distributor Resmi Entry</a></li>
																		<li><a href="index.php?s=kualitaslayanan">Kulitas Layanan Entry</a></li>
									<li><a href="index.php?s=galeri">Gallery Entry</a></li>
									<li><a href="index.php?s=division">Division</a></li>
								</ul>
                            </li>
							<li>
                                <a href="#">Report</a>
								<ul>
																		<li><a href="index.php?s=reportactivityadmin">Admin Activity</a></li>
								</ul>
                            </li>
                        </ul>
						<script type="text/javascript">var menu=new menu.dd("menu");menu.init("menu","menuhover");</script>
                    </div>
                </div>
                <div class="admin-icon">
                    <span class="username">
                        Welcome, <?php echo ((is_array($_tmp=$this->_tpl_vars['user']['username'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 
                    </span>
                	<a class="btn btn2 btn_pink btn_lock" href="logout.php"><span>Log Off</span></a>
                	<a class="btn btn2 btn_pink btn_users" href="index.php?s=admin"><span>Administration</span></a>
				</div>
            </div><!-- .top -->
            <div id="content">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><?php echo $this->_tpl_vars['content']; ?>
</td>
                    </tr>
                </table>
            </div>
        </div><!-- #container -->
    </div><!-- #main-container -->
</div>