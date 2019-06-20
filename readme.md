<h1>概要</h1>
<p>お笑い芸人が相方を探すためのマッチングサイト</p>

<h1>機能</h1>
<ol>
    <li>相性の良い相方を表示させる機能（ボケの芸人に対してツッコミの芸人を表示させるなど、４項目で選定）</li>
    <li>ページネーション付き検索機能</li>
    <li>ダイレクトメッセージ機能・受信時お知らせメール送信機能</li>
    <li>お気に入り登録・解除機能</li>
    <li>プロフィール画像アップロード機能(AWSのS3保存)</li>
    <li>プロフィール編集機能</li>
    <li>新規登録・ログイン・ログアウト機能</li>
    <li>Twitterのシェアボタン機能</li>
    <li>地図表示（Google Map API利用）</li>    
    <li>登録者データのCSVエクスポート機能</li>
    <li>Featureテスト機能</li>
</ol>

<h1>技術</h1>
<ol>
    <li>php7.3.3, Laravel5.8.15</li>
    <li>Bootstrap4</li>
    <li>MySQL5.7.25</li>
    <li>AWS</li>
    <ul>
      <li>EC2にデプロイ</li>
      <li>Route53でDNSレコードを管理</li>
      <li>ACMでSSL証明書を管理</li>
    </ul>
    <li>Docker,Laradock</li>
</ol>
