<?php get_header(); ?>
<?php $imgUri = get_theme_file_uri() . "/assets/image/"; ?>
<?php get_template_part( 'parts/subPageHeader' ); ?>
<div class="l_wrapper">
	<div class="c_archive">
		<div class="l_inner">
			<div class="p_schoolMapArchive mb3">
				<?php get_template_part('parts/school-map'); ?>
			</div>
			<div class="c_archive_search mb2">
			<?php
				$taxonomy_slug = 'area'; // タクソノミーのスラッグを指定
				$terms_args = array(
					'taxonomy' => $taxonomy_slug,
					'hide_empty' => false, // 空のタームも表示
					'meta_key' => 'order', // 並び替えに利用したいカスタムフィールドのキーを指定
					'orderby' => 'meta_value', // カスタムフィールドの値で並び替え
					'order' => 'ASC', // 昇順・降順
				);

				$terms = get_terms($terms_args); // タームの取得
				$current_term = single_term_title("", false);

				if ($terms && !is_wp_error($terms)) { // タームがあれば表示
					echo '<select name="select" onChange="location.href=value;">'; // option の value 値を URL とする
					echo '<option>'.$current_term.'</option>'; 
					echo '<option value="https://senmonjuku.com/school">すべて</option>';

					foreach ($terms as $value) { // 配列の繰り返し
						if ($value->name !== $current_term) {
							echo '<option value="'.get_term_link($value->slug, $taxonomy_slug).'">'.esc_html($value->name).'</option>'; // タームのURLとタイトルを表示
						}
					}

					echo '</select>';
				}
			?>
			</div>
			<?php
				$paged = get_query_var('paged') ? get_query_var('paged') : 1;
				$page_object = get_queried_object();
				$args = array(
					'post_type' => 'school',
					'tax_query' => array(
						array(
							'taxonomy' => 'area',
							'field' => 'slug',
							'terms' => $page_object->slug,
						),
					),
					'posts_per_page' => 0, // 表示する数
					'meta_key' => 'order', //並び替えに利用したいカスタムフィールドのキーを指定
					'orderby' => 'meta_value', //カスタムフィールドの値で並び替え
					'order' => 'ASC' ,// 昇順・降順
					'paged' => $paged,
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
			<p>まだ投稿がありません。</p>
			<?php endif; ?>
			<?php
				$count_posts = wp_count_posts('school');
				$published_posts = $count_posts->publish;
				if ($published_posts >= 12):
			?>
			<div class="c_pageNavi  mt3">
				<?php wp_pagenavi(); ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>