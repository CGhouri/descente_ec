<?php
get_header();
?>
<body id="feature" class="lower detail">
  <div id="wrapper">
    <?php
    get_template_part('inc','header');
    ?>
    <div id="main_area" role="main">
      <div id="article_detail">
        <div class="article_width">
          <div class="article_ttl">
            <h1><?php the_title(); ?></h1>
            <p class="date"><?php the_time('Y/m/d'); ?></p>
          </div><!-- .article_ttl -->
          <div class="sns_wrap">
            <div class="article_content">
              <?php
              //柔軟フィールド出力
              if( have_rows('module') ):
              while(have_rows('module')): the_row();
              // 画像（大）+テキスト ここから
              if( get_row_layout() == 'module01' ):
              $imgtxt_img = get_sub_field('imgtxt_img');
              ?>
              <div class="mod_cont">
                <div class="imgtxt_cont">
                  <div class="imgtxt_set">
                    <?php
                    if ( get_sub_field('imgtxt_img') ): ?>
                    <div class="img_box">
                      <img src="<?php echo $imgtxt_img['url'];?>" width="270" height="140" alt="">
                    </div><!-- .img_box -->
                    <?php endif; ?>
                    <?php
                    if ( get_sub_field('imgtxt_txt') ): ?>
                    <div class="txt_box">
                      <div class="editor">
                        <p><?php the_sub_field('imgtxt_txt'); ?></p>
                      </div><!-- .editor -->
                    </div><!-- .txt_box -->
                    <?php endif; ?>
                  </div><!-- .imgtxt_set -->
                </div><!-- .imgtxt_cont -->
              </div><!-- .mod_cont -->
              <?php
              endif;
              // 画像（大）+テキスト ここまで
              // 画像（中）センター ここから
              if( get_row_layout() == 'module02' ):
              ?>
              <div class="mod_cont">
                <div class="img_cont center">
                  <?php
                  while( have_rows('imgcenter') ):the_row();
                  $imgcenter_img = get_sub_field('imgcenter_img');
                  ?>
                  <div class="img_set">
                    <img src="<?php echo $imgcenter_img['url'];?>" width="270" height="140" alt="">
                  </div><!-- .img_set -->
                  <?php endwhile;?>
                </div><!-- .img_cont -->
              </div><!-- .mod_cont -->
              <?php
              endif;
              // 画像（中）センター ここまで
              // 画像（小）2カラム ここから
              if( get_row_layout() == 'module03' ):
              ?>
              <div class="mod_cont">
                <div class="img_cont img2">
                  <?php
                  while( have_rows('img2col') ):the_row();
                  $img2col_img = get_sub_field('img2col_img');
                  ?>
                  <div class="img_set">
                    <img src="<?php echo $img2col_img['url'];?>" width="270" height="140" alt="">
                  </div><!-- .img_set -->
                  <?php endwhile;?>
                </div><!-- .img_cont -->
              </div><!-- .mod_cont -->
              <?php
              endif;
              // 画像（小）2カラム ここまで
              // テキスト ここから
              if( get_row_layout() == 'module04' ):
              ?>
              <div class="mod_cont">
                <div class="editor">
                  <p><?php the_sub_field('txt_w100'); ?></p>
                </div><!-- .editor -->
              </div><!-- .mod_cont -->
              <?php
              endif;
              // テキスト ここまで
              // 質問・回答テキスト ここから
              if( get_row_layout() == 'module05' ):
              ?>
              <div class="mod_cont">
                <div class="qa_cont">
                  <?php
                  while( have_rows('qa_txt') ):the_row();
                  //$qa_txt_q = get_sub_field('qa_txt_q');
                  //$qa_txt_a = get_sub_field('qa_txt_a');
                  ?>
                  <div>
                    <dt><?php the_sub_field('qa_txt_q'); ?></dt>
                    <dd><?php the_sub_field('qa_txt_a'); ?></dd>
                  </div>
                  <?php endwhile;?>
                </div><!-- .qa_cont -->
              </div><!-- .mod_cont -->
              <?php
              endif;
              // 質問・回答テキスト ここまで
              // ユーチューブ ここから
              if( get_row_layout() == 'module06' ):
              $youtube_code = get_sub_field('youtube_code');
              ?>
              <div class="mod_cont">
                <div class="yt_cont">
                  <div class="youtube">
                    <?php the_sub_field('youtube_code'); ?>
                  </div><!-- .youtube -->
                </div><!-- .yt_cont -->
              </div><!-- .mod_cont -->
              <?php
              endif;
              // ユーチューブ ここまで
              // インスタグラム ここから
              if( get_row_layout() == 'module07' ):
              $insta_code = get_sub_field('insta_code');
              ?>
              <div class="mod_cont">
                <div class="insta_cont">
                  <?php the_sub_field('insta_code'); ?>
                </div><!-- .insta_cont -->
              </div><!-- .mod_cont -->
              <?php
              endif;
              // インスタグラム ここまで
              // レコメンドリスト ここから
              if( get_row_layout() == 'module08' ):
              ?>
              <div class="mod_cont">
                <div class="recommend_list">
                  <div class="none_slider">
                    <?php
                    while( have_rows('recommend_list') ):the_row();
                    $recommend_list_img = get_sub_field('recommend_list_img');
                    $recommend_list_brand = get_sub_field('recommend_list_brand');
                    $recommend_list_name = get_sub_field('recommend_list_name');
                    $recommend_list_price = get_sub_field('recommend_list_price');
                    $recommend_list_color = get_sub_field('recommend_list_color');
                    $recommend_list_link = get_sub_field('recommend_list_link');
                    ?>
                    <div class="item">
                      <a href="<?php echo $recommend_list_link; ?>">
                        <div class="item_inner">
                          <?php
                          if ( get_sub_field('recommend_list_img') ): ?>
                          <div class="img_box">
                            <img src="<?php echo $recommend_list_img['url'];?>" width="188" height="188" alt="">
                          </div><!-- .img_box -->
                          <?php endif; ?>
                          <div class="txt_box">
                            <?php
                            if ( get_sub_field('recommend_list_brand') ): ?>
                            <p class="brand"><?php the_sub_field('recommend_list_brand'); ?></p>
                            <?php endif; ?>
                            <?php
                            if ( get_sub_field('recommend_list_name') ): ?>
                            <h3 class="name ellipsis_ttl"><?php the_sub_field('recommend_list_name'); ?></h3>
                            <?php endif; ?>
                            <?php
                            if ( get_sub_field('recommend_list_price') ):
                            $recommend_list_price_status = get_sub_field('recommend_list_price_status');
                            if($recommend_list_price_status=='セール'){
                              $price_staClass = ' sale';
                            }else{
                              $price_staClass = '';
                            }
                            ?>
                            <p class="price<?php echo $price_staClass;?>"><?php the_sub_field('recommend_list_price'); ?></p>
                            <?php endif; ?>
                            <?php
                            if ( get_sub_field('recommend_list_color') ): ?>
                            <p class="color"><?php the_sub_field('recommend_list_color'); ?></p>
                            <?php endif; ?>
                          </div><!-- .txt_box -->
                        </div><!-- .item_inner -->
                      </a>
                    </div><!-- .item -->
                    <?php endwhile;?>
                  </div><!-- .none_slider -->
                </div><!-- .recommend_list -->
              </div><!-- .mod_cont -->
              <?php
              endif;
              // レコメンドリスト ここまで
              // ボタンリンク ここから
              if( get_row_layout() == 'module09' ):
              $btn_txt = get_sub_field('btn_txt');
              $btn_link = get_sub_field('btn_link');
              ?>
              <div class="mod_cont">
                <div class="btn">
                  <a href="<?php echo $btn_link; ?>"><?php the_sub_field('btn_txt'); ?></a>
                </div><!-- .btn -->
              </div><!-- .mod_cont -->
              <?php
              endif;
              // ボタンリンク ここまで
              // エディター ここから
              if( get_row_layout() == 'module10' ):
              $editor = get_sub_field('editor');
              ?>
              <div class="mod_cont">
                <div class="editor">
                  <?php echo $editor;?>
                </div><!-- .editor -->
              </div><!-- .mod_cont -->
              <?php
              endif;
              // エディター ここまで
              // LP移設用 ここから
              if( get_row_layout() == 'module11' ):
              $lp_js = get_sub_field('lp_js');
              $lp_css = get_sub_field('lp_css');
              $lp_html = get_sub_field('lp_html');
              ?>
              <?php
              if ( get_sub_field('lp_js') ): ?>
              <?php echo $lp_js;?>
              <?php endif; ?>
              <?php
              if ( get_sub_field('lp_css') ): ?>
              <?php echo $lp_css;?>
              <?php endif; ?>
              <div class="landing lqgspr">
                <?php echo $lp_html;?>
              </div><!-- .landing -->
              <?php
              endif;
              // LP移設用 ここまで
              endwhile;
              endif;
              ?>
            </div><!-- .article_content -->
            <div class="return_btn">
              <div class="btn">
                <a href="../">特集一覧へ戻る</a>
              </div><!-- .btn -->
            </div><!-- .return_btn -->
            <div class="share_block">
              <ul>
                <li class="fb"><a href="" target="_blank"><span>facebookでシェア</span></a></li>
                <li class="tw"><a href="" target="_blank"><span>twitterでシェア</span></a></li>
                <li class="line"><a href="" target="_blank"><span>LINEでシェア</span></a></li>
                <li class="mail"><a href="" target="_blank"><span>メールでシェア</span></a></li>
              </ul>
            </div><!-- .share_block -->
          </div><!-- .sns_wrap -->
        </div><!-- .article_width -->
      </div><!-- #article_detail -->
      <div id="btm_list">
        <div class="cont_ttl">
          <h2 class="ttl">
            <span class="ja">特集／新着記事</span>
            <span class="en">SPECIAL FEATURE / NEW NOTES</span>
          </h2><!-- .ttl -->
        </div><!-- .cont_ttl -->
        <?php
        //$paged = get_query_var('paged') ? get_query_var('paged') : 1 ;
        $wp_query = new WP_Query();
        $param = array(
          'posts_per_page' => 4,//-1// 表示件数
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
        //$max_page = $wp_query->max_num_pages;
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
        wp_reset_query();
        ?>
      </div><!-- #btm_list -->
    </div><!-- main_area -->
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
  <script>
    $(function(){
      //シェアボタン
      var href = location.href;
      var getTitle = $('h1').text();
      var snsUrl = encodeURIComponent(href);
      var snsTitle = encodeURIComponent(getTitle);
      $('.share_block ul li').each(function() {
        var sns_obj = $(this).attr('class');
        var snsCase = sns_obj;
        switch (snsCase) {
          case 'fb':
            $(this).find('a').attr('href', 'http://www.facebook.com/sharer.php?u=' + snsUrl);
            break;
          case 'tw':
            $(this).find('a').attr('href', 'http://twitter.com/share?text=' + snsTitle + '&url=' + snsUrl);
            break;
          case 'line':
            $(this).find('a').attr('href', 'http://line.me/R/msg/text/?'+snsTitle+'%0a'+ snsUrl);
            break;
          case 'mail':
            $(this).find('a').attr('href', 'mailto:?body=' + snsTitle + '%0D%0A' + snsUrl);
            break;
        }
      });
    });//end
  </script>
</body>
</html>
