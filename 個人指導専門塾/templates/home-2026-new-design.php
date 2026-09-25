<?php get_header();
/*
Template Name: 2026年新デザイン
*/
// 2026年新デザインの確認用テンプレート。
// 本番の HOME テンプレートとは別に管理する。
?>
<?php if ( post_password_required() ) : ?>
  <div class="l_wrapper">
    <div class="l_inner" style="padding: 8rem 0;">
      <?php echo get_the_password_form(); ?>
    </div>
  </div>
  <?php get_footer(); ?>
<?php return; endif; ?>
<?php
  $imgUri = get_theme_file_uri() . "/assets/image/";
?>
<div class="l_wrapper js-wrapper">
<?php /*
  <div class="p_mv">
    <div class="p_mv_text">
      <h1 class="p_mv_catchCopy">
        <span class="js-mv-visible">勉強の</span><br>
        <span class="js-mv-visible">やり方が変われば</span><br>
        <span class="js-mv-visible">結果が変わる</span>
      </h1>
    </div>
    <?php if ( get_option('important_notices_url') ) : ?>
      <?php
        $important_notices_url = get_option('important_notices_url') ;
        $keys = parse_url($important_notices_url); //パース処理
        $path = explode("/", $keys['path']); //分割処理
        $last = end($path); //最後の要素を取得
        $data = get_page_by_path($last, OBJECT, 'news');
        $post_id = $data->ID;
        $date = get_the_date('Y/m/d', $post_id);
      ?>
	  
      <div class="c_newsList_item _note">
        <a href="<?php echo $important_notices_url ?>">
          <article>
            <p class="c_newsList_date"><?php echo $date ?></p>
            <p class="c_newsList_title"><?php echo get_the_title(url_to_postid($important_notices_url)) ?></p>
          </article>
          </a>
      </div>
	  
      <?php else: ?>
    <?php endif; ?>
    <div class="p_mv_bg">
      <picture>
          <source media="(min-width: 1024px)" srcset="<?php echo $imgUri; ?>home/xl_mainvisual_bg.webp" type="image/webp">
          <source media="(min-width: 1024px)" srcset="<?php echo $imgUri; ?>home/xl_mainvisual_bg.jpg">
          <source srcset="<?php echo $imgUri; ?>home/sm_mainvisual_bg.webp" type="image/webp">
          <img src="<?php echo $imgUri; ?>home/sm_mainvisual_bg.jpg">
        </picture>
    </div>
  </div>
  */ ?>
  <?php if(have_rows('banner_slider')): ?>
  <div class="p_bannerSlider">
    <div class="swiper js-bannerSlider">
      <div class="swiper-wrapper">
        <?php while(have_rows('banner_slider')): the_row(); ?>
        <div class="swiper-slide">
          <a href="<?php the_sub_field('url'); ?>">
            <img src="<?php the_sub_field('image'); ?>" alt="">
          </a>
        </div>
        <?php endwhile; ?>
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </div>
  </div><!-- /p_bannerSlider -->
  <?php /* 
  <div class="p_bannerSlider">
    <div class="l_inner p_bannerSlider_inner">
      <?php while(have_rows('banner_slider')): the_row(); ?>
      <div class="swiper-slide">
        <a href="<?php the_sub_field('url'); ?>">
          <img src="<?php the_sub_field('image'); ?>" alt="">
        </a>
      </div>
      <?php endwhile; ?>
    </div>
  </div><!-- /p_bannerSlider -->
  */ ?>
  <?php endif; ?>
  <br />
  <div class="p_message _renewal">
    <div class="l_inner">
      <div class="p_message_layout">
        <div class="p_message_left">
          <div class="e_heading-wrap mb2">
            <h2 class="e_heading _large _white">
              <span class="e_heading_en">MESSAGE</span>
              <span class="e_heading_jp">指導方針</span>
            </h2>
          </div>
          <h3 class="p_message_catchCopy">頑張っているのに、<br>なぜ成績が上がらないのか。</h3>
          <p class="p_message_text">そんな悩みを抱える保護者の方へ。<br>それは、お子さんの能力や性格の問題ではありません。</p>
          <p class="p_message_lead">成績が上がらない理由は、</p>
          <p class="p_message_highlight"><span>正しい勉強のやり方を知らないだけ</span></p>
          <p class="p_message_text">だから私たちは、一人ひとりに合った学び方から指導します。</p>
          <div class="e_button _line _lineWhite">
            <a href="<?php echo esc_url( home_url( '/policy' ) ); ?>">詳しく見る</a>
          </div>
        </div>
        <div class="p_message_right">
          <ul class="p_message_stats">
            <li class="p_message_stats_item">
              <span class="p_message_stats_icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
              </span>
              <p class="p_message_stats_number"><span>25</span>年以上</p>
              <p class="p_message_stats_note">地域に根ざした学習指導</p>
            </li>
            <li class="p_message_stats_item">
              <span class="p_message_stats_icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M14 22v-4a2 2 0 1 0-4 0v4"/><path d="m18 10 3.447 1.724a1 1 0 0 1 .553.894V20a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-7.382a1 1 0 0 1 .553-.894L6 10"/><path d="M18 5v17"/><path d="m4 6 8-4 8 4"/><path d="M6 5v17"/><circle cx="12" cy="9" r="2"/></svg>
              </span>
              <p class="p_message_stats_number"><span>14</span>校</p>
              <p class="p_message_stats_note">愛知・岐阜エリアで展開中</p>
            </li>
            <li class="p_message_stats_item">
              <span class="p_message_stats_icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
              </span>
              <p class="p_message_stats_number">合格率<span>92</span>%</p>
              <p class="p_message_stats_note">昨年度の合格実績</p>
            </li>
          </ul>
          <div class="p_message_media">
            <p class="p_message_media_title">メディア掲載実績</p>
            <p class="p_message_media_note">TVや雑誌など複数のメディアでご紹介いただきました</p>
            <ul class="p_message_mediaGrid _cover">
              <?php for ($i = 1; $i <= 10; $i++): $num = str_pad($i, 2, '0', STR_PAD_LEFT); ?>
              <li class="p_message_mediaGrid_item _image">
                <picture>
                  <source srcset="<?php echo $imgUri; ?>home/media_<?php echo $num; ?>.webp" type="image/webp">
                  <img src="<?php echo $imgUri; ?>home/media_<?php echo $num; ?>.jpg" alt="">
                </picture>
              </li>
              <?php endfor; ?>
            </ul>
          </div>
          <!-- メディア掲載実績のスライダー(下部の既存p_mediaセクション)も削除せずそのまま維持しています -->
        </div>
      </div>
    </div>
  </div><!-- /p_message -->
    <div class="p_news">
    <div class="l_inner">
      <div class="e_heading-wrap mb3">
        <h2 class="e_heading _large _pink">
          <span class="e_heading_en">NEWS</span>
          <span class="e_heading_jp">新着情報</span>
        </h2>
      </div>
      <?php
        $args = array(
          'post_type' => 'news', // 投稿タイプのスラッグを指定
          'posts_per_page' => 3 // 投稿件数の指定
        );
        $news_query = new WP_Query($args); if($news_query->have_posts()):
      ?>
      <ul class="c_newsList mb3">
        <?php while ($news_query->have_posts()): $news_query->the_post(); ?>
        <li class="c_newsList_item">
          <a href="<?php the_permalink(); ?>">
          <article>
            <time datetime="<?php the_time('Y-m-d'); ?>" class="c_newsList_date"><?php the_time('Y.m.d'); ?></time>
            <p class="c_newsList_title"><?php echo get_the_title(); ?></p>
          </article>
          </a>
        </li>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </ul>
      <div class="e_button _line _linePink _center">
        <a href="<?php echo esc_url( home_url( '/news' ) ); ?>">他のお知らせを見る</a>
      </div>
      <?php else: ?>
      <p>まだ投稿がありません。</p>
      <?php endif; ?>
    </div>
  </div><!-- /p_news -->
  
  <div class="p_course _renewal" id="course">
    <div class="p_course_top js-bgChange">
      <div class="l_inner">
        <div class="e_heading-wrap mb2">
          <h2 class="e_heading _large">
            <span class="e_heading_en">COURSE</span>
            <span class="e_heading_jp">コース紹介</span>
          </h2>
        </div>
        <div class="p_courseCards">

          <!-- 中学生コース -->
          <div class="p_courseCard _pink">
            <div class="p_courseCard_header">
              <div class="p_courseCard_heroImage">
                <picture>
                  <source srcset="<?php echo $imgUri; ?>/home/course_school.webp" type="image/webp">
                  <img src="<?php echo $imgUri; ?>/home/course_school.jpg" alt="中学生コース">
                </picture>
              </div>
              <span class="p_courseCard_target">対象学年｜中学1〜3年生</span>
              <h3 class="p_courseCard_title"><span>中学生</span>コース</h3>
              <p class="p_courseCard_subtitle">高校受験に向けて、<br>今の一歩を確かな力に。</p>
            </div>
            <div class="p_courseCard_body">
              <div class="p_courseCard_worries">
                <h4 class="p_courseCard_worries_title">
                  <span class="p_courseCard_worries_icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6 2 1 6 1 11c0 3 2 6 5 7l-2 5 7-3c7 0 12-4 12-9S18 2 12 2Z"/><g fill="white"><circle cx="7" cy="11" r="1.2"/><circle cx="12" cy="11" r="1.2"/><circle cx="17" cy="11" r="1.2"/></g></svg>
                  </span>
                  こんなお悩みありませんか？
                </h4>
                <ul class="p_courseCard_worries_list">
                  <li>学校の成績や<br>テストの点数が<br>下がりぎみ</li>
                  <li>スマホばかりで、<br>勉強となかなか<br>向き合えない</li>
                  <li>勉強のやり方が<br>分かっていないのでは、<br>と感じる</li>
                </ul>
              </div>
              <div class="p_courseCard_solution">
                <h4 class="p_courseCard_solution_title">
                  <span class="p_courseCard_solution_icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 17c0-3-3-3-3-8a7 7 0 0 1 14 0c0 5-3 5-3 8Z"/><path d="M8 20h8m-6 3h4M12 0v-2M3 3 1 1m20 2 2-2"/></svg>
                  </span>
                  個別指導専門塾ならこう変わる
                </h4>
                <ul class="p_courseCard_solution_list">
                  <li>
                    <span class="p_courseCard_solution_listIcon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </span>
                    <p>学校の進度やテスト範囲に合わせた完全個別カリキュラム</p>
                  </li>
                  <li>
                    <span class="p_courseCard_solution_listIcon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </span>
                    <p>行動科学マネジメント&#174;に基づき、正しい勉強のやり方を指導</p>
                  </li>
                  <li>
                    <span class="p_courseCard_solution_listIcon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                    </span>
                    <p>家庭学習が習慣になるように毎日の学びをサポート</p>
                  </li>
                </ul>
                <p class="p_courseCard_solution_desc">学校の進度やテスト範囲、お子様の理解度に合わせて個別に学習を設計。行動科学マネジメント&#174;の視点から正しい勉強のやり方を指導し、テスト対策だけでなく毎日の勉強の進め方までサポートします。</p>
              </div>
            </div>
            <div class="p_courseCard_footer">
              <div class="e_button _pink _center">
                <a href="<?php echo esc_url( home_url( '/course/school' ) ); ?>">詳しく見る &nbsp;&rsaquo;</a>
              </div>
            </div>
          </div>

          <!-- 小学生コース -->
          <div class="p_courseCard _blue">
            <div class="p_courseCard_header">
              <div class="p_courseCard_heroImage">
                <picture>
                  <source srcset="<?php echo $imgUri; ?>/home/course_schoolchild.webp" type="image/webp">
                  <img src="<?php echo $imgUri; ?>/home/course_schoolchild.jpg" alt="小学生コース">
                </picture>
              </div>
              <span class="p_courseCard_target">対象学年｜小学1〜6年生</span>
              <h3 class="p_courseCard_title"><span>小学生</span>コース</h3>
              <p class="p_courseCard_subtitle">「わかった！」「できた！」で<br>学ぶ楽しさを育てます。</p>
            </div>
            <div class="p_courseCard_body">
              <div class="p_courseCard_worries">
                <h4 class="p_courseCard_worries_title">
                  <span class="p_courseCard_worries_icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6 2 1 6 1 11c0 3 2 6 5 7l-2 5 7-3c7 0 12-4 12-9S18 2 12 2Z"/><g fill="white"><circle cx="7" cy="11" r="1.2"/><circle cx="12" cy="11" r="1.2"/><circle cx="17" cy="11" r="1.2"/></g></svg>
                  </span>
                  こんなお悩みありませんか？
                </h4>
                <ul class="p_courseCard_worries_list">
                  <li>一人では勉強を<br>進めることが<br>できない</li>
                  <li>苦手教科をそのまま<br>にしていて、<br>将来が心配</li>
                  <li>勉強のやり方が<br>分かっていないのでは、<br>と感じる</li>
                </ul>
              </div>
              <div class="p_courseCard_solution">
                <h4 class="p_courseCard_solution_title">
                  <span class="p_courseCard_solution_icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 17c0-3-3-3-3-8a7 7 0 0 1 14 0c0 5-3 5-3 8Z"/><path d="M8 20h8m-6 3h4M12 0v-2M3 3 1 1m20 2 2-2"/></svg>
                  </span>
                  個別指導専門塾ならこう変わる
                </h4>
                <ul class="p_courseCard_solution_list">
                  <li>
                    <span class="p_courseCard_solution_listIcon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </span>
                    <p>理解度に合わせて学習内容を一人ひとり設計</p>
                  </li>
                  <li>
                    <span class="p_courseCard_solution_listIcon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </span>
                    <p>行動科学マネジメント&#174;に基づき、ノートの取り方から勉強のやり方を指導</p>
                  </li>
                  <li>
                    <span class="p_courseCard_solution_listIcon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22V12M12 15C3 16 2 9 3 5c7-1 10 4 9 10Zm0-2C11 6 16 3 22 4c0 7-4 10-10 9Z"/></svg>
                    </span>
                    <p>家庭学習の習慣化と自主性をしっかりサポート</p>
                  </li>
                </ul>
                <p class="p_courseCard_solution_desc">一人ひとりの理解度に合わせて学習内容を組み立て、行動科学マネジメント&#174;の視点からノートの取り方など勉強のやり方そのものを指導。家庭学習の習慣化まで丁寧にサポートします。</p>
              </div>
            </div>
            <div class="p_courseCard_footer">
              <div class="e_button _blue _center">
                <a href="<?php echo esc_url( home_url( '/course/schoolchild' ) ); ?>">詳しく見る &nbsp;&rsaquo;</a>
              </div>
            </div>
          </div>

        </div><!-- /p_courseCards -->
      </div>
    </div>
  </div><!-- /p_course -->
  <div class="p_movie">
    <div class="l_inner">
      <div class="e_heading-wrap mb3">
        <h2 class="e_heading _large _pink">
          <span class="e_heading_en">MOVIE</span>
          <span class="e_heading_jp">個人指導専門塾</span>
        </h2>
      </div>
      <video controls src="<?php echo $imgUri; ?>home/movie.mp4" poster="https://senmonjuku.com/wp-content/uploads/2024/05/video_poster-scaled.jpg"></video>
    </div>
  </div>
  <div class="p_school">
    <div class="p_school_top">
      <picture>
        <source media="(min-width: 1024px)" srcset="<?php echo $imgUri; ?>home/xl_school_image.webp" type="image/webp">
        <source media="(min-width: 1024px)" srcset="<?php echo $imgUri; ?>home/xl_school_image.jpg">
        <source srcset="<?php echo $imgUri; ?>/home/sm_school_image.webp" type="image/webp">
        <img src="<?php echo $imgUri; ?>/home/sm_school_image.jpg">
      </picture>
    </div>
    <div class="l_inner">
      <div class="e_heading-wrap mb2">
        <h2 class="e_heading _large _white">
          <span class="e_heading_en">SCHOOL</span>
          <span class="e_heading_jp">教室紹介</span>
        </h2>
      </div>
      <h3 class="e_heading_message _white mb3">愛知・岐阜を中心に展開中です</h3>

      <div class="p_schoolMap">
        <div class="p_schoolMap_left">
          <p class="p_schoolMap_leadText">お近くの教室を地図からご確認いただけます。<br>地図上のピンをクリックすると、教室の詳細情報がご覧いただけます。</p>
          <ul class="p_schoolMap_areaList">
          <?php
            $area_args = array(
              'orderby' => 'count',
              'order' => 'desc',
              'number' => 4,
            );
            $area_terms = get_terms('area', $area_args);
            foreach ( $area_terms as $term ):
          ?>
            <li class="p_schoolMap_areaList_item" data-area="<?php echo esc_attr( $term->slug ); ?>">
              <button type="button" class="p_schoolMap_areaList_link" data-area="<?php echo esc_attr( $term->slug ); ?>">
                <span class="p_schoolMap_areaList_icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg></span>
                <span class="p_schoolMap_areaList_body">
                  <span class="p_schoolMap_areaList_name"><?php echo esc_html( $term->name ); ?>エリア</span>
                </span>
                <span class="p_schoolMap_areaList_number"><?php echo esc_html( $term->count ); ?><small>校舎</small></span>
              </button>
            </li>
          <?php endforeach; ?>
          </ul>
        </div>

        <div class="p_schoolMap_right">
          <div id="js-schoolMapCanvas" class="p_schoolMap_canvas"></div>
        </div>
      </div>

      <div class="e_button _line _lineWhite _center p_schoolMap_cta">
        <a href="<?php echo esc_url( home_url( '/school' ) ); ?>">校舎一覧を見る</a>
      </div>
    </div>
  </div><!-- /p_school -->
  <div class="p_blog">
    <div class="l_inner">
      <div class="e_heading-wrap mb3">
        <h2 class="e_heading _pink _large">
          <span class="e_heading_en">BLOG</span>
          <span class="e_heading_jp">新着ブログ</span>
        </h2>
      </div> 
      <?php
        $args = array(
          'post_type' => 'post', // 投稿タイプのスラッグを指定
          'posts_per_page' => 3 // 投稿件数の指定
        );
        $post_query = new WP_Query($args); if($post_query->have_posts()):
      ?>
      <ul class="c_blogList">
        <?php while ($post_query->have_posts()): $post_query->the_post(); ?>
        <?php $category = get_the_category(); ?>
        <li class="c_blogList_item">
          <a href="<?php the_permalink(); ?>">
            <article>
              <div class="c_blogList_text">
                <time datetime="<?php the_time('Y-m-d'); ?>" class="c_blogList_date"><?php the_time('Y/m/d'); ?></time>
                <p class="c_blogList_title"><?php echo get_the_title(); ?></p>
              </div>
              <div class="c_blogList_image">
                <span class="c_blogList_cat"><?php echo $category[0]->cat_name; ?></span>
                <?php if (has_post_thumbnail()) : ?>
                  <?php the_post_thumbnail(); ?>
                <?php else: ?>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/image/common/thumbnail_noimage.jpg" alt="NO IMAGE">
                <?php endif; ?>
              </div>
            </article>
          </a>
        </li>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </ul>
      <?php else: ?>
      <?php endif; ?>
		<div class="e_button _line _linePink _center mt3">
      <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">他のブログを見る</a>
    </div>
    </div>
  </div><!-- /p_blog -->
	<?php /*
  <div class="p_pickup">
    <div class="l_inner">
      <div class="e_heading-wrap mb3">
        <h2 class="e_heading _pink _large">
          <span class="e_heading_en">PICK UP</span>
          <span class="e_heading_jp">人気記事</span>
        </h2>
      </div> 
      <ul class="c_blogList">
          <?php if ( get_option('pickup_post_url1') ) : ?>
          <?php
            $pickup_post_url1 = get_option('pickup_post_url1') ;
            $keys = parse_url($pickup_post_url1); //パース処理
            $path = explode("/", $keys['path']); //分割処理
            $last = end($path); //最後の要素を取得
            $data = get_page_by_path($last, OBJECT, 'post');
            $post_id = $data->ID;
            $date = get_the_date('Y/m/d', $post_id);
            $title = get_the_title($post_id);
            $category = get_the_category($post_id);
          ?>
          <li class="c_blogList_item">
            <a href="<?php echo $pickup_post_url1 ?>">
              <article>
                <div class="c_blogList_text">
                <time class="c_blogList_date"><?php echo $date ?></time>
                <p class="c_blogList_title"><?php echo $title ?></p>
                </div>
                <div class="c_blogList_image">
                  <span class="c_blogList_cat"><?php echo $category[0]->cat_name; ?></span>
                  <?php if (has_post_thumbnail($post_id)) : ?>
                    <?php echo get_the_post_thumbnail($post_id); ?>
                  <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/common/thumbnail_noimage.jpg" alt="NO IMAGE">
                  <?php endif; ?>
                </div>
              </article>
            </a>
          </li>
          <?php else: ?>
        <?php endif; ?>
        <?php if ( get_option('pickup_post_url2') ) : ?>
          <?php
            $pickup_post_url2 = get_option('pickup_post_url2') ;
            $keys = parse_url($pickup_post_url2); //パース処理
            $path = explode("/", $keys['path']); //分割処理
            $last = end($path); //最後の要素を取得
            $data = get_page_by_path($last, OBJECT, 'post');
            $post_id = $data->ID;
            $date = get_the_date('Y/m/d', $post_id);
            $title = get_the_title($post_id);
            $category = get_the_category($post_id);
          ?>
          <li class="c_blogList_item">
            <a href="<?php echo $pickup_post_url2 ?>">
              <article>
                <div class="c_blogList_text">
                <time class="c_blogList_date"><?php echo $date ?></time>
                <p class="c_blogList_title"><?php echo $title ?></p>
                </div>
                <div class="c_blogList_image">
                  <span class="c_blogList_cat"><?php echo $category[0]->cat_name; ?></span>
                  <?php if (has_post_thumbnail($post_id)) : ?>
                    <?php echo get_the_post_thumbnail($post_id); ?>
                  <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/common/thumbnail_noimage.jpg" alt="NO IMAGE">
                  <?php endif; ?>
                </div>
              </article>
            </a>
          </li>
          <?php else: ?>
        <?php endif; ?>
        <?php if ( get_option('pickup_post_url3') ) : ?>
          <?php
            $pickup_post_url3 = get_option('pickup_post_url3') ;
            $keys = parse_url($pickup_post_url3); //パース処理
            $path = explode("/", $keys['path']); //分割処理
            $last = end($path); //最後の要素を取得
            $data = get_page_by_path($last, OBJECT, 'post');
            $post_id = $data->ID;
            $date = get_the_date('Y/m/d', $post_id);
            $title = get_the_title($post_id);
            $category = get_the_category($post_id);
          ?>
          <li class="c_blogList_item">
            <a href="<?php echo $pickup_post_url3 ?>">
              <article>
                <div class="c_blogList_text">
                <time class="c_blogList_date"><?php echo $date ?></time>
                <p class="c_blogList_title"><?php echo $title ?></p>
                </div>
                <div class="c_blogList_image">
                  <span class="c_blogList_cat"><?php echo $category[0]->cat_name; ?></span>
                  <?php if (has_post_thumbnail($post_id)) : ?>
                    <?php echo get_the_post_thumbnail($post_id); ?>
                  <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/common/thumbnail_noimage.jpg" alt="NO IMAGE">
                  <?php endif; ?>
                </div>
              </article>
            </a>
          </li>
          <?php else: ?>
        <?php endif; ?>
      </ul>
		  div class="e_button _line _linePink _center mt3">
        <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">他のブログを見る</a>
      </div>
    </div>
  </div><!-- /p_pickup -->
  */ ?>
  <div class="p_media">
    <div class="l_inner">
      <div class="e_heading-wrap mb2">
        <h2 class="e_heading _pink _large">
          <span class="e_heading_en">MEDIA</span>
          <span class="e_heading_jp">メディア掲載実績</span>
        </h2>
      </div>
      <h3 class="e_heading_message _pink mb3">TVや雑誌など<br>複数のメディアで<br>ご紹介いただきました</h3>
    </div>
    <div class="p_mediaSlider">
      <div class="swiper js-mediaSliderLeft">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <picture>
              <source srcset="<?php echo $imgUri; ?>home/media_01.webp" type="image/webp">
              <img src="<?php echo $imgUri; ?>home/media_01.jpg">
            </picture>
          </div>
          <div class="swiper-slide">
            <picture>
              <source srcset="<?php echo $imgUri; ?>home/media_02.webp" type="image/webp">
              <img src="<?php echo $imgUri; ?>home/media_02.jpg">
            </picture>
          </div>
          <div class="swiper-slide">
            <picture>
              <source srcset="<?php echo $imgUri; ?>home/media_03.webp" type="image/webp">
              <img src="<?php echo $imgUri; ?>home/media_03.jpg">
            </picture>
          </div>
          <div class="swiper-slide">
            <picture>
              <source srcset="<?php echo $imgUri; ?>home/media_04.webp" type="image/webp">
              <img src="<?php echo $imgUri; ?>home/media_04.jpg">
            </picture>
          </div>
          <div class="swiper-slide">
            <picture>
              <source srcset="<?php echo $imgUri; ?>home/media_05.webp" type="image/webp">
              <img src="<?php echo $imgUri; ?>home/media_05.jpg">
            </picture>
          </div>
          <div class="swiper-slide">
            <picture>
              <source srcset="<?php echo $imgUri; ?>home/media_06.webp" type="image/webp">
              <img src="<?php echo $imgUri; ?>home/media_06.jpg">
            </picture>
          </div>
          <div class="swiper-slide">
            <picture>
              <source srcset="<?php echo $imgUri; ?>home/media_07.webp" type="image/webp">
              <img src="<?php echo $imgUri; ?>home/media_07.jpg">
            </picture>
          </div>
          <div class="swiper-slide">
            <picture>
              <source srcset="<?php echo $imgUri; ?>home/media_08.webp" type="image/webp">
              <img src="<?php echo $imgUri; ?>home/media_08.jpg">
            </picture>
          </div>
          <div class="swiper-slide">
            <picture>
              <source srcset="<?php echo $imgUri; ?>home/media_09.webp" type="image/webp">
              <img src="<?php echo $imgUri; ?>home/media_09.jpg">
            </picture>
          </div>
          <div class="swiper-slide">
            <picture>
              <source srcset="<?php echo $imgUri; ?>home/media_10.webp" type="image/webp">
              <img src="<?php echo $imgUri; ?>home/media_10.jpg">
            </picture>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /p_media -->
	<?php /*
  <div class="p_contact">
    <div class="l_inner">
      <div class="e_heading-wrap mb3">
        <h2 class="e_heading _large">
          <span class="e_heading_en">CONTACT</span>
          <span class="e_heading_jp">各種お問い合わせ</span>
        </h2>
      </div>
      <ul class="c_contactList flex">
        <li class="c_contactList_item _line">
          <a href="https://line.me/R/ti/p/%40203ijfkj">
            <picture>
              <source srcset="<?php echo $imgUri; ?>common/contact_banner_line.webp" type="image/webp">
              <img src="<?php echo $imgUri; ?>common/contact_banner_line.png">
            </picture>
          </a>
        </li>
        <li class="c_contactList_item _form">
          <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">
          <div class="c_contactList_icon">
            <img src="<?php echo $imgUri; ?>common/contact_icon_mail_black.svg" alt="メールのアイコン">
          </div>
          <p class="c_contactList_text">フォームでのお問い合わせはこちら</p>
          </a>
        </li>
        <li class="c_contactList_item _tel">
          <a href="tel:0120-187-703">
            <div class="c_contactList_icon">
              <img src="<?php echo $imgUri; ?>common/contact_icon_phone_black.svg" alt="メールのアイコン">
              <p>0120-187-703</p>
            </div>
            <p class="c_contactList_text">お電話でのお問い合わせはこちらをタップ！</p>
          </a>
        </li>
      </ul>
      <?php // get_template_part( 'parts/ctaBannar' ); ?>
    </div>
  </div><!-- /p_contact -->
  */ ?>
</div>
<?php get_footer();?>