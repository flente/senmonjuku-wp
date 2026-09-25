<?php get_header(); ?>
<?php
  $imgUri = get_theme_file_uri() . "/assets/image/";
  // 【確認用】URLに ?school_preview=0c82b980 が付いている時だけ、担当講師紹介・教室内の様子セクションを表示する。
  // お客様承認後、この分岐を外して常時表示にする。
  $is_school_preview = isset($_GET['school_preview']) && $_GET['school_preview'] === '0c82b980';
?>
<div class="l_wrapper">
    <div class="c_single">
        <?php get_template_part( 'parts/subPageHeader' ); ?>
        <div class="p_school">
            <div class="p_school_header">
                <div class="p_school_thumbnail">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail(); ?>
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/image/school/school_no-image.png" alt="NO IMAGE">
                    <?php endif; ?>
                </div>
                <span class="p_school_cat">
                    <?php $terms = get_the_terms($post->ID,'area');
                    foreach( $terms as $term ) {
                        echo $term->name ;
                    }
                    ?>
                </span>        
            </div>
            <main class="p_school_main">
                <div class="l_inner _single">
                    <h1 class="p_school_title"><span><?php the_field('area'); ?></span><?php the_title(); ?></h1>
                    <div class="l_xlCol2 mb5 flex">
                        <div class="l_xlCol2_left">
                            <div class="p_school_map">
                                <iframe src="<?php the_field('googlemap_iframe'); ?>" width="16" height="9" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            <p class="p_school_address">〒<?php the_field('zipcode'); ?><br><?php the_field('address'); ?></p>
                            <div class="p_school_mapButton">
                                <a href="<?php the_field('googlemap_link'); ?>" target="_blank">GoogleMapで開く</a>
                            </div>
                        </div>
                        <div class="l_xlCol2_right">
                            <dl class="c_dataList">
                                <div class="c_dataList_item">
                                    <dt>電話番号</dt>
                                    <dd>
                                        <?php if(get_field('tel')): ?>
                                            <a href="tel:<?php the_field('tel'); ?>"><?php the_field('tel'); ?></a>
                                        <?php else : ?>
                                            <a href="tel:0120-187-703">0120-187-703</a>
                                        <?php endif; ?>
                                    </dd>
                                </div>
                                <div class="c_dataList_item">
                                    <dt>通塾学区<br>（小学校）</dt>
                                    <dd><?php the_field('schoolArea_schoolchild'); ?></dd>
                                </div>
                                <div class="c_dataList_item">
                                    <dt>通塾学区<br>（中学校）</dt>
                                    <dd><?php the_field('schoolArea_school'); ?></dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <?php if ($is_school_preview): ?>
                    <?php
                        $current_school_id = get_the_ID();
                        $teacher_args = array(
                            'post_type' => 'teacher',
                            'post_status' => 'publish', // 非公開の講師は除外
                            'posts_per_page' => -1,
                            'meta_query' => array(
                                array(
                                    'key' => 'classroom_url',
                                    'value' => '"' . $current_school_id . '"',
                                    'compare' => 'LIKE',
                                ),
                            ),
                        );
                        $teacher_query = new WP_Query($teacher_args);
                        if ($teacher_query->have_posts()):
                    ?>
                    <div class="p_school_teacherSection mb5">
                        <div class="e_heading-wrap mb2">
                            <h2 class="e_heading _pink _subpage">
                                <span class="e_heading_jp">担当講師紹介</span>
                                <span class="e_heading_en">TEACHER</span>
                            </h2>
                        </div>
                        <ul class="p_school_teacherList">
                            <?php while ($teacher_query->have_posts()): $teacher_query->the_post(); ?>
                            <li>
                                <button type="button" class="p_school_teacherCard" data-micromodal-trigger="teacher-modal-<?php the_ID(); ?>">
                                    <span class="p_school_teacherCard_photo">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail(); ?>
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/image/common/thumbnail_noimage.jpg" alt="">
                                        <?php endif; ?>
                                    </span>
                                    <span class="p_school_teacherCard_name"><?php the_title(); ?></span>
                                    <?php if (get_field('name_kana')): ?>
                                    <span class="p_school_teacherCard_kana"><?php the_field('name_kana'); ?></span>
                                    <?php endif; ?>
                                    <span class="p_school_teacherCard_more">詳しく見る</span>
                                </button>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                        <?php
                            // モーダルの中身は上のループとは別に、投稿データを取り直して出力する
                            $teacher_query->rewind_posts();
                            while ($teacher_query->have_posts()): $teacher_query->the_post();
                        ?>
                        <div class="c_teacherModal" id="teacher-modal-<?php the_ID(); ?>" aria-hidden="true">
                            <div class="c_teacherModal_overlay" data-micromodal-close></div>
                            <div class="c_teacherModal_container" role="dialog" aria-modal="true">
                                <button type="button" class="c_teacherModal_close" data-micromodal-close aria-label="閉じる">×</button>
                                <div class="c_teacherModal_photo">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail(); ?>
                                    <?php else: ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/image/common/thumbnail_noimage.jpg" alt="">
                                    <?php endif; ?>
                                </div>
                                <div class="c_teacherModal_body">
                                    <?php if (get_field('message')): ?>
                                    <p class="c_teacherModal_message"><?php the_field('message'); ?></p>
                                    <?php endif; ?>
                                    <h3 class="c_teacherModal_name">
                                        <?php the_title(); ?>
                                        <?php if (get_field('name_kana')): ?>
                                        <span>（<?php the_field('name_kana'); ?>）</span>
                                        <?php endif; ?>
                                    </h3>
                                    <?php if (get_field('profile_favoriteSubject')): ?>
                                    <p class="c_teacherModal_subject">得意科目：<?php the_field('profile_favoriteSubject'); ?></p>
                                    <?php endif; ?>
                                    <?php if (get_field('profile_motto') || get_field('profile_club') || get_field('profile_hobby')): ?>
                                    <dl class="c_teacherModal_profileList">
                                        <?php if (get_field('profile_motto')): ?>
                                        <div class="c_teacherModal_profileList_item">
                                            <dt>座右の銘</dt>
                                            <dd><?php the_field('profile_motto'); ?></dd>
                                        </div>
                                        <?php endif; ?>
                                        <?php if (get_field('profile_club')): ?>
                                        <div class="c_teacherModal_profileList_item">
                                            <dt>学生時代の部活</dt>
                                            <dd><?php the_field('profile_club'); ?></dd>
                                        </div>
                                        <?php endif; ?>
                                        <?php if (get_field('profile_hobby')): ?>
                                        <div class="c_teacherModal_profileList_item">
                                            <dt>趣味</dt>
                                            <dd><?php the_field('profile_hobby'); ?></dd>
                                        </div>
                                        <?php endif; ?>
                                    </dl>
                                    <?php endif; ?>
                                    <?php if (get_the_content()): ?>
                                    <div class="c_teacherModal_interview c_singleContent_main">
                                        <?php the_content(); ?>
                                    </div>
                                    <?php endif; ?>
                                    <button type="button" class="c_teacherModal_bottomClose" data-micromodal-close>閉じる</button>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <?php endif; wp_reset_postdata(); ?>
                    <?php if (have_rows('school_gallery')): ?>
                    <div class="p_school_gallery mb5">
                        <div class="e_heading-wrap mb2">
                            <h2 class="e_heading _pink _subpage">
                                <span class="e_heading_jp">教室内の様子</span>
                                <span class="e_heading_en">GALLERY</span>
                            </h2>
                        </div>
                        <ul class="p_school_gallery_list">
                            <?php while (have_rows('school_gallery')): the_row(); ?>
                            <li class="p_school_gallery_item">
                                <?php if (get_sub_field('gallery_image')): ?>
                                <div class="p_school_gallery_image"><img src="<?php echo esc_url(get_sub_field('gallery_image')); ?>" alt="<?php echo esc_attr(get_sub_field('gallery_title')); ?>"></div>
                                <?php endif; ?>
                                <?php if (get_sub_field('gallery_title')): ?>
                                <p class="p_school_gallery_title"><?php echo esc_html(get_sub_field('gallery_title')); ?></p>
                                <?php endif; ?>
                                <?php if (get_sub_field('gallery_text')): ?>
                                <p class="p_school_gallery_text"><?php echo esc_html(get_sub_field('gallery_text')); ?></p>
                                <?php endif; ?>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <script>

                    document.querySelectorAll('.p_school_teacherCard[data-micromodal-trigger]').forEach(function(el){
                      el.addEventListener('click', function(){
                        MicroModal.show(el.getAttribute('data-micromodal-trigger'), {
                          disableScroll: true,
                          awaitOpenAnimation: false,
                          awaitCloseAnimation: false,
                        });
                      });
                    });
                    </script>
                    <?php endif; ?>
                    <?php if(have_rows('access')): ?>
                    <div class="p_school_accsess mb5">
                        <div class="e_heading-wrap mb2">
                            <h2 class="e_heading _pink _subpage">
                                <span class="e_heading_jp">アクセス</span>
                                <span class="e_heading_en">ACCESS</span>
                            </h2>
                        </div>
                        <dl class="c_dataList _column">
                            <?php while(have_rows('access')): the_row(); ?>
                            <div class="c_dataList_item">
                                <dt><?php the_sub_field('access_title'); ?></dt>
                                <dd><?php the_sub_field('access_item'); ?></dd>
                            </div>
                            <?php endwhile; ?>
                        </dl>
                    </div>
                    <?php endif; ?>
                    <div class="mb5">
                        <?php get_template_part( 'parts/ctaBannar' ); ?>
                    </div>
                </div>
            </main>
            <div class="p_school_other">
                <div class="l_inner">
                    <div class="e_heading-wrap mb2">
                        <h2 class="e_heading _pink _subpage">
                            <span class="e_heading_jp"><?php echo $term->name ; ?>の他の教室</span>
                            <span class="e_heading_en">OTHER SCHOOL</span>
                        </h2>
                    </div>
                    <?php
                        $current_post_id = get_the_ID();
                        $args = array(
                        'post_type' => 'school', // 投稿タイプのスラッグを指定
                        'posts_per_page' => 3, // 投稿件数の指定
                        'orderby' => 'rand',
                        'post__not_in' => [$current_post_id], // 除外する記事のIDを指定
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'area',
                                'field' => 'slug',
                                'terms' => $term->slug,
                            ),
                        ),
                        );
                        $school_query = new WP_Query($args); if($school_query->have_posts()):
                    ?>
                    <ul class="c_schoolList">
                        <?php while ($school_query->have_posts()): $school_query->the_post(); ?>
                        <li class="c_schoolList_item">
                            <a href="<?php the_permalink(); ?>">
                                <article>
                                    <div class="c_schoolList_text">
                                        <p class="c_schoolList_title"><?php echo get_the_title(); ?></p>
                                        <p class="c_schoolList_address">〒<?php the_field('zipcode'); ?><br><?php the_field('address'); ?></p>
                                        <div class="e_button _line _lineWhite _center">
                                            <span>詳しく見る</span>
                                        </div>
                                    </div>
                                    <div class="c_schoolList_image">
                                        <span class="c_schoolList_cat">
                                            <?php $terms = get_the_terms($post->ID,'area');
                                            foreach( $terms as $term ) {
                                                echo $term->name ;
                                            }
                                            ?>
                                        </span>
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail(); ?>
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/image/school/school_no-image.png" alt="NO IMAGE">
                                        <?php endif; ?>
                                    </div>
                                </article>
                            </a>
                        </li>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    </ul>
                    <?php else: ?>
                    <p>他の校舎はまだありません。</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>