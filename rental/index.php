<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');
require_once(__DIR__.'/head.php');
?>

<div id="container">

<div id="main">
<img style="position: relative;"src="images/neighbor3.png" alt="" width="100%" height="100%;"/>
<a class="startButton"  href="register.php">シェアをはじめる</a>
</div>

<div id="cha">
<div id="char">
    <h2>Shareとは？</h2>
    <p style="padding: 10px;">Share(シェア)は買ってみたけど数回しか使わないモノや、買うまではいかないけど１回だけ使ってみたいモノを個人間でレンタルしあうサービスです。</p>
            <div class="topNaviColumn">
            	<h3>1.使ってみたいけど高くて買えない</h3>
                    <div class="topNaviPhoto"><img src="images/PSVR.jpg" alt="" /></div>
                    <div class="yazirusi"><img src="images/yazirusi.png" alt="" /></div>
            </div><!-- /.topNaviColumn --></a>
            <div class="topNaviColumn">
                <h3>2.数回しか使わないので元が取れない</h3>
                    <div class="topNaviPhoto"><img src="images/kawanakya.jpg" alt="" /></div>
                    <div class="yazirusi"><img src="images/yazirusi.png" alt="" /></div>
            </div><!-- /.topNaviColumn -->
            <div class="topNaviColumn">
                <h3>3.部屋が狭いので置く場所がない</h3>
                    <div class="topNaviPhoto"><img src="images/heya.jpg" alt="" /></div>
            		<div class="yazirusi"><img src="images/yazirusi.png" alt="" /></div>
            </div><!-- /.topNaviColumn -->
            <div class="yazirusi2"><img src="images/yazirusi.png" alt="" /></div>
            <div class="topNaviColumn">
            	<h3>1.低価格で使える</h3>
                    <div class="topNaviPhoto"><img src="images/projector3.jpg" alt="" /></div>
                    <div class="topNaviDetail">高くて買えなかったものをレンタルして使おう。</div>
                    <a class="myButtonlog3" href="products.php">商品を見る</a>
            </div><!-- /.topNaviColumn --></a>
            <div class="topNaviColumn">
                <h3>2.出品でお小遣い稼ぎ</h3>
                    <div class="topNaviPhoto"><img src="images/placeit.jpg" alt="" /></div>
                    <div class="topNaviDetail">買ったけど使ってないものをシェアしてお小遣いを稼ごう。</div><a class="myButtonlog3" href="exhit.php">シェアする</a>
            </div><!-- /.topNaviColumn -->
            <div class="topNaviColumn">
                <h3>3.必要最低限の生活を</h3>
                    <div class="topNaviPhoto"><img src="images/heya2.jpg" alt="" /></div>
                    <div class="topNaviDetail">必要最低限のモノしかないきれいな部屋で快適に過ごそう。</div>
                    <a class="myButtonlog3" href="howto.php">使い方</a>
            </div><!-- /.topNaviColumn -->
</div>
</div>
<!--
<div id="how">
    <h2>使い方</h2>
    <br>
    <iframe src="https://player.vimeo.com/video/19846300" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    <br>
</div>
-->
<div id="product">
        <a class="myButtonlog2" href="products.php">商品一覧</a>
</div>

</div><!-- /container -->

<?php
require_once(__DIR__.'/footer.php');
?>

