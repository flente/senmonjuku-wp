// SCHOOL（教室紹介）地図化：Leafletで教室ピンを表示し、クリックでポップアップ表示する。
// データは functions.php の senmonjuku_get_school_map_data() が wp_localize_script で
// window.schoolMapData として渡している（school_lat/school_lng未入力の校舎はPHP側で除外済み）。
(function(){
  // school_lat/school_lngがまだ未入力の間はここが空配列になる（バックフィル待ち）
  var schools = (window.schoolMapData && window.schoolMapData.schools) || [];

  // 校舎データがまだ無いエリア用の暫定表示位置（バックフィル完了後は実データのbounds優先で使われなくなる）
  var AREA_FALLBACK_VIEW = {
    nagoya: { center: [35.155, 136.940], zoom: 12 },
    owari:  { center: [35.257, 136.948], zoom: 11 },
    mikawa: { center: [34.998, 137.103], zoom: 11 },
    gifu:   { center: [35.411, 136.758], zoom: 13 }
  };
  var DEFAULT_VIEW = { center: [35.15, 137.0], zoom: 9 };

  function pinIcon(color){
    var svg = '<svg class="p_schoolMap_pin" viewBox="0 0 30 38" xmlns="http://www.w3.org/2000/svg">' +
      '<path fill="' + color + '" d="M15 0C6.7 0 0 6.7 0 15c0 10.5 15 23 15 23s15-12.5 15-23C30 6.7 23.3 0 15 0Z"/>' +
      '<circle cx="15" cy="15" r="6" fill="#fff"/></svg>';
    return L.divIcon({
      html: svg,
      className: '',
      iconSize: [30, 38],
      iconAnchor: [15, 38],
      popupAnchor: [0, -34]
    });
  }

  function popupHtml(s){
    return '' +
      '<div class="p_schoolMap_card">' +
        '<span class="p_schoolMap_card_area" style="background-color:' + s.color + '">' + s.areaName + '</span>' +
        '<p class="p_schoolMap_card_name">' + s.name + '</p>' +
        '<p class="p_schoolMap_card_address">' + (s.address || '') + '</p>' +
        '<div class="p_schoolMap_card_image"><img src="' + s.image + '" alt=""></div>' +
        '<a class="p_schoolMap_card_button" href="' + s.url + '">詳しく見る &gt;</a>' +
      '</div>';
  }

  document.addEventListener('DOMContentLoaded', function(){
    var canvas = document.getElementById('js-schoolMapCanvas');
    if (!canvas || typeof L === 'undefined') return;

    var map = L.map(canvas, { scrollWheelZoom: false, zoomControl: false }).setView(DEFAULT_VIEW.center, DEFAULT_VIEW.zoom);

    // Jawg Terrain：design-preview検証用のアクセストークンをそのまま本番でも使用
    // （本来は本番専用トークンの発行が望ましいが、当面はこのトークンを流用する方針で確定）
    L.tileLayer('https://{s}.tile.jawg.io/jawg-terrain/{z}/{x}/{y}{r}.png?access-token=qDG8FS0ITfNWV7zWaB4sfGz8nLbPiwECrAlqW2d1xIjOjI9XOXZbo7mJN7lXt6oD', {
      maxZoom: 22,
      subdomains: 'abcd',
      attribution: '<a href="https://www.jawg.io" target="_blank" rel="noopener">&copy; Jawg</a> - <a href="https://www.openstreetmap.org" target="_blank" rel="noopener">&copy; OpenStreetMap</a>&nbsp;contributors'
    }).addTo(map);
    map.attributionControl.setPosition('bottomleft');
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    // 現在地ボタン（Googleマップの現在地アイコンボタン風）
    var LocateControl = L.Control.extend({
      options: { position: 'bottomright' },
      onAdd: function(){
        var container = L.DomUtil.create('div', 'leaflet-bar p_schoolMap_locate');
        var link = L.DomUtil.create('a', '', container);
        link.href = '#';
        link.title = '現在地から探す';
        link.setAttribute('role', 'button');
        link.setAttribute('aria-label', '現在地から探す');
        link.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="8"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/><circle cx="12" cy="12" r="2"/></svg>';
        L.DomEvent.disableClickPropagation(container);
        L.DomEvent.on(link, 'click', function(e){
          L.DomEvent.preventDefault(e);
          if (!navigator.geolocation) return;
          link.classList.add('is-loading');
          navigator.geolocation.getCurrentPosition(function(pos){
            var latlng = [pos.coords.latitude, pos.coords.longitude];
            map.setView(latlng, 12);
            L.marker(latlng).addTo(map).bindPopup('現在地').openPopup();
            link.classList.remove('is-loading');
          }, function(){
            link.classList.remove('is-loading');
          });
        });
        return container;
      }
    });
    map.addControl(new LocateControl());

    // 校舎ピンを設置し、エリアごとにもマーカーをまとめておく（エリアボタンでのbounds計算用）
    var markersByArea = {};
    schools.forEach(function(s){
      var marker = L.marker([s.lat, s.lng], { icon: pinIcon(s.color) })
        .addTo(map)
        .bindPopup(popupHtml(s), { className: 'p_schoolMap_popup', closeButton: true, maxWidth: 240, minWidth: 200, autoPanPadding: [16, 16] });
      if (!markersByArea[s.area]) markersByArea[s.area] = [];
      markersByArea[s.area].push(marker);
    });

    // エリアリストのボタン：ページ遷移せず、地図上でそのエリアへ移動する
    // 実データがあればそのエリアの校舎群にfitBounds、まだ無ければ暫定位置にフォールバック
    var areaButtons = document.querySelectorAll('.p_schoolMap_areaList_link');
    areaButtons.forEach(function(btn){
      btn.addEventListener('click', function(){
        var area = btn.dataset.area;
        areaButtons.forEach(function(b){ b.classList.remove('is-active'); });
        btn.classList.add('is-active');

        var markers = markersByArea[area];
        if (markers && markers.length) {
          var group = L.featureGroup(markers);
          map.flyToBounds(group.getBounds().pad(0.3), { maxZoom: 14 });
        } else if (AREA_FALLBACK_VIEW[area]) {
          map.flyTo(AREA_FALLBACK_VIEW[area].center, AREA_FALLBACK_VIEW[area].zoom);
        }
      });
    });

  });
})();
