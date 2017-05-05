<?php /* Smarty version 2.6.13, created on 2012-11-13 11:36:25
         compiled from application/coorporate/widgets/recent_blog.html */ ?>

<div class="theBox">
    <div class="headBox">
        <h1>BLOG dari cmo</h1>
    </div><!-- end .headBox -->
    <div class="entryBox">
        <div class="row">
            <div class="smallThumb">
                <a href="index.php?menu=blog"><img src="public_assets/blog/<?php echo $this->_tpl_vars['latest']['image']; ?>
" /></a>
            </div>
            <div class="entrySmall">
                <h1><?php echo $this->_tpl_vars['latest']['author']['name']; ?>
 <a href="index.php?menu=blog">(<?php echo $this->_tpl_vars['latest']['author']['position']; ?>
)</a></h1>
                <p><a href="index.php?menu=blog"><?php echo $this->_tpl_vars['latest']['title']; ?>
 </a></p> 
                <p class="date"><?php echo $this->_tpl_vars['latest']['posted_date']; ?>
 </p>
                <a class="readmore" href="index.php?menu=blog">baca selengkapnya</a>
            </div>
        </div><!-- end .row -->
    </div><!-- end .entryBox -->
    <div class="shadow"></div>
</div><!-- end .theBox -->