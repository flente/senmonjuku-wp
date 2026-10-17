# 本番公開チェックリスト

各ページのお客様承認後、本番に反映するためにやるべきことをまとめたもの。
教室詳細は公開承認済み。TOP／お問い合わせは個別に承認・反映する。

- 更新日: 2026-10-18
- 対象ブランチ: `feature/top-2026-preview`

---

## 0. 全体の流れ

1. お客様の最終承認を得る
2. 各ページごとに「下書き用の一時的な仕組み」を外し、本番テンプレートに正式反映
3. 一時的に作った確認用ページ（固定ページ）を削除
4. `feature/top-2026-preview` ブランチを `main` にマージ
5. 本番サーバーに最終ファイルをアップロード

---

## 1. TOPページ（MESSAGE / COURSE）

- [ ] `templates/home-draft.php` の中身（MESSAGE・COURSEの変更点）を `templates/home.php` に統合する
- [ ] `templates/home-draft.php` を削除する
- [ ] `functions.php` の以下2箇所から `|| is_page_template('templates/home-draft.php')` を削除する
  - CSS読み込み条件（`home_style`）
  - JS読み込み条件（`home`, `swiper`, `swiper-works`）
- [ ] `_message.scss` / `_course.scss` にある `._renewal` 修飾クラスのスコープを外し、通常のスタイルとして統合する（`&._renewal &_text` のような分岐をやめて、値を直接書く）
- [ ] 確認用固定ページ「トップ更新プレビュー」（スラッグ `top-2026-preview`、投稿ID 18891）を削除する

### 未着手のまま残っている項目（TODO）
- [ ] SCHOOL（教室紹介のMAP化）… `docs/top-page-renewal-spec.md` 参照
- [ ] CTA画像・フッター固定ボタン画像の反映

---

## 2. 教室紹介ページ（講師紹介ポップアップ＋教室内の様子）

教室詳細は本番公開承認済み。以下はローカルコードへの反映状況。

- [x] `single-school.php` のURLパラメータによる表示制限を解除
  - 通常の教室詳細URLで担当講師紹介・教室内の様子を表示する
  - 公開済みで教室に紐づく講師がいる場合のみ、講師紹介を表示する
  - `school_gallery` に登録がある場合のみ、ギャラリーを表示する（見出しも同条件）
- [x] ギャラリーをACFリピーターで実装済み（画像・タイトル・説明文、最大6件）
- [x] `_school.scss` の確認用コメントを整理
- [ ] 本番へ `single-school.php` を反映する
  - ギャラリー用ACF定義・講師モーダル・教室詳細CSSが未反映の場合は、`functions.php` と `assets/scss/page/school/index.css` も反映する
- [ ] 本番で講師モーダルの開閉、ギャラリー、データ未登録時の非表示を確認する


---

## 3. お問い合わせページ（フォーム簡易化）

- [ ] **MW WP Form（フォームID 354）の管理画面設定を編集し、項目を絞り込む**（要手動作業・ファイル編集では不可）
  - 残す項目：お名前／ふりがな／メールアドレス／電話番号／ご希望の教室（エリア）／学年／ご相談内容（チェックボックス：無料体験を希望・料金について知りたい・学習相談をしたい・その他）／自由記述（任意）
  - 削除する項目：当塾を何でお知りになりましたか／お子様の性別／郵便番号／都道府県／市区町村／以降の住所
  - 「お子様のお名前」「フリガナ」は「お名前」「ふりがな」に名称変更
- [ ] 実際のフォームで上記の絞り込みが完了したら、`templates/contact-draft.php` を削除する
- [ ] `functions.php` の `contact_style` 読み込み条件から `"templates/contact-draft.php"` を配列から削除する
- [ ] `_contact.scss` にある `._renewal` 修飾クラスのスコープを外し、通常のスタイルとして統合する
  - `padding-top` の隙間バグ修正、`width: 120rem` への拡大、`._simple` の2カラムグリッドを、`.p_contact` / `.p_contactForm_content` の基本スタイルに直接反映する
- [ ] 確認用固定ページ「お問い合わせ(2026 Preview)」（スラッグ `contact-2026-preview`）を削除する

---

## 4. 共通の後片付け

- [ ] `functions.php` の `$css_version`（現在 `'1.1.2-school-preview'`）を、分かりやすいバージョン名に整理する（任意）
- [ ] `deploy/` フォルダ配下の一時ファイルは、必要なくなればローカルで削除してよい（gitでは元々管理していない）
- [ ] `design-preview/`, `design-preview-school/`, `design-preview-contact/` も同様にローカルの作業用なので、不要になれば削除してよい
- [ ] `feature/top-2026-preview` ブランチを `main` にマージする（Pull Requestを作成してレビュー後にマージ、または直接マージ）
- [ ] マージ後の最終版を本番サーバーへ全体アップロード
- [ ] 本番URL（TOP／教室紹介ページ数点／お問い合わせ）を一通り目視確認する

---

## 5. 各ページの最終アップロード対象ファイル（マージ後の想定）

```
個人指導専門塾/
├─ functions.php
├─ templates/home.php
├─ single-school.php
├─ templates/contact.php
├─ assets/scss/page/home/index.css, index.min.css, _message.scss, _course.scss
├─ assets/scss/page/school/index.css, index.min.css, _school.scss
└─ assets/scss/page/contact/index.css, index.min.css, _contact.scss
```

（`templates/home-draft.php` / `templates/contact-draft.php` はこの時点で削除済みのはず）

## 教室一覧の地図追加・エリア連動（2026-10-18）

- [x] 教室一覧・エリア別一覧にTOPと共通の地図パーツを追加
- [x] 地図データは全エリア分を取得し、エリア別URLでは初期表示のピン・範囲を該当エリアに合わせる
- [x] 地図のボタンはページ内で地図だけを切り替える。プルダウンは従来どおりエリア別URLへ遷移
- [x] HTMLサンプルで地図ボタンがURL・一覧を変えずに地図のみ切り替えることをブラウザ確認
- [ ] `deploy/update-school-map/README.md` に従って本番反映し、WordPress実データで確認
