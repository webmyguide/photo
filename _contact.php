<?php
//お問い合わせ・撮影予約 オリジナル
?>

<div class="boxInput">
    <div class="boxInput__items boxInput__items-mbl">
        <div class="boxInput__label">お問い合わせ項目<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            <ul class="listInput">
                <li class="listInput__items">
                    <input class="radioInput" type="radio" name="c_type" id="c_type_1" value="1" checked><label for="c_type_1">お問い合わせ</label>
                </li>
                <li class="listInput__items">
                    <input class="radioInput" type="radio" name="c_type" id="c_type_2" value="2" ><label for="c_type_2">撮影予約</label>
                </li>
            </ul>
        </div>
    </div>
    <div class="boxInput__items">
        <div class="boxInput__label">お名前<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            <ul class="listInput">
                <li class="listInput__items-name">
                    <input class="textInput" type="text" name="c_name_1" maxlength="10" value=""><br>
                    <span class="boxInput__ex">例）山田</span>
                </li>
                <li class="listInput__items-name">
                    <input class="textInput" type="text" name="c_name_2" maxlength="10" value=""><br>
                    <span class="boxInput__ex">例）太郎</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="boxInput__items">
        <div class="boxInput__label">フリガナ</div>
        <div class="boxInput__input">
            <ul class="listInput">
                <li class="listInput__items-name">
                    <input class="textInput" type="text" name="c_name_f_1" maxlength="10" value=""><br>
                    <span class="boxInput__ex">例）ヤマダ</span>
                </li>
                <li class="listInput__items-name">
                    <input class="textInput" type="text" name="c_name_f_2" maxlength="10" value=""><br>
                    <span class="boxInput__ex">例）タロウ</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="boxInput__items">
        <div class="boxInput__label">メールアドレス<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            <input class="textInput" type="email" name="c_email" maxlength="50" value=""><br>
            <span class="boxInput__ex">例）yamadataro@kazokubiyori.jp</span>
        </div>
    </div>
    <div class="boxInput__items">
        <div class="boxInput__label">電話番号<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            <input class="textInput" type="tel" name="c_tel" value=""><br>
            <span class="boxInput__ex">例）<?php echo $setting_common['common_phone_number'];?></span>
        </div>
    </div>
    <div class="boxInput__items">
        <div class="boxInput__label">郵便番号<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            <input class="textInput textInput-postal" type="text" name="c_postal" value=""><br>
            <span class="boxInput__ex">例）<?php echo $setting_common['common_postal_code'];?></span>
        </div>
    </div>
    <div class="boxInput__items">
        <div class="boxInput__label">住所<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            <input class="textInput" type="text" name="c_address" maxlength="200" value=""><br>
            <span class="boxInput__ex">例）<?php echo $setting_common['common_street_address'];?></span>
        </div>
    </div>
</div>
<div class="boxInput">
    <div class="boxInput__title">◆撮影予約の方のみご記入ください</div>
    <div class="boxInput__items boxInput__items-mbl">
        <div class="boxInput__label">希望プラン<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            <ul class="listInput">
                <li class="listInput__items listInput__items-plan">
                    <input class="radioInput" type="radio" name="c_plan" id="c_plan_1" value="" checked>
                    <label for="c_plan_1">赤ちゃん撮影</label>
                </li>
                <li class="listInput__items listInput__items-plan">
                    <input class="radioInput" type="radio" name="c_plan" id="c_plan_2" value="" >
                    <label for="c_plan_2">赤ちゃん撮影</label>
                </li>
            </ul>
        </div>
    </div>
    <div class="boxInput__items">
        <div class="boxInput__label">希望日<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            <input class="textInput textInput-day" type="date" name="c_day" value=""><br>
            <span class="boxInput__ex">例）2020/01/01</span>
        </div>
    </div>
    <div class="boxInput__items">
        <div class="boxInput__label">希望時間<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            <input class="textInput textInput-time" type="number" name="c_time" value="" min="9" max="18">&nbsp;時頃<br>
            <span class="boxInput__ex">例）13</span>
        </div>
    </div>
    <div class="boxInput__caution">
        <?php echo apply_filters('the_content',$setting_page['contact_caution']); ?>
    </div>
</div>
<div class="boxInput boxInput-bn">
    <div class="boxInput__items boxInput__items-mbl">
        <div class="boxInput__label">お問い合わせ内容</div>
        <div class="boxInput__input">
            <textarea  class="textInput textInput-textarea" name="c_contents" maxlength="1000" rows="8"></textarea>
        </div>
    </div>
    <div class="boxInput__privacyPolicy">
        <div class="boxInput__title boxInput__title-privacyPolicy">プライバシーポリシー</div>
        <?php echo apply_filters('the_content',$setting_page['contact_ privacy_policy']); ?>
    </div>
    <p class="boxInput__confirm">
        個人情報の取り扱いについては 個人情報保護方針 をお読みいただき、ご同意の上、『 確認画面へ 』ボタンを押してください。
    </p>

    <input type="submit" value="確認画面へ" class="btnContact btnContact-submit">
</div>

----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------

[contact_step]
<div class="boxInput [form_class class='boxInput-cfm' step=2]">
    <div class="boxInput__items boxInput__items-mbl [form_class class='boxInput__items-cfm' step=2]">
        <div class="boxInput__label">お問い合わせ項目<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            [mwform_radio name="c_type" id="c_type" class="radioInput" children="1:お問い合わせ,2:撮影予約" value="1"]
        </div>
    </div>
    <div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
        <div class="boxInput__label">お名前<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            <ul class="listInput">
                <li class="listInput__items-name [form_class class='listInput__items-cfm' step=2]">
                    [mwform_text name="c_name_1" class="textInput" maxlength="10"]<br>
                    [form_ex text="例）山田"]
                </li>
                <li class="listInput__items-name [form_class class='listInput__items-cfm' step=2]">
                    [mwform_text name="c_name_2" class="textInput" maxlength="10"]<br>
                    [form_ex text="例）太郎"]
                </li>
            </ul>
        </div>
    </div>
    <div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
        <div class="boxInput__label">フリガナ</div>
        <div class="boxInput__input">
            <ul class="listInput">
                <li class="listInput__items-name [form_class class='listInput__items-cfm' step=2]">
                    [mwform_text name="c_name_f_1" class="textInput" maxlength="10"]<br>
                    [form_ex text="例）ヤマダ"]
                </li>
                <li class="listInput__items-name [form_class class='listInput__items-cfm' step=2]">
                    [mwform_text name="c_name_f_2" class="textInput" maxlength="10"]<br>
                    [form_ex text="例）タロウ"]
                </li>
            </ul>
        </div>
    </div>
    <div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
        <div class="boxInput__label">メールアドレス<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            [mwform_email name="c_email" class="textInput" size="60" maxlength="50"]<br>
            [form_ex text="例）yamadataro@kazokubiyori.jp"]
        </div>
    </div>
    <div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
        <div class="boxInput__label">電話番号<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            [mwform_tel name="c_tel" class="textInput"]<br>
            [form_ex text="例）" key="common_phone_number"]
        </div>
    </div>
    <div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
        <div class="boxInput__label">郵便番号</div>
        <div class="boxInput__input">
            [mwform_zip name="c_postal" class="textInput textInput-postal"]<br>
            [form_ex text="例）" key="common_postal_code"]
        </div>
    </div>
    <div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
        <div class="boxInput__label">住所<span class="boxInput__required">必須</span></div>
        <div class="boxInput__input">
            [mwform_text name="c_address" class="textInput" size="60" maxlength="200"]<br>
            [form_ex text="例）" key="common_street_address"]
        </div>
    </div>
</div>
<div class="boxInput [form_class class='boxInput-cfm' step=2]">
    <div class="boxInput__title">◆[form_text text1="撮影予約の方のみご記入ください" text2="撮影予約"]</div>
    <div class="boxInput__items boxInput__items-mbl [form_class class='boxInput__items-cfm' step=2]">
        <div class="boxInput__label">希望プラン<span class="boxInput__required disp_reservation">必須</span></div>
        <div class="boxInput__input" data-plan-value="">
            [form_plan]
        </div>
    </div>
    <div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
        <div class="boxInput__label">希望日<span class="boxInput__required disp_reservation">必須</span></div>
        <div class="boxInput__input">
            [mwform_datepicker name="c_day" class="textInput textInput-day" size="30" id="datepicker_reception"]<br>
            [form_ex text="例）2020/01/01"]
        </div>
    </div>
    <div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
        <div class="boxInput__label">希望時間<span class="boxInput__required disp_reservation">必須</span></div>
        <div class="boxInput__input">
            [mwform_number name="c_time" class="textInput textInput-time" min="9" max="18" step="1"]&nbsp;時頃<br>
            [form_ex text="例）13"]
        </div>
    </div>
    <div class="boxInput__caution [form_class class='boxInput__caution-cfm' step=2]">
    	[sv key='contact_caution' type='1' filters='1']
    </div>
</div>
<div class="boxInput boxInput-bn">
    <div class="boxInput__items boxInput__items-mbl [form_class class='boxInput__items-cfm' step=2]">
        <div class="boxInput__label">お問い合わせ内容</div>
        <div class="boxInput__input">
            [mwform_textarea name="c_contents" class="textInput textInput-textarea" cols="50" rows="8"]
        </div>
    </div>
    <div class="boxInput__privacyPolicy [form_class class='boxInput__privacyPolicy-cfm' step=2]">
        <div class="boxInput__title boxInput__title-privacyPolicy">プライバシーポリシー</div>
        [sv key='contact_privacy_policy' type='1' filters='1']
    </div>
    <p class="boxInput__confirm [form_class class='boxInput__confirm-cfm' step=2]">
        個人情報の取り扱いについては 個人情報保護方針 をお読みいただき、ご同意の上、『 確認画面へ 』ボタンを押してください。
    </p>
    <div class="boxInput__action">
        [mwform_submitButton name="next" class="boxInput__submit btnContact btnContact-submit" confirm_value="確認画面へ" submit_value="送信する"]
        [mwform_backButton class="boxInput__return btnContact btnContact-return" value="修正する"]
    </div>

</div>

----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------

<div class="pageContact__thanks boxThanks">
    <h1 class="titCommon titCommon-sl">[sv key='post_title' type='2']</h1>
    <p class="boxThanks__emp">[sv key='contact_thanks_title' type='1']</p>
    <div class="boxThanks__detail">[sv key='contact_thanks_detail' type='1' filters='1']</div>
</div>

<p class="pageContact__info pageContact__info-cfm">
    受付時間&nbsp;[sv key='common_reception_time_1']〜[sv key='common_reception_time_2']&nbsp;/&nbsp;定休日&nbsp;[sv key='common_regular_holiday']<br>
    [sv key='common_phone_number' ver='1']
</p>

[contact_step]

<a href="[sv key='home_url' type='3']" class="pageContact__pagetop btnContact btnContact-submit">TOPへ戻る</a>

----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------

{c_name_1} {c_name_2} 様

お問い合わせいただきありがとうございます。
株式会社ハーベスト　人工芝専門店　芝助の三輪と申します。

1営業日以内にご連絡いたしますので少々お待ちください。

・・・・・・・・・・・・・・
■お問い合わせ項目
{c_type}

■お名前
{c_name_1} {c_name_2}
{c_name_f_1} {c_name_f_2}

■メールアドレス
{c_email}

■ご電話番号
{c_tel}

■郵便番号
{c_postal}

■住所
{c_address}

◆撮影予約

■希望プラン
{c_plan}

■希望日
{c_day}

■希望時間
{c_time}時頃

■お問い合わせ内容
{c_contents}

・・・・・・・・・・・・・・

■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□
株式会社 ハーベスト (人工芝専門店 芝助)　三輪千鶴
MAIL info@shibasuke.jp
URL  http://shibasuke.jp/
〒451-0045
愛知県名古屋市西区名駅2丁目34-17 セントラル名古屋1101
営業時間 10:00~17:00
定休日 土曜・日曜・祝日
■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■
