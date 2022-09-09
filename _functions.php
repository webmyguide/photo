<?php
/*-------------------------------------------*/
/*  Theme setup
/*-------------------------------------------*/
if ( ! function_exists( 'templ_theme_setup' ) ) :
function templ_theme_setup() {
    /*-------------------------------------------*/
    /*  manage the document title
    /*-------------------------------------------*/
    add_theme_support( 'title-tag' );
    add_filter( 'pre_get_document_title', 'my_pre_get_document_title' );
    function my_pre_get_document_title( $title ) {
      if ( is_search() ) {
        $title = '診断結果一覧';
      }
      return $title;
    }
    /*-------------------------------------------*/
    /*  support for Post Thumbnails
    /*-------------------------------------------*/
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 950, 9999 );
    /*-------------------------------------------*/
    /*  This theme uses wp_nav_menu() in two locations
    /*-------------------------------------------*/
    register_nav_menus( array(
        'foot_menu'  => 'Footer Menu'
    ) );
    /*-------------------------------------------*/
    /*  content width
    /*-------------------------------------------*/
    if ( !isset( $content_width ) ){
        $content_width = 950;
    }
    /*-------------------------------------------*/
    /*  Load css JS
    /*-------------------------------------------*/
    function templ_add_script() {
			wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css', false );
			wp_enqueue_style( 'style', get_template_directory_uri() . '/css/style.css', false );

      // 共通 js
      wp_enqueue_script('jquery', '', '', '', true);
      wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '', true );

      if( is_front_page() ){
        wp_enqueue_script( 'matchHeight-js', get_template_directory_uri() . '/js/jquery.matchHeight-min.js', array( 'jquery' ), '', true );
      }
    } // end templ_add_script
    add_action('wp_enqueue_scripts','templ_add_script');
}
endif;
add_action( 'after_setup_theme', 'templ_theme_setup' );

/*-------------------------------------------*/
/*	　案件 カスタム投稿タイプ 追加
/*-------------------------------------------*/
function ppc_product_post_type() {
register_post_type(
	'product',
	array(
		'label' => '案件',
		'hierarchical' => false,
		'public' => false,
		'show_ui' => true,
		'query_var' => false,
		'has_archive' => true,
		'menu_position' => 5,
		'query_var' => true,
		'rewrite' =>
				array( 'slug' => 'product' ),
				array( 'with_front' => true, ),
        'show_in_nav_menus' => false,
				'supports' => array(
					'title',
					'editor',
					'thumbnail',
					'custom-fields',
					'page-attributes'
				)
	)
);
/*-------------------------------------------*/
/*	　案件 カスタムタクソノミー 追加
/*-------------------------------------------*/
// 一都三県パラメータ
register_taxonomy(
	'kantou',
	'product',
	array(
		'label' => '関東案件出し分け',
		'rewrite' => array( 'slug' => 'kantou' ),
		'hierarchical' => true
	)
);
// 業種パラメータ
register_taxonomy(
	'job',
	'product',
	array(
		'label' => '業種別出し分け',
		'rewrite' => array( 'slug' => 'job' ),
		'hierarchical' => true
	)
);
// 年齢パラメータ
// register_taxonomy(
// 	'old',
// 	'product',
// 	array(
// 		'label' => '年齢別出し分け',
// 		'rewrite' => array( 'slug' => 'old' ),
// 		'hierarchical' => true
// 	)
// );

}
add_action( 'init', 'ppc_product_post_type' );

/*-------------------------------------------*/
/*	　リダイレクトを無効
/*-------------------------------------------*/
function disable_redirect_canonical( $redirect_url ) {
  if( is_404() ) {
    return false;
  }
  return $redirect_url;
}
add_filter( 'redirect_canonical', 'disable_redirect_canonical' );

//--------------------------------------------------------------------------------------------------
// 並べ替え検索結果表示
//--------------------------------------------------------------------------------------------------
add_action( 'wp_head', 'sh_show_json_price' );
function sh_show_json_price() {
  if( !is_search() ){ return; }
?>
    
<?php }
add_action( 'wp_ajax_sh_get_json_price', 'sh_get_json_price' );
add_action( 'wp_ajax_nopriv_sh_get_json_price', 'sh_get_json_price' );

// パラメータ案件記事 取得
function sh_get_json_price() {
  global $post;
  $order_date = $_POST['order_date'];
  $age = $_POST['age'];
  $sex = $_POST['sex'];
  $university = $_POST['university'];
  $income = $_POST['income'];
  $job_it = $_POST['job_it'];

  // url パラメータ
  // 一都三県
  $tenshoku_city = $_POST['tenshoku_city'];
  if( !empty( $tenshoku_city ) ){
  	$tenshoku_city = 'metropolitan';
  }
  // 職種別
  $tenshoku_job = $_POST['tenshoku_job'];
  if( $tenshoku_job == it ){
  	$job_it = 1;
  	$tenshoku_job = '';
  }

  $args = array(
    'posts_per_page' => -1,
    'post_type' => 'product',
    'meta_query' => array(
     'relation' => 'AND',
       array(
         'key' => 'age',
         'value' => '"'.$age.'"',
         'compare' => 'LIKE',
       ),
       array(
         'key' => 'sex',
         'value' => '"'.$sex.'"',
         'compare' => 'LIKE',
       ),
       array(
         'key' => 'university',
         'value' => '"'.$university.'"',
         'compare' => 'LIKE',
       ),
       array(
         'key' => 'income',
         'value' => '"'.$income.'"',
         'compare' => 'LIKE',
       ),
       array(
         'key' => 'job_it',
         'value' => $job_it,
         'compare' => 'LIKE',
       )
    ),
  );
  // 出し分けパラメータがあった場合
  if( !empty( $tenshoku_city ) && !empty( $tenshoku_job ) ){
    $relation = 'AND';
  } else if( !empty( $tenshoku_city ) || !empty( $tenshoku_job ) ){
    $relation = 'or';
  }
  if( !empty( $tenshoku_city ) || !empty( $tenshoku_job ) ){
    $args['tax_query'] = array(
      'relation' => $relation,
          array(
            'taxonomy' => 'kantou',
            'field' => 'slug',
            'terms' => array( $tenshoku_city ),
            'operator' => 'IN',
          ),
          array(
            'taxonomy' => 'job',
            'field' => 'slug',
            'terms' => array( $tenshoku_job ),
            'operator' => 'IN',
          ),
    );
  }

  $query = new WP_Query( $args );
  $post_ids = [];
  if ( $query->have_posts() ): while ( $query->have_posts() ) : $query->the_post();
    $post_ids[] = array(
      $post->ID,
      get_post_meta( $post->ID , $order_date , true )
    );
  endwhile;
  endif;
  wp_reset_postdata();

  // 並び替え
  if( !empty( $post_ids ) ){
    $sort = [];
    foreach ( (array) $post_ids as $key => $value ) {
      $sort[$key] = $value[1];
    }
    array_multisort( $sort, SORT_ASC, $post_ids );

    // テスト
    // foreach ($post_ids as $post_id) {
    //   var_dump( $post_id[0] );
    // }

    $after_sort_ids = [];
    foreach ( $post_ids as $post_id ) {
      $after_sort_ids[] = $post_id[0];
    }

    // echo '<br><br>並び替え後 ID<br>↓<br>';
    // var_dump( $after_sort_ids );

    // 並び替え後 記事表示
    $after_sort_ids = array_reverse( $after_sort_ids );
    $args = array(
      'post_type'   => 'product',
      'post_status' => 'publish',
      'post__in'    => $after_sort_ids,
      'orderby' => 'post__in',
      'posts_per_page' => -1,
    );
    $query = new WP_Query( $args );
    $cont = 1;
    if ( $query->have_posts() ): while ( $query->have_posts() ) : $query->the_post(); ?>
    <div class="job_site_item">
      <?php
        $custom_fields = get_post_custom();
        if( !empty( $custom_fields ) ){
          // 見出し
          $title = $custom_fields["case_title"][0];
          // リンク先
          $link = $custom_fields["case_link"][0];
          // 特徴
          $feature = $custom_fields["case_feature"][0];
          // 特におすすめの層
          $recommend = $custom_fields["case_recommend"][0];
          // 一緒に登録したいサイト
          $together = $custom_fields["case_together"][0];
          // フリーテキスト
          $freetxt = $custom_fields["case_freetxt"][0];
          // 求人数
          $number = $custom_fields["case_number"][0];
          // 非公開求人数
          $number_private = $custom_fields["case_number_private"][0];
          // 当サイトから登録した人数
          $registered = $custom_fields["case_number_registered"][0];
        }

        // ランキングクラス
        $ranking_html = "";
        if( $cont == 1 ){
          $ranking_html = '<span class="ranking_no1"></span>';
        } elseif( $cont == 2 ){
          $ranking_html = '<span class="ranking_no2"></span>';
        } elseif( $cont == 3 ){
          $ranking_html = '<span class="ranking_no3"></span>';
        } else {
          $no_ranking = ' no_ranking';
        }
      ?>
      <h2 class="sec_title<?php echo( !empty( $no_ranking ) )? $no_ranking: '' ?>">
        <?php
        echo ( !empty( $ranking_html ) )? $ranking_html : '';
        if( !empty( $title ) ){
          echo nl2br( esc_html( $title ) );
        } else {
          echo esc_html( get_the_title() );
        }
        ?>
      </h2>
      <div class="row">
        <div class="col-md-4 sec_thumb">
          <p class="caption">
            <a href="<?php echo esc_attr( $link );  ?>" target="_blank"><?php echo esc_html( get_the_title() ); ?></a>
          </p>
          <?php if( has_post_thumbnail() ) { ?>
            <a href="<?php echo esc_attr( $link );  ?>" target="_blank">
              <?php	the_post_thumbnail(); ?>
            </a>
          <?php } ?>
        </div><!-- sec_thumb -->
        <div class="col-md-8 sec_body">
          <?php if( !empty( $feature ) || !empty( $recommend ) ){ ?>
          <ul class="feature_list">
            <?php if( !empty( $feature ) ){ ?>
              <li class="feature_list_item">
                <span class="glyphicon glyphicon-ok"></span>
                <span class="txt_marker_orange"><?php echo esc_html( $feature ); ?></span>
              </li>
            <?php } ?>
            <?php if( !empty( $recommend ) ){ ?>
              <li class="feature_list_item">
                <span class="glyphicon glyphicon-ok"></span>
                <span class="txt_marker_orange"><?php echo esc_html( $recommend ); ?></span>の方に特におススメです。</li>
            <?php } ?>
          </ul>
          <?php } ?>

          <?php if( !empty( $freetxt ) ) { ?>
          <p class="sec_txt"><?php echo nl2br( esc_html( $freetxt ) ); ?></p>
          <?php } ?>

          <table class="table table-hover">
            <?php if( !empty( $together ) ) { ?>
            <tr>
              <th>一緒に登録したいサイト</th>
              <td><?php echo esc_html( $together ); ?></td>
            </tr>
            <?php } ?>

            <?php if( !empty( $number ) ) { ?>
            <tr>
              <th>公開求人数</th>
              <td><?php echo esc_html( $number ); ?></td>
            </tr>
            <?php } ?>

            <?php if( !empty( $number_private ) ) { ?>
            <tr>
              <th>非公開求人数</th>
              <td><?php echo esc_html( $number_private ); ?></td>
            </tr>
            <?php } ?>

            <?php if( !empty( $registered ) ) { ?>
            <tr>
              <th>当サイトから登録した人数</th>
              <td><?php echo esc_html( $registered ); ?></td>
            </tr>
            <?php } ?>
          </table>
          <div class="link_botton_wrap">
            <a href="<?php echo esc_attr( $link );  ?>" class="btn btn-block btn-primary btn-lg">公式サイトを見る<span class="glyphicon glyphicon-menu-right"></span></a>
          </div>
        </div><!-- /.sec_body -->
      </div><!-- /.row -->

    </div><!-- /.job_site_item -->
    <?php
    $cont++;
    endwhile;
    endif;
    wp_reset_postdata();
  } // end !empty( $post_ids )
  else {
    echo '<p class="no_result">表示できるサイトがありません。</p>';
  }
}

/*-------------------------------------------*/
/*	　リンクにパラメーターを引き継がせる
/*-------------------------------------------*/
function add_parameter(){
$url = 'https://' . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
$url_array = parse_url($url);
$url_query = '?' . $url_array['query'];
return  $url_query;
}
add_shortcode('parameter', 'add_parameter');

// パラメータをcookieに保存
add_action( 'init', 'gclid_setcookie' );
function gclid_setcookie() {
  // gclid cookie保存
  if ( isset( $_GET['gclid'] ) ) {
    setcookie( 'gclid_cookie', $_GET['gclid'], time() + 3600*24*90, '/' );
  }
  // 一都三県 cookie保存
  if ( isset( $_GET['city'] ) ) {
    setcookie( 'city_cookie', $_GET['city'], time() + 3600*24*90, '/' );
  }
  // 業種パラメータ cookie保存
  if ( isset( $_GET['t_job'] ) ) {
    setcookie( 't_job_cookie', $_GET['t_job'], time() + 3600*24*90, '/' );
  }
  // 年齢パラメータ cookie保存
  if ( isset( $_GET['t_old'] ) ) {
    setcookie( 't_old_cookie', $_GET['t_old'], time() + 3600*24*90, '/' );
  }
  // 性別パラメータ cookie保存
  if ( isset( $_GET['t_sex'] ) ) {
    setcookie( 't_sex_cookie', $_GET['t_sex'], time() + 3600*24*90, '/' );
  }
}

/*-------------------------------------------*/
/*	　パラメータ設定
/*-------------------------------------------*/
function sec_title_kw_change( $param ){
  $kw_list = array(
    'a01-01' => '中途採用におすすめの転職サイト',
    'a01-02' => '求職者におすすめの転職サイト',
    'a01-03' => 'おすすめの求人サイト',
    'a01-04' => 'あなたに合った仕事探しができる転職サイト',
    'a01-05' => 'あなたに合った職探しができる転職サイト',
    'a01-06' => '再就職におすすめの転職サイト',
    'a01-07' => 'フリーター転職におすすめの転職サイト',
    'a01-08' => 'おすすめの転職サイト',
    'a02-01' => '登録必須の転職サイト',
    'a02-02' => '口コミの良い転職サイト',
    'a02-03' => 'おすすめの転職サイトの選び方',
    'a02-04' => 'おすすめの求人・就職サイト',
    'a02-05' => 'おすすめの転職サイトを比較',
    'a02-06' => 'おすすめの転職・求人支援サイト',
    'a02-07' => 'おすすめの転職サイト',
    'a02-08' => 'おすすめのスカウト転職サイト',
    'a02-09' => '評判の転職サイト',
    'a02-10' => 'おすすめの転職サイト',
    'a02-11' => '転職サイトランキング',
    'a02-12' => '仕事探しにおすすめの転職サイト',
    'a02-13' => '複数登録必須の転職サイト',
    'a02-14' => '人気の転職サイトを探す',
    'a02-15' => '未経験者におすすめの転職サイト',
    'a03-01' => 'おすすめの転職エージェントを比較',
    'a03-02' => '求職者におすすめの転職エージェント',
    'a03-03' => '口コミの良い転職エージェント',
    'a03-04' => '転職エージェントランキング',
    'a03-05' => 'おすすめの転職エージェント',
    'a03-06' => '人気の転職エージェント',
    'a03-07' => '登録必須の転職エージェント',
    'a03-08' => 'おすすめの転職エージェント',
    'a03-09' => '転職エージェントの賢い選び方',
    'a03-10' => 'おすすめの転職エージェント',
    'a03-11' => 'おすすめの転職エージェント',
    'a03-12' => '評判の良い転職エージェント',
    'a03-13' => '未経験業界に得意な転職エージェント',
    'a03-14' => '複数登録必須の転職エージェント',
    'a04-01' => '女性の再就職におすすめの転職サイト',
    'a04-02' => '女性におすすめの求人サイト',
    'a04-03' => '女性の仕事探しにおすすめの転職サイト',
    'a04-04' => '女性におすすめの転職サイト',
    'a04-05' => '女性の中途採用に強い転職サイト',
    'a05-01' => '第二新卒におすすめの転職サイト',
    'a05-02' => '第二新卒におすすめの求人サイト',
    'a05-03' => '第二新卒におすすめの転職エージェント',
    'a05-04' => '第二新卒におすすめの転職サイト',
    'a05-05' => '第二新卒の就活におすすめの転職サイト',
    'a05-06' => '第二新卒におすすめの転職サイト',
    'a06-01' => '未経験におすすめの転職サイト',
    'a06-02' => '未経験におすすめの求人サイト',
    'a06-03' => '未経験の就活におすすめの転職サイト',
    'a06-04' => '未経験におすすめの転職サイト',
    'a06-05' => '未経験におすすめの転職エージェント',
    'b01-01' => '23-25歳におすすめの転職サイト',
    'b01-02' => '23-25歳のフリーターにおすすめの求人サイト',
    'b01-03' => '23-25歳におすすめの転職サイト',
    'b01-04' => '23-25歳の仕事探しにおすすめの転職サイト',
    'b01-05' => '23-25歳女性の就職におすすめの求人サイト',
    'b01-06' => '23-25歳女性におすすめの求人サイト',
    'b01-07' => '23-25歳におすすめの求人サイト',
    'b01-08' => '23-25歳の就職におすすめの求人サイト',
    'b01-09' => '23-25歳の再就職におすすめの求人サイト',
    'b01-10' => '23-25歳男性におすすめの求人サイト',
    'b01-11' => '23-25歳女性の再就職におすすめの求人サイト',
    'b01-12' => '23-25歳男性の就職におすすめの求人サイト',
    'b01-13' => '23-25歳男性の再就職におすすめの求人サイト',
    'b01-14' => '23-25歳の中途採用におすすめの求人サイト',
    'b01-15' => '23-25歳男性におすすめの転職サイト',
    'b01-16' => '23-25歳女性におすすめの転職サイト',
    'b02-01' => '26-29歳におすすめの転職サイト',
    'b02-02' => '26-29歳女性の再就職におすすめの求人サイト',
    'b02-03' => '26-29歳女性におすすめの転職サイト',
    'b02-04' => '26-29歳のフリーターにおすすめの転職サイト',
    'b02-05' => '26-29歳におすすめの転職サイト',
    'b02-06' => '26-29歳の就職におすすめの求人サイト',
    'b02-07' => '26-29歳の中途採用におすすめの求人サイト',
    'b02-08' => '26-29歳におすすめの求人サイト',
    'b02-09' => '26-29歳男性におすすめの求人サイト',
    'b02-10' => '26-29歳女性の就職におすすめの求人サイト',
    'b02-11' => '26-29歳女性におすすめの求人サイト',
    'b02-12' => '26-29歳男性の就職におすすめの求人サイト',
    'b02-13' => '26-29歳男性の再就職におすすめの求人サイト',
    'b02-14' => '26-29歳の再就職におすすめの求人サイト',
    'b02-15' => '26-29歳の仕事探しにおすすめの求人サイト',
    'b02-16' => '26歳-29歳男性におすすめの転職サイト',
    'b03-01' => '30歳-34歳のフリーターにおすすめの転職サイト',
    'b03-02' => '30歳-34歳におすすめの転職サイト',
    'b03-03' => '30歳-34歳男性の再就職におすすめの転職サイト',
    'b03-04' => '30歳-34歳の再就職におすすめの転職サイト',
    'b03-05' => '30歳-34歳におすすめの求人サイト',
    'b03-06' => '30歳-34歳におすすめの転職サイト',
    'b03-07' => '30歳-34歳の就職におすすめの求人サイト',
    'b03-08' => '30歳-34歳の仕事探しにおすすめの求人サイト',
    'b03-09' => '30歳-34歳男性におすすめの求人サイト',
    'b03-10' => '30歳-34歳女性の就職におすすめの求人サイト',
    'b03-11' => '30歳-34歳女性におすすめの求人サイト',
    'b03-12' => '30歳-34歳男性の就職におすすめの求人サイト',
    'b03-13' => '30歳-34歳の中途採用におすすめの求人サイト',
    'b03-14' => '30歳-34歳男性の就職におすすめの求人サイト',
    'b03-15' => '30歳-34歳女性の再就職におすすめの求人サイト',
    'b03-16' => '30歳-34歳女性におすすめの転職サイト',
  );

  // $kw_list_val = array_key_exists( $param, $kw_list );
  // var_dump( $kw_list_val );
  return $kw_list[$param];
}
