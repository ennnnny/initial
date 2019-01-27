<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
<?php if (!empty($this->options->Breadcrumbs) && in_array('Postshow', $this->options->Breadcrumbs)): ?>
<div class="breadcrumbs">
<a href="<?php $this->options->siteUrl(); ?>">首页</a> &raquo; <?php $this->category(); ?> &raquo; <?php if (!empty($this->options->Breadcrumbs) && in_array('Text', $this->options->Breadcrumbs)): ?>正文<?php else: $this->title(); endif; ?>
</div>
<?php endif; ?>
<article class="post<?php if ($this->options->PjaxOption && $this->hidden): ?> protected<?php endif; ?>">
<h1 class="post-title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h1>
<ul class="post-meta">
<li><?php $this->date(); ?></li>
<li><?php $this->category(','); ?></li>
<li><a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('暂无评论', '%d 条评论'); ?></a></li>
<li><?php Postviews($this); ?></li>
<li><?php Like_Plugin::theLike(); ?></li>
</ul>
<div class="post-content">
<?php
//$this->content();
$db = Typecho_Db::get();
$sql = $db->select()->from('table.comments')
    ->where('cid = ?', $this->cid)
    ->where('mail = ?', $this->remember('mail', true))
    ->limit(1);
$result = $db->fetchAll($sql);
if ($this->user->hasLogin() || $result) {
    $content = preg_replace("/\[hide\](.*?)\[\/hide\]/sm", '<div style="display: block;
    background: #dddddd;
    padding: 10px;
    color: #666666;
    max-width: 100%;
    overflow: hidden;
    text-align: center;
    font-size: 16px;">$1</div>', $this->content);
} else {
    $content = preg_replace("/\[hide\](.*?)\[\/hide\]/sm", '<div style="display: block;
    background: #dddddd;
    padding: 10px;
    color: #666666;
    max-width: 100%;
    overflow: hidden;
    text-align: center;
    font-size: 16px;">此处内容需要评论回复后方可阅读。</div>', $this->content);
}
echo $content;
?>
</div>
<?php if ($this->options->WeChat || $this->options->Alipay): ?>
<p class="rewards">打赏: <?php if ($this->options->WeChat): ?>
<a><img src="<?php $this->options->WeChat(); ?>" alt="微信收款二维码" />微信</a><?php endif; if ($this->options->WeChat && $this->options->Alipay): ?>, <?php endif; if ($this->options->Alipay): ?>
<a><img src="<?php $this->options->Alipay(); ?>" alt="支付宝收款二维码" />支付宝</a><?php endif; ?>
</p>
<?php endif; ?>
<!--<p class="tags">标签: --><?php //$this->tags(', ', true, 'none'); ?><!--</p>-->
</article>
<div class="article-extend card">
    <p class="tag-title share"><i class="fa fa-share-square-o"></i>&nbsp;分享给好友：
        <span class="extend-share">
         <a title="分享到空间" rel="nofollow" class="be be be-qzone" href="//sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php $this->permalink() ?>&title=<?php $this->title() ?>&pics=<?php echo fullurl($this->options->appleimg,0); ?>&desc=这篇文章写的不错，推荐看看&summary=<?php $this->excerpt(65, '......'); ?>&site=<?php $this->options->rootUrl(); ?>" target="_blank" onclick="window.open(this.href, 'qzone-share', 'width=745,height=660');return false;"></a>
         <a title="分享到微博" rel="nofollow" class="be be-stsina" href="//service.weibo.com/share/share.php?url=<?php $this->permalink() ?>&pic=<?php echo fullurl($this->options->appleimg,0); ?>&title=<?php $this->title() ?>_<?php $this->options->title(); ?>" target="_blank" onclick="window.open(this.href, 'weibo-share', 'width=650,height=475');return false;"></a>
         <a title="分享到 QQ" rel="nofollow" class="be be-qq" href="//connect.qq.com/widget/shareqq/index.html?url=<?php $this->permalink() ?>&desc=这篇文章写的不错，推荐看看&pics=<?php echo fullurl($this->options->appleimg,0); ?>&title=<?php $this->title() ?>_<?php $this->options->title(); ?>&summary=<?php $this->excerpt(65, '......'); ?>" target="_blank" onclick="window.open(this.href, 'qq-share', 'width=745,height=660');return false;"></a>
         <a data-fancybox="" rel="nofollow" href="javascript:wechatShare('<?php $this->permalink() ?>');" class="weixin"><i class="be be-weixin"></i></a>
        </span>
    </p>
    <p class="tag-title continue"><i class="fa fa-forward"></i>&nbsp;继续浏览关于
        <span class="tag-list">
            <?php if(($this->options->PjaxOption && $this->hidden) || !$this->user->hasLogin()):?>
                <a href="#article-content">请先验证密码</a>
            <?php else:?>
                <?php $this->tags('', true, ''); ?>
            <?php endif;?>
         </span>
        的文章</p>
    <p class="tag-title update"><i class="fa fa-clock-o"></i>&nbsp;本文最后更新于：<span class="extend-date"><?php if( $this->modified > $this->created ){echo date('Y/m/d H:i:s', $this->modified);}else{ echo date('Y/m/d H:i:s', $this->created); } ?><span class="mianbaoxie">，可能因经年累月而与现状有所差异</span>。</span></p>
    <p class="tag-title warning"><i class="fa fa-copyright"></i>&nbsp;引用转载请注明：<span class="mianbaoxie"><a href="<?php $this->options->rootUrl(); ?>" class="yinyong"><?php $this->options->title(); ?></a> > <?php $this->category(','); ?> > </span><a href="<?php $this->permalink() ?>" class="yinyong"><?php $this->title() ?></a> </p>
</div>
<?php $this->need('comments.php'); ?>
<ul class="post-near">
<li>上一篇: <?php $this->thePrev('%s','没有了'); ?></li>
<li>下一篇: <?php $this->theNext('%s','没有了'); ?></li>
</ul>
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>