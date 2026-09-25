# 本番公開チェックリスト

すべてのプレビュー（TOP／教室紹介／お問い合わせ）でお客様の承認が取れた後、
本番に反映するためにやるべきことをまとめたもの。

- 更新日: 2026-08-31
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

- [ ] `templates/home-2026-new-design.php` の中身（MESSAGE・COURSEの変更点）を `templates/home.php` に統合する
- [ ] `templates/home-2026-new-design.php` を削除する
- [ ] `functions.php` の以下2箇所から `|| is_page_template('templates/home-2026-new-design.php')` を削除する
  - CSS読み込み条件（`home_style`）
  - JS読み込み条件（`home`, `swiper`, `swiper-works`）
- [ ] `_message.scss` / `_course.scss` にある `._renewal` 修飾クラスのスコープを外し、通常のスタイルとして統合する（`&._renewal &_text` のような分岐をやめて、値を直接書く）
- [ ] 確認用固定ページ「トップ更新プレビュー」（スラッグ `top-2026-preview`、投稿ID 18891）を削除する

### 未着手のまま残っている項目（TODO）
- [ ] SCHOOL（教室紹介のMAP化）… `docs/top-page-renewal-spec.md` 参照
- [ ] CTA画像・フッター固定ボタン画像の反映

---

## 2. 教室紹介ページ（講師紹介ポップアップ＋教室内の様子）

`single-school.php` は投稿タイプ共有のテンプレートなので、TOPページのような複製ではなく
**URLパラメータでの出し分け**方式を使っている。

- [ ] `single-school.php` 冒頭の `$is_school_preview` 判定と `if ($is_school_preview): ... endif;` の分岐を外し、常時表示にする
  - `$is_school_preview = isset($_GET['school_preview']) && $_GET['school_preview'] === '0c82b980';` の行を削除
  - 講師紹介・ギャラリーのブロックを囲っている `if` を削除（中身はそのまま残す）
- [ ] 「教室内の様子」用のACFフィールド（画像＋キャプションのリピーター等）を新規追加する
  - 現状はプレースホルダー（教室のアイキャッチ画像を4回使い回し、キャプションは固定文言）
  - 追加後、`single-school.php` 内のプレースホルダー部分（`$gallery_placeholder_image` を使っている箇所）を、実際のACFフィールドを使う実装に差し替える
- [ ] `_school.scss` に残っているコメント（「【確認用】」「【仮】」表記）を整理する

※ 講師紹介ポップアップ（MicroModal）は既に実データ（`teacher`投稿の`classroom_url`逆引き）で動いているので、これ自体は追加対応不要。

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

（`templates/home-2026-new-design.php` / `templates/contact-draft.php` はこの時点で削除済みのはず）
