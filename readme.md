<h1>概要</h1>
<p>お笑いが好きな人や、お笑い芸人が相方を探すためのマッチングサイト</p>

<h1>特筆すべき機能</h1>
<ol>
    <li>相性の良い相方を表示させる機能</li>
    <ul>
      <li>ボケの芸人に対してツッコミの芸人を表示させるなど、5項目で選定</li>
      <li>マッチング率表示</li>
    </ul>
    <li>ページネーション付き検索機能</li>
    <ul>
      <li>おみくじ検索（ランダムで１名表示）</li>
      <li>AND検索、OR検索</li>
      <li>キーワード検索（半角・全角スペースで区切られた複数のキーワードの検索も可能）</li>
      <li>並び替え（人気順、新規登録順、年齢が若い順、ランダム順）</li>
    </ul>
    <li>ダイレクトメッセージ機能</li>
    <ul>
      <li>受信メッセージ・送信済みメッセージの表示</li>
      <li>未読・既読表示の切り替え<li>
      <li>未読メッセージ数をバッヂで表示</li>
    </ul>
    <li>閲覧履歴・あしあと機能</li>
    <ul>
      <li>自己が、プロフィール詳細を閲覧した芸人を、最新の10名表示</li>
      <li>自己のプロフィール詳細を閲覧した芸人を、最新の20名表示</li>
    </ul>
    <li>お気に入り登録機能</li>
    <ul>
      <li>お気に入り登録後、解除ボタン表示</li>
      <li>お気に入り解除後、登録ボタン表示</li>
      <li>登録数をバッヂで表示</li>
    </ul>
</ol>  

<h2>その他の機能</h2>
<ul>
    <li>ランキング機能（お気に入り登録された数に基づく）</li>
    <li>メッセージ受信時お知らせメール送信機能（AWSのSES利用）</li>
    <li>プロフィール画像アップロード機能(AWSのS3保存)</li>
    <li>プロフィール編集機能</li>
    <li>新規登録・ログイン・ログアウト機能</li>
    <li>パスワード変更・アカウント削除機能</li>
    <li>Twitterのシェアボタン機能</li>
    <li>地図表示（Google Map API利用）</li>    
    <li>Featureテスト機能</li>
</ul>

<h1>技術</h1>
<ol>
    <li>php7.3.3, Laravel5.8.15</li>
    <li>Bootstrap4</li>
    <li>MySQL5.7.25</li>
    <li>AWS</li>
    <ul>
      <li>EC2へデプロイ</li>
      <li>Route53でDNSレコードを管理</li>
      <li>ACMでSSL証明書を管理、ALBで使用</li>
    </ul>
    <li>Docker、Laradock</li>
</ol>
