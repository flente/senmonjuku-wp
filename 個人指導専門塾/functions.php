<?php
//テーマのセットアップ
// titleタグをhead内に生成する
add_theme_support( 'title-tag' );
// HTML5でマークアップさせる
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
// Feedのリンクを自動で生成する
add_theme_support( 'automatic-feed-links' );
//アイキャッチ画像を使用する設定
add_theme_support('post-thumbnails');

//cssファイルの読み込み
function add_styles() {
	$css_directory = get_template_directory_uri().'/assets/scss/';
	$css_page_directory = $css_directory . 'page/';
	$css_version = '1.1.2-school-preview';//ここの数値を変更すればバージョンが更新できる（キャッシュ強制更新用）
	wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
	
	wp_enqueue_style('reset_style', $css_directory.'style.css', "", $css_version);
	if (is_front_page() || is_page_template('templates/home-draft.php')) {
		wp_enqueue_style('home_style', $css_page_directory. 'home/' . 'index.css', "", $css_version);
		// SCHOOL地図化：Leaflet（無料・APIキー不要）
		wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', "", "1.9.4" );
	}
	if (is_singular('school')) {
		wp_enqueue_style('school_style', $css_page_directory. 'school/' . 'index.css', "", $css_version);
  	}
	if (is_singular('teacher')) {
		wp_enqueue_style('teacher_style', $css_page_directory. 'teacher/' . 'index.css', "", $css_version);
  	}
	if (is_singular('course') || is_page("premium-course")) {
		wp_enqueue_style('course_style', $css_page_directory. 'course/' . 'index.css', "", $css_version);
	}
	if (is_404()) {
		wp_enqueue_style('error_style', $css_page_directory. 'error/' . 'index.css', "", $css_version);
	}
	if (is_page_template(
		array(
			"templates/contact.php",
			"templates/contact-compleat.php",
			"templates/contact-confirm.php",
			"templates/contact-no-header.php",
			"templates/contact-draft.php"
			)
		)){
		wp_enqueue_style('contact_style', $css_page_directory. 'contact/' . 'index.css', "", $css_version);
	}
}
add_action('wp_enqueue_scripts', 'add_styles');

//jsファイルの読み込み
function add_scripts() { 
     // 閉じBODYタグ前に出力
	$js_directory = get_template_directory_uri().'/assets/js/';
	$js_version = '0.0.1';//ここの数値を変更すればバージョンが更新できる
	wp_enqueue_script('jquery', true);
	wp_enqueue_script( 'micromodal', 'https://unpkg.com/micromodal/dist/micromodal.min.js', true);
	wp_enqueue_script( 'main', $js_directory.'main.js', "", $js_version, true);
	wp_enqueue_script( 'animation', $js_directory.'animation.js', "", $js_version, true);
	if (is_front_page() || is_page_template('templates/home-draft.php')) {
		wp_enqueue_script( 'home', $js_directory.'home.js', "", $js_version, true);
		wp_enqueue_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', true);
		wp_enqueue_script( 'swiper-works', $js_directory.'swiper-works.js', "", $js_version, true);
		// SCHOOL地図化：Leaflet本体＋初期化スクリプト
		wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', "", "1.9.4", true );
		wp_enqueue_script( 'school-map', $js_directory.'schoolMap.js', array('leaflet'), $js_version, true );
		wp_localize_script( 'school-map', 'schoolMapData', senmonjuku_get_school_map_data() );
	}
 }
add_action('wp_print_scripts', 'add_scripts');

// TOPページ地図用：school投稿を緯度経度つきで取得（school_lat/school_lngが未入力のものはpinを出さない）
function senmonjuku_get_school_map_data() {
	$area_colors = array(
		'nagoya' => '#D5546A',
		'owari'  => '#E08A3C',
		'mikawa' => '#4CAF7D',
		'gifu'   => '#5486D5',
	);

	$query = new WP_Query(array(
		'post_type'      => 'school',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'no_found_rows'  => true,
	));

	$schools = array();
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_id = get_the_ID();
		$lat = get_field('school_lat', $post_id);
		$lng = get_field('school_lng', $post_id);
		// 座標が未入力（バックフィル未実施）の校舎は地図に出さずスキップ
		if ( $lat === '' || $lng === '' || $lat === null || $lng === null ) {
			continue;
		}
		$area_terms = get_the_terms( $post_id, 'area' );
		$area_slug = ( $area_terms && ! is_wp_error( $area_terms ) ) ? $area_terms[0]->slug : '';
		$area_name = ( $area_terms && ! is_wp_error( $area_terms ) ) ? $area_terms[0]->name : '';
		$thumbnail = get_the_post_thumbnail_url( $post_id, 'medium' );
		$schools[] = array(
			'id'      => $post_id,
			'name'    => get_the_title(),
			'url'     => get_permalink(),
			'address' => get_field('address', $post_id),
			'lat'     => (float) $lat,
			'lng'     => (float) $lng,
			'area'    => $area_slug,
			'areaName'=> $area_name . 'エリア',
			'color'   => isset( $area_colors[ $area_slug ] ) ? $area_colors[ $area_slug ] : '#D5546A',
			'image'   => $thumbnail ? $thumbnail : get_theme_file_uri() . '/assets/image/school/school_no-image.png',
		);
	}
	wp_reset_postdata();

	return array( 'schools' => $schools );
}


// テーマカスタマイザーに重要なお知らせのリンク入力欄を追加
function important_notices_customize_register( $wp_customize ) {
	// セクション
	$wp_customize->add_section( 'important_notices', array(
	  'title'     => '重要なお知らせ',
	  'priority'  => 200,
	));
	// セッティング
	$wp_customize->add_setting( 'important_notices_url', array(
	  'default'   => '',
	  'type'      => 'option',
	  'transport' => 'postMessage',
	));
	// コントロール
	$wp_customize->add_control( 'important_notices_control', array(
	  'settings'  => 'important_notices_url',
	  'label'     => '重要なお知らせ',
	  'description' => 'URLを入力してください。',
	  'section'   => 'important_notices',
	  'type'      => 'text',
	));
  }
  add_action( 'customize_register', 'important_notices_customize_register' );

// テーマカスタマイザーにピックアップ記事のリンク入力欄を追加
function pickup_post_customize_register( $wp_customize ) {
	// セクション
	$wp_customize->add_section( 'pickup_post', array(
		'title'     => 'ピックアップ記事',
		'priority'  => 200,
	));
	//1つめ
	$wp_customize->add_setting( 'pickup_post_url1', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control( 'pickup_post_control1', array(
		'settings'  => 'pickup_post_url1',
		'label'     => 'ピックアップ記事１',
		'description' => 'URLを入力してください。',
		'section'   => 'pickup_post',
		'type'      => 'text',
	));
	//2つめ
	$wp_customize->add_setting( 'pickup_post_url2', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control( 'pickup_post_control2', array(
		'settings'  => 'pickup_post_url2',
		'label'     => 'ピックアップ記事２',
		'description' => 'URLを入力してください。',
		'section'   => 'pickup_post',
		'type'      => 'text',
	));
	//3つめ
	$wp_customize->add_setting( 'pickup_post_url3', array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control( 'pickup_post_control3', array(
		'settings'  => 'pickup_post_url3',
		'label'     => 'ピックアップ記事３',
		'description' => 'URLを入力してください。',
		'section'   => 'pickup_post',
		'type'      => 'text',
	));
  }
  add_action( 'customize_register', 'pickup_post_customize_register' );

//カスタムメニュー機能を使用
function register_custom_menu() { 
	register_nav_menus( array(
	//'「メニューの位置」の識別子' => 'メニューの説明の文字列',
	  'header-menu-1' => 'ヘッダーメニュー1',
	  'header-menu-2' => 'ヘッダーメニュー2',
	  'header-menu-3' => 'ヘッダーメニュー3',
	  'header-menu-pc' => 'ヘッダーメニューPC',
	  'footer-menu'  => 'フッターメニュー',
	) );
}
add_action( 'after_setup_theme', 'register_custom_menu' );

// wp_nav_menuのliにclass追加
function add_additional_class_on_li($classes, $item, $args)
{
  if (isset($args->add_li_class)) {
    $classes['class'] = $args->add_li_class;
  }
  return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

function post_has_archive( $args, $post_type ) {
	if ( 'post' == $post_type ) {
	  $args['rewrite'] = true;
	  $args['has_archive'] = 'blog'; //URLとして使いたい文字列
	}
	return $args;
  }
add_filter( 'register_post_type_args', 'post_has_archive', 10, 2 );

// カスタム投稿　「コース」を追加 ----------------------------------------------------------------
 $labels = array(
 'name' => __('コース'),
 'singular_name' => __('コース'),
 'add_new' => __('コースを追加'),
 'add_new_item' => __('コースを追加'),
 'edit_item' => __('コースを編集'),
 'new_item' => __('新規追加'),
 'view_item' => __(''),
 'search_items' => __(''),
 'not_found' => __(''),
 'not_found_in_trash' => __(''), 
 'parent_item_colon' => ''
);

register_post_type('course', array(
 'label' => __('Course', 'tcd-w'),
 'labels' => $labels,
 'public' => true,
 'publicly_queryable' => true,
 'menu_position' => 5,
 'show_ui' => true,
 'query_var' => true,
 'rewrite' => true,
 'capability_type' => 'post',
 'has_archive' => true,
 'hierarchical' => false,
 'supports' => array('title', 'editor')
));

// コースカテゴリーの追加
$args_course_category = array(
  'label' => __('Course Category', 'tcd-w'),
  'labels' => array(
    'name' => __('Course Category', 'tcd-w'),
    'singular_name' => __('Course Category', 'tcd-w'),
    'search_items' => __('Search Category', 'tcd-w'),
    'popular_items' => __('Popular Category', 'tcd-w'),
    'all_items' => __('All Category', 'tcd-w'),
    'parent_item' => __('Parent Category', 'tcd-w'),
    'edit_item' => __('Edit Category', 'tcd-w'),
    'update_item' => __('Update Category', 'tcd-w'),
    'add_new_item' => __('Add New Category', 'tcd-w'),
    'new_item_name' => __('Name Of New Category', 'tcd-w'),
  ),
  'public' => true,
  'show_ui' => true,
  'show_admin_column' => true,
  'hierarchical' => true,
  'rewrite' => array('hierarchical' => false),
);
register_taxonomy('course_category', 'course', $args_course_category);

// コースカテゴリーのURLをコースURL+ハッシュに変更
function course_category_term_link($termlink, $term, $taxonomy) {
  if ($taxonomy == 'course_category') {
    return get_post_type_archive_link('course').'#course_category-'.$term->term_id;
  }
  return $termlink;
}
add_filter('term_link', 'course_category_term_link', 11, 3);


function my_custom_post_type_permalinks_set($termlink, $term, $taxonomy){
	if ($taxonomy == 'area') {
  return str_replace('/'.$taxonomy.'/', '/', $termlink);
	}
	return $termlink;
}
add_filter('term_link', 'my_custom_post_type_permalinks_set',11,3);

add_rewrite_rule('school/([^/]+)/?$', 'index.php?area=$matches[1]', 'top');
add_rewrite_rule('school/([^/]+)/page/([0-9]+)/?$', 'index.php?area=$matches[1]&paged=$matches[2]', 'top');

//ダウンロードCSVの列の削除
/**
 * カラムを並び替える、削除する
 * 
 * @param  array $columns カラム名の配列
 * @return array
 */
function my_mwform_inquiry_data_columns( $columns ) {
    // カラムを指定された順番に並び替える
    $columns = array(
        'post_date' => 'post_date',
        'post_modified' => 'post_modified',
        'post_title' => 'post_title',
        'address1' => 'address1',
        'address2' => 'address2',
        'building' => 'building',
        'strt' => 'strt',
        'zip1' => 'zip1',
        'zip2' => 'zip2',
        'お子様のお名前' => 'お子様のお名前',
        'お子様の学年' => 'お子様の学年',
        'カナ' => 'カナ',
        'メッセージ' => 'メッセージ',
        'メールアドレス' => 'メールアドレス',
        '来塾した教室名' => '来塾した教室名',
        '来塾日' => '来塾日',
        '電話番号' => '電話番号',
    );
    return $columns;
}
add_filter( 'mwform_inquiry_data_columns-mwf_10807', 'my_mwform_inquiry_data_columns' );

// school投稿に緯度経度フィールドを追加（TOPページの地図化用。管理画面からではなくPHP側で定義）
// 既存の googlemap_iframe / googlemap_link からmidを抽出してKML経由で座標を取得し、
// 別途バックフィル用スクリプトでこの2フィールドに書き込む想定（手入力は基本不要）
function register_school_map_fields() {
	if ( ! function_exists('acf_add_local_field_group') ) {
		return;
	}
	acf_add_local_field_group(array(
		'key' => 'group_school_map_location',
		'title' => '教室紹介：地図座標（TOP地図用）',
		'fields' => array(
			array(
				'key' => 'field_school_lat',
				'label' => '緯度（latitude）',
				'name' => 'school_lat',
				'type' => 'number',
				'step' => 'any',
			),
			array(
				'key' => 'field_school_lng',
				'label' => '経度（longitude）',
				'name' => 'school_lng',
				'type' => 'number',
				'step' => 'any',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'school',
				),
			),
		),
		'position' => 'side',
	));
}
add_action('acf/init', 'register_school_map_fields');

// school投稿に「教室内の様子」ギャラリーフィールドを追加（管理画面から画像・タイトル・テキストを編集可）
function register_school_gallery_fields() {
	if ( ! function_exists('acf_add_local_field_group') ) {
		return;
	}
	acf_add_local_field_group(array(
		'key'    => 'group_school_gallery',
		'title'  => '教室内の様子',
		'fields' => array(
			array(
				'key'          => 'field_school_gallery',
				'label'        => '教室内の様子',
				'name'         => 'school_gallery',
				'type'         => 'repeater',
				'instructions' => '画像・タイトル・説明文を追加してください。最大6件まで表示されます。',
				'min'          => 0,
				'max'          => 6,
				'layout'       => 'block',
				'button_label' => '写真を追加',
				'sub_fields'   => array(
					array(
						'key'           => 'field_school_gallery_image',
						'label'         => '画像',
						'name'          => 'gallery_image',
						'type'          => 'image',
						'return_format' => 'url',
						'preview_size'  => 'medium',
						'library'       => 'all',
					),
					array(
						'key'   => 'field_school_gallery_title',
						'label' => 'タイトル（例：自習スペース）',
						'name'  => 'gallery_title',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_school_gallery_text',
						'label' => '説明文',
						'name'  => 'gallery_text',
						'type'  => 'textarea',
						'rows'  => 3,
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'school',
				),
			),
		),
		'position'      => 'normal',
		'menu_order'    => 10,
		'label_placement' => 'top',
	));
}
add_action('acf/init', 'register_school_gallery_fields');
