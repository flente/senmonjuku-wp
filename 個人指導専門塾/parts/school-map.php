<?php
$school_map_is_archive = is_post_type_archive('school') || is_tax('area');
$school_map_current_area = is_tax('area') ? get_queried_object()->slug : '';
?>
      <div class="p_schoolMap">
        <div class="p_schoolMap_left">
          <p class="p_schoolMap_leadText">お近くの教室を地図からご確認いただけます。<br>地図上のピンをクリックすると、教室の詳細情報がご覧いただけます。</p>
          <ul class="p_schoolMap_areaList">
          <?php if ($school_map_is_archive): ?>
            <li class="p_schoolMap_areaList_item">
              <button type="button" class="p_schoolMap_areaList_link<?php echo $school_map_current_area === '' ? ' is-active' : ''; ?>" data-area="" aria-pressed="<?php echo $school_map_current_area === '' ? 'true' : 'false'; ?>">すべてのエリア</button>
            </li>
          <?php endif; ?>
          <?php
            $area_args = array(
              'orderby' => 'count',
              'order' => 'desc',
              'number' => 4,
            );
            $area_terms = get_terms('area', $area_args);
            if (!is_wp_error($area_terms)):
            foreach ( $area_terms as $term ):
          ?>
            <li class="p_schoolMap_areaList_item" data-area="<?php echo esc_attr( $term->slug ); ?>">
              <button type="button" class="p_schoolMap_areaList_link<?php echo $school_map_current_area === $term->slug ? ' is-active' : ''; ?>" data-area="<?php echo esc_attr($term->slug); ?>" aria-pressed="<?php echo $school_map_current_area === $term->slug ? 'true' : 'false'; ?>">
                <span class="p_schoolMap_areaList_icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg></span>
                <span class="p_schoolMap_areaList_body">
                  <span class="p_schoolMap_areaList_name"><?php echo esc_html( $term->name ); ?>エリア</span>
                </span>
                <span class="p_schoolMap_areaList_number"><?php echo esc_html( $term->count ); ?><small>校舎</small></span>
              </button>
            </li>
          <?php endforeach; endif; ?>
          </ul>
        </div>

        <div class="p_schoolMap_right">
          <div id="js-schoolMapCanvas" class="p_schoolMap_canvas"></div>
        </div>
      </div>
