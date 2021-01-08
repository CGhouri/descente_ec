<?php
/* Template Name: 特集 */
get_header();
?>
<body id="feature" class="lower">
  <div id="wrapper">
    <?php
    get_template_part('inc','header');
    ?>
    <div id="main_area" role="main">
      <div id="low_ttl">
        <div class="main_width">
          <div class="page_ttl">
            <h1 class="ttl">特集</h1>
          </div><!-- .page_ttl -->
        </div><!-- .main_width -->
      </div><!-- #low_ttl -->
      <?php
      if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
      elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
      else { $paged = 1; }
      $paged = get_query_var('paged') ? get_query_var('paged') : 1 ;
      // クエリの定義
      $wp_query = new WP_Query();
      // 条件の設定
      $param = array(
        'posts_per_page' => 12,//-1// 表示件数  2
        'post_type' => 'feature',//カスタム投稿タイプ名
        'post_status' => 'publish',//公開状態
        'paged'=> $paged,//ページネーションに必要
        'meta_query' => [
          [
            'key' => 'feature_list_display',
            'value' => '1',
            'compare' => '='//一致したら表示
          ],
        ],
      );
      $wp_query->query($param);
      $max_page = $wp_query->max_num_pages;
      // ループ
      if($wp_query->have_posts()):
      ?>
      <div class="article_list">
        <div class="main_width">
          <div class="none_slider">
            <?php
            while($wp_query->have_posts()) : $wp_query->the_post();
            ?>
            <?php $feature_list_img = get_field('feature_list_img');?>
            <div class="set">
              <a href="<?php the_permalink(); ?>">
                <div class="set_inner">
                  <div class="img_box">
                    <img src="<?php echo $feature_list_img;?>" width="270" height="140" alt="">
                  </div><!-- .img_box -->
                  <div class="txt_box">
                    <h3 class="ellipsis_ttl"><?php the_title(); ?></h3>
                    <p class="date"><?php the_time('Y/m/d'); ?></p>
                  </div><!-- .txt_box -->
                </div><!-- .set_inner -->
              </a>
            </div><!-- .set -->
            <?php endwhile;?>
          </div><!-- .none_slider -->
        </div><!-- .main_width -->
      </div><!-- .article_list -->
      <?php
      endif;
      // 投稿データのリセット
      //wp_reset_query();
      ?>
      <!-- .pagenation<div class="pagenation">
<div class="main_width">
<ul>
<li class="prev"><a href="#"></a></li>
<li class="current"><a href="#">1</a></li>
<li><a href="#">2</a></li>
<li><a href="#">3</a></li>
<li class="dot"><a href="#">…</a></li>
<li class="max"><a href="#">50</a></li>
<li class="next"><a href="#"></a></li>
</ul>
</div>
</div> -->
      <?php
      if (function_exists("pagination")) {
        pagination();
      } ?>
      <?php
      // 投稿データのリセット
      wp_reset_postdata();
      ?>
    </div><!-- main_area -->
    <!-- bread <div id="bread">
<div class="main_width">
<ol class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/descente/"><span itemprop="name">TOP</span></a><meta itemprop="position" content="1" /></li>
<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">特集</span><meta itemprop="position" content="2"></li>
</ol>
</div>
</div>-->
    <div id="bread">
      <div class="main_width">
        <?php the_pankuzu();?>
      </div><!-- .main_width -->
    </div><!-- bread -->
    <?php
    get_template_part('inc','sp');
    get_template_part('inc','footer');
    ?>
  </div><!-- wrapper -->
  <?php
  get_footer();
  ?>
</body>
</html>
