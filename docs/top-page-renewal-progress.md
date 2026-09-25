# TOPページ改修 進捗状況

- 更新日: 2026-08-30
- 対象ブランチ: `feature/top-2026-preview`
- 関連: [top-page-renewal-spec.md](./top-page-renewal-spec.md)

---

## 全体ステータス

| セクション | ステータス |
|---|---|
| MESSAGE（実績＋メッセージ） | ✅ 完了・社内確認OK |
| COURSE（コース紹介） | ✅ 完了・社内確認OK |
| SCHOOL（教室紹介のMAP化） | 🔲 **TODO**（後回し。要件整理のみ完了、実装未着手） |
| CTA画像・フッター固定ボタン画像 | 🔲 **TODO**（後回し。画像は受領済みだが反映は未実施） |
| お客様への確認 | 🔲 未実施（社内確認のみ。プレビューURLをまだ見せていない） |

---

## TODO（後回しにしている項目）

### TODO① SCHOOL（教室紹介のMAP化）
- 地図ライブラリの選定（Google Maps有料 / Leaflet無料）
- `school`投稿にACFフィールド追加（Googleマップ型フィールド＋対象学年・指導形態・開校時間）
- 既存14校舎分のデータ入力
- 地図UI本体（ピン・ポップアップ・エリア絞り込み・地図/リスト切替）の実装
- 方針は[top-page-renewal-spec.md](./top-page-renewal-spec.md)にまとめ済み

### TODO② CTA画像
- お客様から新しいCTA画像（`cta-regenerated-hq.png`）を受領済みだが、まだどこにも反映していない
- TOPページの`parts/ctaBannar.php`呼び出しは今もコメントアウトされたまま（有効化するかどうか未決定）
- サイト全体共通のフッター固定ボタン画像（`xl_contact_fixed_button.png`）の差し替えも保留中（お客様から改めて画像共有予定、全ページ影響のため要合意の上で対応）

---

## やったこと

### 1. git管理・リモート
- `senmonjuku-wp`をgit管理下に置き、`git@github.com:uma1100/senmonjuku-wp.git`にpush
- `main`ブランチ＝現状ベースライン＋仕様書、`feature/top-2026-preview`ブランチ＝今回の実装

### 2. 仕様整理
- `docs/top-page-renewal-spec.md`にMESSAGE/COURSE/SCHOOL-MAP/CTAの要件と未確定事項を整理
- ACF Pro導入済みであることをサーバーのプラグイン一覧で確認済み（`advanced-custom-fields-pro`）

### 3. 確認用プレビューページの仕組み
- `templates/home.php`を複製して`templates/home-draft.php`を作成（Template Name: `HOME(2026 Preview)`）
- `functions.php`に、`is_front_page()`の条件へ`|| is_page_template('templates/home-draft.php')`を追記（CSS/JSがプレビューページでも読み込まれるように。既存の分岐は変更なし）
- ACFの「HOME」フィールドグループが「テンプレートがHOME」限定の表示条件だった問題は、**本番の実際のTOPページ（投稿ID 13343）をDuplicate Postプラグインで複製し、複製後にテンプレートだけ`HOME(2026 Preview)`に変更**する方式で解決
- 確認用ページ：投稿ID 18891「トップ更新プレビュー」／スラッグ`top-2026-preview`／パスワード保護
- **判明した不具合（修正済み）**：このテーマのカスタムテンプレート（`home.php`系全般）は`post_password_required()`を一切呼んでおらず、パスワード保護設定が実質機能していなかった。`home-draft.php`にはチェックを追加済み。**同じ問題が本番`home.php`や他のカスタムテンプレートにも残っている可能性があり、要フォロー**

### 4. ローカルデザイン検証ワークフロー
- `design-preview/`フォルダを作成し、本番ページのHTML保存データを元に、WordPress/PHP不要でブラウザ直接確認できる静的HTMLを用意
- ここでMESSAGE/COURSEの細かいレイアウト・余白・フォントサイズ・アイコンを高速に反復調整
- 確定後、`home-draft.php`・`_message.scss`・`_course.scss`にPHP化して反映（gitでは管理せず、ローカル作業用）

### 5. デプロイ用フォルダ（gitでは管理せず、ローカルのFTP作業用）
```
deploy/
├─ README.md                     … 手順書
├─ update-top-2026-preview/      … アップロードする新しい状態
├─ backup-before-preview/        … ロールバック用の変更前オリジナル
└─ production-current/           … 本番の実ファイルを置いて差分確認する用
```

2026-09-25: 確認用テンプレートを `templates/home-2026-new-design.php` に改名し、管理画面の表示名を「2026年新デザイン」に変更。既存の確認用ページは、アップロード後にページ編集画面で新しいテンプレートを選び直す必要がある。

### 6. 実装内容（`templates/home-draft.php`）
- **MESSAGE**：画像①のコピーに差し替え＋指導実績25年／卒業生2,350名／成績アップ率92%の実績バッジ3点を追加。アイコンはLucideに統一。メディア掲載実績は既存の`media_01〜10`画像をそのまま再利用してグリッド化（既存スライダーも維持したまま重複させていない）
- **COURSE**：中学生コース（赤）／小学生コース（青）それぞれに、対象者・指導形態・料金の目安・特徴とメリットの項目リスト（Lucideの丸アイコンバッジ付き、ラベルと説明文を横並び・上下中央揃え）を追加

---

## 見つかった問題と対応（解決済み）

### 本番相当データとのズレ確認
- 本番の`home.php`をダウンロードしてローカルのgit版と`diff`→差分ゼロ（同期に問題なし）
- バナースライダーが本番だけに見えたのは、ACFの`banner_slider`リピーターフィールドの中身が「そのページ固有のデータ」だったため。コードのズレではなかった

### CSSが本番に影響していた不具合
- `_message.scss`編集時、新レイアウト用のスタイルを追加するつもりが、本番でも使われている既存クラス`.p_message_text`のフォントサイズ・余白を直接上書きしてしまっていた
- 修正：`.p_message_text`を元の値に戻し、新レイアウト用の調整は`.p_message._renewal`（確認用ページ側にしか付いていない修飾クラス）配下だけに限定
- 以降のCSS追加もすべて`._renewal`スコープ、または本番未使用の新規クラスのみで対応し、`git diff main`で既存行の削除・変更が無いことを都度確認

### パスワード保護が効いていなかった不具合
- 上記「やったこと3」参照。`home-draft.php`に`post_password_required()`チェックを追加して解決

---

## 次にやること

1. **お客様にプレビューURL（`top-2026-preview`）を共有し、MESSAGE/COURSEのコメントをもらう**
2. OKが出たら`home-draft.php`の内容を本番`templates/home.php`にマージし、`home-draft.php`・関連の`functions.php`追記・パスワードチェックを整理／削除
3. TODO①：SCHOOL/MAPセクションの実装着手
4. TODO②：CTA画像・フッター固定ボタン画像の反映
