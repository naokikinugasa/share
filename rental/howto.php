<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit= new \MyAPP\Exhibit();

require_once(__DIR__.'/head.php');
?>

<div id="container">

<div id="howto">
<img src="images/howto.png" alt="" width="100%" height="100%;" />
</div>

<div id="cha" style="padding-top: 40px;">
<div id="char">
    <h2>ーレンタルのしかたー(パターン1)</h2>
        <div class="topNaviColumn">
        	<h2>1.商品を探す</h2>
                <div class="topNaviPhoto"><img src="images/projector3.jpg" alt="" /></div>
                <div class="topNaviDetail">レンタルしたい商品を商品一覧から探します。</div>
        </div><!-- /.topNaviColumn --></a>
        <div class="topNaviColumn">
            <h2>2.メッセージを送る</h2>
                <div class="topNaviPhoto"><img src="images/msg2.jpg" alt="" /></div>
                <div class="topNaviDetail">レンタルしたい商品が見つかったら、出品者にメッセージを送って日時・レンタル期間・受け渡し場所を決めます。</div>
        </div><!-- /.topNaviColumn -->
        <div class="topNaviColumn">
            <h2>3.レンタルする</h2>
                <div class="topNaviPhoto"><img src="images/watasu.png" alt="" /></div>
                <div class="topNaviDetail">メッセージで決めておいた場所に行って、出品者から商品を受け取り、料金を支払いましょう。</div>
        </div><!-- /.topNaviColumn -->
    <h2>ー出品のしかたー</h2>
        <div class="topNaviColumn">
            <h2>1.出品登録</h2>
                <div class="topNaviPhoto"><img src="images/syuppin.jpg" alt="" /></div>
                <div class="topNaviDetail">出品登録ページより出品したいものを登録します。</div>
        </div><!-- /.topNaviColumn --></a>
        <div class="topNaviColumn">
            <h2>2.メッセージでやりとり</h2>
                <div class="topNaviPhoto"><img src="images/msg2.jpg" alt="" /></div>
                <div class="topNaviDetail">メッシージをやり取りして、日時・レンタル期間・受け渡し場所を決めます。</div>
        </div><!-- /.topNaviColumn -->
        <div class="topNaviColumn">
            <h2>3.シェアする</h2>
                <div class="topNaviPhoto"><img src="images/watasu2.png" alt="" /></div>
                <div class="topNaviDetail">当日受け渡し場所に行って商品を渡し、料金を受け取りましょう。</div>
        </div><!-- /.topNaviColumn -->
</div>

<div id="char">
    <h2>ーレンタルのしかた(パターン2)ー</h2>
        <div class="topNaviColumn">
        	<h2>1.商品を探す</h2>
                <div class="topNaviPhoto"><img src="images/projector3.jpg" alt="" /></div>
                <div class="topNaviDetail">レンタルしたい商品を商品一覧から探します。</div>
        </div><!-- /.topNaviColumn --></a>
        <div class="topNaviColumn">
            <h2>2.予約する</h2>
                <div class="topNaviPhoto"><img src="images/7b55d33ec62f13f5fe460afbd8f7f70d.jpg" alt="" /></div>
                <div class="topNaviDetail">レンタル可能日から予約します。</div>
        </div><!-- /.topNaviColumn -->
        <div class="topNaviColumn">
            <h2>3.レンタルする</h2>
                <div class="topNaviPhoto"><img src="images/detail_image.jpg" alt="" /></div>
                <div class="topNaviDetail">予約日当日に設置場所へ取りに行きましょう。</div>
        </div><!-- /.topNaviColumn -->
</div>
</div>
<div id="product">
</div>

</div><!-- /container -->

<?php
require_once(__DIR__.'/footer.php');
?>

