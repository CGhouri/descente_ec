<?php
add_filter( 'wpcf7_use_really_simple_captcha', '__return_true' );
add_action( 'rest_api_init',  function() {
  register_rest_field(
    'spot',        // post type
    'post_meta',   // rest-apiに追加するキー
    array(
      'get_callback'  => function(  $object, $field_name, $request  ) {
        // 出力したいカスタムフィールドのキーをここで定義
        $meta_fields = array(
          'views',
        );
        $meta = array();
        foreach ( $meta_fields as $field ) {
          // バリデーションを一切してないので注意
          $meta[ $field ] = get_post_meta( $object[ 'id' ], $field, true );
        }
        return $meta;
      },
      'update_callback' => null,
      'schema'          => null,
    )
  );
} );


//function my_add_meta_vars ($current_vars) {
//$current_vars = array_merge ($current_vars, array('meta_key', 'meta_value'));
//return $current_vars;
  //}
//add_filter ('query_vars', 'my_add_meta_vars');
//add_filter ('rest_query_vars', 'my_add_meta_vars');
// option設定追加
//if( function_exists('acf_add_options_page') ) {
  //共通META用
  //$option_page = acf_add_options_page(array(
    //'page_title'   => '共通META',
    //'menu_title'   => '共通META',
    //'menu_slug'   => 'meta-settings',
    //'capability'   => 'edit_posts',
    //'redirect'   => false
  //));
//}


/* 投稿機能から「タグ」を削除 */
function my_unregister_taxonomies()
{
  global $wp_taxonomies;
  if (!empty($wp_taxonomies['post_tag']->object_type)) {
    foreach ($wp_taxonomies['post_tag']->object_type as $i => $object_type) {
      if ($object_type == 'post') {
        unset($wp_taxonomies['post_tag']->object_type[$i]);
      }
    }
  }
  return true;
}
add_action('init', 'my_unregister_taxonomies');
function hide_category_tabs_adder() {
  global $pagenow;
  global $post_type;
  if ( is_admin() && ($pagenow=='post-new.php' || $pagenow=='post.php') ) {
    echo '<style type="text/css">
    #category-tabs, #category-adder {display:none;}
    #xxx-tabs, #xxx-adder {display:none;}

    .categorydiv .tabs-panel {padding: 0 !important; background: none; border: none !important;}
    </style>';
  }
}
add_action( 'admin_head', 'hide_category_tabs_adder' );


// アイキャッチ画像を有効にする。
add_theme_support('post-thumbnails');
add_image_size('thumbnail',360,220,true);
add_image_size('medium',630,340,true);
add_image_size('large',760,194,true);
/**
 * ACFの関連で公開の記事しか出さないように処理
 * @param $args　WP_Queryの引数。ACFの関連で使う引数情報が格納されている。
 * @param $field　カスタムフィールド名
 * @param $post_id　対象の記事ID
 * @return mixed
 */
function custom_acf_relationship($args, $field, $post_id){
  $args["post_status"] = "publish";
  return $args;
}
add_filter( 'acf/fields/relationship/query', 'custom_acf_relationship',10,3 );
/*カテゴリーチェック */
add_action( 'admin_head-post-new.php', 'default_taxonomy_select' );
function default_taxonomy_select() {
?>
<script type="text/javascript">
  jQuery(function($) {
    $('#categorychecklist li:first-child input[type="checkbox"]').prop('checked', true);
  });
</script>
<?php
}
// contact form 7 のファイルを必要な場合のみ読み込む
function wpcf7_file_control()
{
  add_filter("wpcf7_load_js", "__return_false");
  add_filter("wpcf7_load_css", "__return_false");

  if( is_page("contact") ){
    if( function_exists("wpcf7_enqueue_scripts") ) wpcf7_enqueue_scripts();
    if( function_exists("wpcf7_enqueue_styles") ) wpcf7_enqueue_styles();
  }
}
add_action("template_redirect", "wpcf7_file_control");
/*最上位ページスラッグ取得用 */
function ps_get_root_page( $cur_post, $cnt = 0 ) {
  if ( $cnt > 100 ) { return false; }
  $cnt++;
  if ( $cur_post->post_parent == 0 ) {
    $root_page = $cur_post;
  } else {
    $root_page = ps_get_root_page( get_post( $cur_post->post_parent ), $cnt );
  }
  return $root_page;
}
// ループの一番最後取得
function isLast(){
  global $wp_query;
  return ($wp_query->current_post+1 === $wp_query->post_count);
}
//パンくず//
function the_pankuzu( $args = array() ){
  global $post;
  $str ='';
  $defaults = array(
    'id' => "breadcrumbs",
    'class' => "clearfix",
    'home' => "TOP",
    'search' => "で検索した結果",
    'tag' => "タグ",
    'author' => "投稿者",
    'notfound' => "ページが存在しません",
    'separator' => ''
  );
  $args = wp_parse_args( $args, $defaults );
  extract( $args, EXTR_SKIP );
  if( is_home() ) {
    echo  '<ol itemscope itemtype="http://data-vocabulary.org/Breadcrumb">TOP<li></li></ol>';
  }
  if( !is_home() && !is_admin() ){
    $str.= '<ol itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
    $str.= '<li class="breadcrumb_top" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. home_url() .'/" itemprop="url"><span itemprop="title">TOP</span></a></li>';
    $my_taxonomy = get_query_var( 'taxonomy' );
    $cpt = get_query_var( 'post_type' );
    if( $my_taxonomy && is_tax( $my_taxonomy ) ) {
      $my_tax = get_queried_object();
      $post_types = get_taxonomy( $my_taxonomy )->object_type;
      $cpt = $post_types[0];
      if($cpt=='news'){
        $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/news/" itemprop="url"><span itemprop="title">'. get_post_type_object( $cpt )->label.'</span></a></li>';
      }else{
        $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' .get_post_type_archive_link( $cpt ).'" itemprop="url"><span itemprop="title">'. get_post_type_object( $cpt )->label.'</span></a></li>';
      }

      if( $my_tax -> parent != 0 ) {
        $ancestors = array_reverse( get_ancestors( $my_tax -> term_id, $my_tax->taxonomy ) );
        foreach( $ancestors as $ancestor ){
          $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_term_link( $ancestor, $my_tax->taxonomy ) .'" itemprop="url"><span itemprop="title">'. get_term( $ancestor, $my_tax->taxonomy )->name .'<a/span></a></li>';
        }
      }
      $str.='<li>'. $my_tax -> name . '</li>';
    }
    elseif( is_category() ) {
      $cat = get_queried_object();
      if( $cat -> parent != 0 ){
        $ancestors = array_reverse( get_ancestors( $cat -> cat_ID, 'category' ));
        foreach( $ancestors as $ancestor ){
          $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link( $ancestor ) .'" itemprop="url"><span itemprop="title">'. get_cat_name( $ancestor ) .'</span></a></li>';
        }
      }
      //$str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link( $ancestor ) .'" itemprop="url"><span itemprop="title">'. $cat -> name.'</span></a></li>';
      $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'. $cat -> name.'</span></li>';
    }
    elseif( is_post_type_archive() ) {
      $cpt = get_query_var( 'post_type' );
      $str.='<li>'. get_post_type_object( $cpt )->label . '</li>';
    }
    elseif( $cpt && is_singular( $cpt ) ){
      $taxes = get_object_taxonomies( $cpt );
      $mytax = $taxes[0];
      $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/' .get_post_type_object( $cpt )->name.'/" itemprop="url"><span itemprop="title">'. get_post_type_object( $cpt )->label.'</span></a></li>';
      $taxes = get_the_terms( $post->ID, $mytax );
      $tax = get_youngest_tax( $taxes, $mytax );
      if( $tax -> parent != 0 ){
        $ancestors = array_reverse( get_ancestors( $tax -> term_id, $mytax ) );
        foreach( $ancestors as $ancestor ){
          $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_term_link( $ancestor, $mytax ).'" itemprop="url"><span itemprop="title">'. get_term( $ancestor, $mytax )->name . '</span></a></li>';
        }
      }
      $str.= '<li>'. $post -> post_title .'</li>';
    }
    elseif( is_single() ){
      $categories = get_the_category( $post->ID );
      $cat = get_youngest_cat( $categories );
      if( $cat -> parent != 0 ){
        $ancestors = array_reverse( get_ancestors( $cat -> cat_ID, 'category' ) );
        foreach( $ancestors as $ancestor ){
          $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link( $ancestor ).'" itemprop="url"><span itemprop="title">'. get_cat_name( $ancestor ). '</span></a></li>';
        }
      }
      $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link( $cat -> term_id ). '" itemprop="url"><span itemprop="title">'. $cat-> cat_name . '</span></a></li>';
      //$str.= '<li><a href="'. get_the_permalink(). '" itemprop="url"><span itemprop="title">'. $post -> post_title .'</span></a></li>';
      $str.= '<li><span itemprop="title">'. $post -> post_title .'</span></li>';
    }
    elseif( is_page() ){
      if( $post -> post_parent != 0 ){
        $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
        foreach( $ancestors as $ancestor ){
          $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_permalink( $ancestor ).'" itemprop="url"><span itemprop="title">'. get_the_title( $ancestor ) .'</span></a></li>';
        }
      }
      $str.= '<li>'. $post -> post_title .'</li>';
    }
    elseif( is_date() ){
      if( get_query_var( 'day' ) != 0){
        $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_year_link(get_query_var('year')). '" itemprop="url"><span itemprop="title">' . get_query_var( 'year' ). '年</span></a></li>';
        $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_month_link(get_query_var( 'year' ), get_query_var( 'monthnum' ) ). '" itemprop="url"><span itemprop="title">'. get_query_var( 'monthnum' ) .'月</span></a></li>';
        $str.='<li>'. get_query_var('day'). '日</li>';
      }
      elseif( get_query_var('monthnum' ) != 0){
        $str.='<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_year_link( get_query_var('year') ) .'" itemprop="url"><span itemprop="title">'. get_query_var( 'year' ) .'年</span></a></li>';
        $str.='<li>'. get_query_var( 'monthnum' ). '月</li>';
      }
      else {
        $str.='<li>'. get_query_var( 'year' ) .'年</li>';
      }
    }
    elseif( is_search() ) {
      $str.='<li>「'. get_search_query() .'」'. $search .'</li>';
    }
    elseif( is_author() ){
      $str .='<li>'. $author .' : '. get_the_author_meta('display_name', get_query_var( 'author' )).'</li>';
    }
    elseif( is_tag() ){
      $str.='<li>'. $tag .' : '. single_tag_title( '' , false ). '</li>';
    }
    elseif( is_attachment() ){
      $str.= '<li>'. $post -> post_title .'</li>';
    }
    elseif( is_404() ){
      $str.='<li>'.$notfound.'</li>';
    }
    else{
      $str.='<li>'. wp_title( '', true ) .'</li>';
    }
    $str.='</ol>';
  }
  echo $str;
}
function get_youngest_cat( $categories ){
  global $post;
  if(count( $categories ) == 1 ){
    $youngest = $categories[0];
  }
  else{
    $count = 0;
    foreach( $categories as $category ){
      $children = get_term_children( $category -> term_id, 'category' );
      if($children){
        if ( $count < count( $children ) ){
          $count = count( $children );
          $lot_children = $children;
          foreach( $lot_children as $child ){
            if( in_category( $child, $post -> ID ) ){
              $youngest = get_category( $child );
            }
          }
        }
      }
      else{
        $youngest = $category;
      }
    }
  }
  return $youngest;
}
function get_youngest_tax( $taxes, $mytaxonomy ){
  global $post;
  if( is_array($taxes) && count( $taxes ) == 1 ){
    /*$youngest = $taxes[ key( $taxes )];*/
  }
  else{
    $count = 0;
    if($taxes){
      foreach( $taxes as $tax ){
        $children = get_term_children( $tax -> term_id, $mytaxonomy );
        if($children){
          if ( $count < count($children) ){
            $count = count($children);
            $lot_children = $children;
            foreach($lot_children as $child){
              if( is_object_in_term( $post -> ID, $mytaxonomy ) ){
                $youngest = get_term($child, $mytaxonomy);
              }
            }
          }
        }
        else{
          $youngest = $tax;
        }
      }

    }
  }
  return $youngest;
}
// ページナビ
/* $rangeの値で出力されるページナンバーの範囲を設定 */
function pagination($pages = '', $range = 2){
  $showitems = ($range * 2)+1;//表示するページ数（5ページを表示）
  global $paged;//現在のページ値
  if(empty($paged)) $paged = 1;//デフォルトのページ
  /* ここで全体のページ数を取得 */
  if($pages == ''){
    global $wp_query;
    $pages = $wp_query->max_num_pages;//全ページ数を取得
    if(!$pages){//全ページ数が空の場合は、1とする
      $pages = 1;
    }
  }
  /* ページ数が1じゃなければ */
  if(1 != $pages){
    echo "<div class=\"pagenation\"><ul>";
    /* 1つ前のページへボタン */
    if($paged > 1){//$paged > 1 && $showitems < $pages
      echo "<li class=\"prev\"><a href=\"".get_pagenum_link($paged - 1)."\"></a></li>";
    }
    /* 1番最初のページに戻るボタン */
    if($paged > 2 && $paged > $range+1 && $showitems < $pages){
      //if($paged > 2 && $paged > $range+1 && $showitems < $pages){
      //echo "<li class=\"pagerPrevAll\"><a href=\"".get_pagenum_link(1)."\">First</a></li>";
      echo "<li class=\"pagerPrevAll\"><a href=\"".get_pagenum_link(1)."\">1</a></li>";
    }
    /* ページ数が続くことを示す３点リーダー2 */
    if($paged > 2 && $paged > $range+1 && $showitems < $pages){
      //echo "<li class=\"dot\"><a href=\"".get_pagenum_link($paged + 1)."\">…</a></li>";
      echo "<li class=\"dot\">…</li>";
    }
    /* ページナンバーの出力。$pagedが一致した場合はcurrentを、一致しない場合はリンクを生成 */
    for ($i=1; $i <= $pages; $i++){
      if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
        echo ($paged == $i)? "<li class=\"current\"><span>".$i."</span></li>":"<li><a href=\"".get_pagenum_link($i)."\">".$i."</a></li>";
      }
    }
    /* ページ数が続くことを示す３点リーダー */
    if ($paged < $pages-1 &&  $paged+$range < $pages && $showitems < $pages){
      //if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages){
      //echo "<li class=\"dot\"><a href=\"".get_pagenum_link($paged + 1)."\">…</a></li>";
      echo "<li class=\"dot\">…</li>";
    }
    /* 最後のページへ進むボタン */
    if ($paged < $pages-1 &&  $paged+$range < $pages && $showitems < $pages){
      //if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages){
      echo "<li class=\"pagerNextAll\"><a href=\"".get_pagenum_link($pages)."\">".$pages."</a></li>";
    }
    /* 1つ次のページへボタン */
    if ($paged < $pages){//$paged < $pages && $showitems < $pages
      echo "<li class=\"next\"><a href=\"".get_pagenum_link($paged + 1)."\"></a></li>";
    }
    echo "</ul></div>";
  }
}

//「WordPress のご利用ありがとうございます。」を非表示
add_filter('admin_footer_text', 'custom_admin_footer');
function custom_admin_footer() {
}
//更新のお知らせを非表示
function wphidenag() {
 remove_action( 'admin_notices', 'update_nag');
}
//プラグイン更新のお知らせを非表示
add_action('admin_menu', 'remove_counts');
function remove_counts(){
 global $menu,$submenu;
 $menu[65][0] = 'プラグイン';
 $submenu['index.php'][10][0] = '更新';
}
add_action('admin_menu','wphidenag');
//管理画面バージョン非表示
function remove_footer_version() {
 remove_filter( 'update_footer', 'core_update_footer' );
}
add_action( 'admin_menu', 'remove_footer_version' );
// 管理バーにログアウトを追加
function add_new_item_in_admin_bar() {
 global $wp_admin_bar;
 $wp_admin_bar->add_menu(array(
  'id' => 'new_item_in_admin_bar',
  'title' => __('ログアウト'),
  'href' => wp_logout_url()
 ));
}
add_action('wp_before_admin_bar_render', 'add_new_item_in_admin_bar');
//ヘルプを消す
function disable_help_link() {
 echo '<style type="text/css">
        #wp-admin-bar-wp-logo {display: none !important;}
        </style>';
}
add_action('admin_head', 'disable_help_link');
// head整理
// generator
remove_action( 'wp_head','wp_generator');
// rel="shortlink"
remove_action( 'wp_head','wp_shortlink_wp_head',10, 0 );
// WLW(Windows Live Writer) wlwmanifest.xml
remove_action( 'wp_head','wlwmanifest_link');
// RSD xmlrpc.php?rsd
remove_action( 'wp_head','rsd_link');
function disable_load_opensans ( &$styles ) {
 $styles->remove( 'open-sans' );
 $styles->add( 'open-sans', null );
}
add_action( 'wp_default_styles', 'disable_load_opensans' );

// 投稿タイプの初期カテゴリー
function add_default_term_setting_item() {
  $post_types = get_post_types( array( 'public' => true, 'show_ui' => true ), false );
  if ( $post_types ) {
    foreach ( $post_types as $post_type_slug => $post_type ) {
      $post_type_taxonomies = get_object_taxonomies( $post_type_slug, false );
      if ( $post_type_taxonomies ) {
        foreach ( $post_type_taxonomies as $tax_slug => $taxonomy ) {
          if ( ! ( $post_type_slug == 'post' && $tax_slug == 'category' ) && $taxonomy->show_ui ) {
            add_settings_field( $post_type_slug . '_default_' . $tax_slug, $post_type->label . '用' . $taxonomy->label . 'の初期設定' , 'default_term_setting_field', 'writing', 'default', array( 'post_type' => $post_type_slug, 'taxonomy' => $taxonomy ) );
          }
        }
      }
    }
  }
}
add_action( 'load-options-writing.php', 'add_default_term_setting_item' );
function default_term_setting_field( $args ) {
  $option_name = $args['post_type'] . '_default_' . $args['taxonomy']->name;
  $default_term = get_option( $option_name );
  $terms = get_terms( $args['taxonomy']->name, 'hide_empty=0' );
  if ( $terms ) :
?>
<select name="<?php echo $option_name; ?>">
  <option value="0">設定しない</option>
  <?php foreach ( $terms as $term ) : ?>
  <option value="<?php echo esc_attr( $term->term_id ); ?>"<?php echo $term->term_id == $default_term ? ' selected="selected"' : ''; ?>><?php echo esc_html( $term->name ); ?></option>
  <?php endforeach; ?>
</select>
<?php
  else:
?>
<p><?php echo esc_html( $args['taxonomy']->label ); ?>が登録されていません。</p>
<?php
  endif;
}
function allow_default_term_setting( $whitelist_options ) {
  $post_types = get_post_types( array( 'public' => true, 'show_ui' => true ), false );
  if ( $post_types ) {
    foreach ( $post_types as $post_type_slug => $post_type ) {
      $post_type_taxonomies = get_object_taxonomies( $post_type_slug, false );
      if ( $post_type_taxonomies ) {
        foreach ( $post_type_taxonomies as $tax_slug => $taxonomy ) {
          if ( ! ( $post_type_slug == 'post' && $tax_slug == 'category' ) && $taxonomy->show_ui ) {
            $whitelist_options['writing'][] = $post_type_slug . '_default_' . $tax_slug;
          }
        }
      }
    }
  }
  return $whitelist_options;
}
add_filter( 'whitelist_options', 'allow_default_term_setting' );
function add_post_type_default_term( $post_id, $post ) {
  if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || $post->post_status == 'auto-draft' ) { return; }
  $taxonomies = get_object_taxonomies( $post, false );
  if ( $taxonomies ) {
    foreach ( $taxonomies as $tax_slug => $taxonomy ) {
      $default = get_option( $post->post_type . '_default_' . $tax_slug );
      if ( ! ( $post->post_type == 'post' && $tax_slug == 'category' ) && $taxonomy->show_ui && $default && ! ( $terms = get_the_terms( $post_id, $tax_slug ) ) ) {
        if ( $taxonomy->hierarchical ) {
          $term = get_term( $default, $tax_slug );
          if ( $term ) {
            wp_set_post_terms( $post_id, array_filter( array( $default ) ), $tax_slug );
          }
        } else {
          $term = get_term( $default, $tax_slug );
          if ( $term ) {
            wp_set_post_terms( $post_id, $term->name, $tax_slug );
          }
        }
      }
    }
  }
}
add_action( 'wp_insert_post', 'add_post_type_default_term', 10, 2 );

//特定の投稿タイプでGutenbergを無効化
//add_filter( 'use_block_editor_for_post_type', 'disable_gutenberg', 10, 2 );
//function disable_gutenberg( $use_block_editor, $post_type ) {
//if ( $post_type === 'feature' ) return false;
//return $use_block_editor;
//}


// ビジュアルエディタ1行目のボタン削除
function remove_tinymce_buttons( $buttons ) {
  // 削除するボタンを指定
  $remove = array(
    //'formatselect', // 段落
    //      'bold',         // 太字
    //'italic',       // イタリック
    //'bullist',      // 番号なしリスト
    //'numlist',      // 番号付きリスト
    //'blockquote',   // 引用
    //'alignleft',    // 左寄せ
    //'aligncenter',  // 中央揃え
    //'alignright',   // 右寄せ
    //'link',         // リンクの挿入/編集
    'wp_more',      // 「続きを読む」タグを挿入
    //'spellchecker', // ？
    //'dfw',          // 集中執筆モード
    //'wp_adv',       // ツールバー切り替え
  );
  // 指定したボタンを削除
  $buttons = array_diff( $buttons, $remove );
  return $buttons;
}
add_filter( 'mce_buttons', 'remove_tinymce_buttons' );
// ビジュアルエディタ2行目のボタン削除
function remove_tinymce_buttons_2( $buttons ) {
  // 削除するボタンを指定
  $remove = array(
    //'strikethrough', // 打ち消し
    //'hr',            // 横ライン
    //      'forecolor',     // テキスト色
    //'pastetext',     // テキストとしてペースト
    //'removeformat',  // 書式設定をクリア
    //'charmap',       // 特殊文字
    //'outdent',       // インデントを減らす
    //'indent',        // インデントを増やす
    //'undo',          // 取り消し
    //'redo',          // やり直し
    'wp_help'        // キーボードショートカット
  );
  // 指定したボタンを削除
  $buttons = array_diff( $buttons, $remove );
  return $buttons;
}
add_filter( 'mce_buttons_2', 'remove_tinymce_buttons_2' );

// テキストディタのボタン削除
function remove_html_editor_buttons( $qt_init ) {
  // 削除するボタンを指定
  $remove = array(
    //      'strong', // b
    //'em',     // i
    //'link',   // link
    //'block',  // b-quote
    //'del',    // del
    //'ins',    // ins
    //'img',    // img
    //'ul',     // ul
    //'ol',     // ol
    //'li',     // li
    //'code',   // code
    'more',   // more
    //'close',  // タグを閉じる
    //'dfw',    // 集中執筆モード
  );
  // ボタンの一覧を文字列から配列に分割
  $qt_init['buttons'] = explode( ',', $qt_init['buttons'] );
  // 指定したボタンを削除
  $qt_init['buttons'] = array_diff( $qt_init['buttons'], $remove );
  // 配列から文字列に連結
  $qt_init['buttons'] = implode( ',', $qt_init['buttons'] );
  return $qt_init;
}
add_filter( 'quicktags_settings', 'remove_html_editor_buttons' );
