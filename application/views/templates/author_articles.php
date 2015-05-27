    <div class="inner-wrapper">
        <div class="inner-left">
            <!--breadcrumb -->
            <div class="breadcrumb" style="border-bottom:1px solid #f0f1f2">
                <h2>Articles</h2>
                <p style='font-weight: normal; color: #999;'>
                    <span><i class="fa fa-user"></i> <a href="<?php echo site_url('author').'/'.$auth_id;?>"><?php echo $auth_name;?></a></span>
                    <span>Contribution <span class='caveat'><?php echo $total_articles; ?></span></span>
                </p>
            </div>
            <!--/breadcrumb --> 
            <?php
            if(isset($articles) && is_array($articles)) :
                echo isset($pagination)? $pagination : '';

            foreach($articles as $article):
                $article_id = $article['id'];
                $article_auth = stripslashes($article['name']);
                $article_auth_id = $article['auth_id'];
                $article_pub_date = $article['pub_date'];
                $article_slug = $article['slug'];
                $article_title = stripslashes($article['title']);
                $article_title_url = url_title($article_title, '-', TRUE);
                $article_message = html_entity_decode($article['summary']);
                $article_pic = $article['thumb_name'];
                $article_pic_alt = $article['img_alt'];
                $article_tags = array_map('trim', explode(',', $article['tags']));
                $article_path = base_url('asset/img/article_thumbnails').'/'.$article_pic;
            ?>
            <article>
                <header><h1><a href="<?php echo site_url('article').'/'.$article_slug; ?>"><?php echo $article_title; ?></a></h1></header>
                <div class="header-meta"><span><i class="fa fa-clock-o "></i>&nbsp;<?php echo $article_pub_date;?> &nbsp;</span>
                    <span><i class='fa fa-user'></i><a href='<?php echo site_url('author').'/'.$article_auth_id; ?>'><?php echo $article_auth; ?></a></span>
                    <span>&nbsp;<i class='fa fa-comment'></i><a href="<?php echo site_url('article').'/'.url_title($article_title, '-', TRUE).'#disqus_thread'; ?>"></a> </span></div>
                    <?php if($article_pic !== ''):  ?>
                    <a href="<?php echo site_url('article').'/'.$article_slug; ?>"> <img class="article-img" src="<?php echo $article_path; ?>"  alt="<?php echo $article_pic_alt; ?>" /></a>
                <?php endif; ?>
                <div id="summary"><?php echo $article_message; ?></div>
                <span class="more-btn"><a href="<?php echo site_url('article').'/'.$article_slug;?>">Continue reading <i class="fa fa-long-arrow-right"></i></a></span>
                <p class="clear"></p>
                <ul class="article-tags">
                    <?php foreach($article_tags as $tag): ?>
                    <li><a href="<?php echo site_url('article/tags').'/'.url_title($tag); ?>"><?php echo url_title($tag); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <p class="clear"></p>
            </article>
            <?php endforeach; ?>
            <div class="load-more" data-auth-id="<?php echo $article_auth_id; ?>" data-page-id="2" data-total-articles='<?php echo $total_articles; ?>'>Load More &nbsp;&nbsp;<img src="" style="display:none;" height="20" width="20"></div>
            <?php else:
                echo "<p class='warning'>No data found</p>";
            endif; ?>
        </div><!-- /inner-left -->
            <?php include 'sidebar.php'; ?>
            <p class="clear"></p>
    </div><!-- /inner-wrapper -->
</div><!-- /container -->


<script type="text/javascript">
/** JS for load-more btn **/
var $load_more_btn = $('.load-more');

$load_more_btn.click(function(){
    $this = $(this);
    var loader = $('#base-url').data('base-url') + 'asset/img/cms/ajax_loader5.gif';
    var $more_articles = $('.inner-left').find('article').last();

    $this.find('img').show().attr('src', loader);
    var site_url = $('#site-url').data('site-url');
    var page_id = $this.data('page-id');
    var auth_id = $this.data('auth-id');
    var total_articles = $this.data('total-articles');

    var data = {page_id : page_id, auth_id : auth_id, total_articles : total_articles};
    var url = site_url + '/authors/loadMoreArticles';


    $.get(url, data, function(ret_data){
        ret_data = $.parseJSON(ret_data);

        //update the the load-mor propteries
        $this.data('page-id', ret_data.page_id);
        $this.data('auth-id', ret_data.auth_id);

        //prepend new templates to the load more element
        $more_articles.after(ret_data.template);
        if(ret_data.status == false){
            $this.hide(); //hide load-more button
        }
        else
            $this.find('img').hide(); //hide the loader img
    })
        return false;
})
</script>

