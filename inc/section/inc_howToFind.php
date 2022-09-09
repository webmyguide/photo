<?php
    global $formFindSite;

    $is_title = true;
    $is_lead = true;
    $is_tips = true;
    if( isset($formFindSite['page_ranking']) ){
        $is_title = false;
        $is_lead = false;
        $is_tips = true;
    }
?>

<section class="contentCommon">
    <div class="boxFindTips <?php echo $box_class;?>">
    	<h2 class="boxFindTips__title"><strong>転職サイト選び</strong>で失敗しないための<strong>3つの方法</strong></h2>
    	<ul class="boxFindTips__list listTips">
    		<li class="listTips__item">このサイトの機能を使って、自分の条件に合うサイトをしっかり探しましょう</li>
    		<li class="listTips__item">本人確認の連絡があった場合は、しっかり連絡を取って希望条件を伝えましょう</li>
    		<li class="listTips__item">各転職サイトにはサイト独自の限定求人があるので、最低2サイトは登録して求人を見逃さないようにしましょう</li>
    	</ul>
    </div>
</section>
