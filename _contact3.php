<div class="boxInput [form_class class='boxInput-cfm' step=2]">
<div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
<div class="boxInput__label">希望日<span class="boxInput__required disp_reservation">必須</span></div>
<div class="boxInput__input">
<ul class="listInput">
 	<li class="listInput__items-name ">[mwform_datepicker name="c_day" class="textInput textInput-day" size="30"]<span class="boxInput__hidden [form_class class='boxInput__hidden-step2' step=2]">[mwform_hidden name="c_day_h" echo="true"][mwform_hidden name="c_reception_id"]</span></li>
 	<li class="listInput__items-name ">
<div class="btnCommon btnCommon-input [form_class class='btnCommon-hidden' step=2]" id="datepicker_reception">選択する</div></li>
</ul>
[mwform_error keys="c_day_h"]
</div>
</div>
<div class="boxInput__items boxInput__items-mbl [form_class class='boxInput__items-cfm' step=2]">
<div class="boxInput__label">希望時間<span class="boxInput__required disp_reservation">必須</span></div>
<div class="boxInput__input" data-time-value="">
<ul class="listInput">
 	<li class="listInput__items-name ">[form_time]<span class="boxInput__hidden [form_class class='boxInput__hidden-step2' step=2]">[mwform_hidden name="c_time_h" echo="true"][mwform_hidden name="c_time_v_h"]</span>時</li>
 	<li class="listInput__items-name ">
<div class="btnCommon btnCommon-input [form_class class='btnCommon-hidden' step=2]" id="select_calendarTime">選択する</div></li>
</ul>
[mwform_error keys="c_time_h"]
</div>
</div>
</div>
<div class="boxInput [form_class class='boxInput-cfm' step=2]" id="form_step2">
<div class="boxInput__items boxInput__items-mbl [form_class class='boxInput__items-cfm' step=2]">
<div class="boxInput__label">希望プラン<span class="boxInput__required disp_reservation">必須</span></div>
<div class="boxInput__input">
<ul class="listInput" data-plan-value="">[form_plan]</ul>
</div>
</div>
<div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
<div class="boxInput__label">お名前<span class="boxInput__required">必須</span></div>
<div class="boxInput__input">
<ul class="listInput">
 	<li class="listInput__items-name [form_class class='listInput__items-cfm' step=2]">[mwform_text name="c_name_1" class="textInput" maxlength="10"]
[form_ex text="例）山田"]</li>
 	<li class="listInput__items-name [form_class class='listInput__items-cfm' step=2]">[mwform_text name="c_name_2" class="textInput" maxlength="10"]
[form_ex text="例）太郎"]</li>
</ul>
</div>
</div>
<div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
<div class="boxInput__label">フリガナ</div>
<div class="boxInput__input">
<ul class="listInput">
 	<li class="listInput__items-name [form_class class='listInput__items-cfm' step=2]">[mwform_text name="c_name_f_1" class="textInput" maxlength="10"]
[form_ex text="例）ヤマダ"]</li>
 	<li class="listInput__items-name [form_class class='listInput__items-cfm' step=2]">[mwform_text name="c_name_f_2" class="textInput" maxlength="10"]
[form_ex text="例）タロウ"]</li>
</ul>
</div>
</div>
<div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
<div class="boxInput__label">メールアドレス<span class="boxInput__required">必須</span></div>
<div class="boxInput__input">[mwform_email name="c_email" class="textInput" size="60" maxlength="50"]
[form_ex text="例）yamadataro@kazokubiyori.jp"]</div>
</div>
<div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
<div class="boxInput__label">電話番号<span class="boxInput__required">必須</span></div>
<div class="boxInput__input">[mwform_tel name="c_tel" class="textInput"]
[form_ex text="例）" key="common_phone_number"]</div>
</div>
<div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
<div class="boxInput__label">郵便番号</div>
<div class="boxInput__input">[mwform_zip name="c_postal" class="textInput textInput-postal"]
[form_ex text="例）" key="common_postal_code"]</div>
</div>
<div class="boxInput__items [form_class class='boxInput__items-cfm' step=2]">
<div class="boxInput__label">住所<span class="boxInput__required">必須</span></div>
<div class="boxInput__input">[mwform_text name="c_address" class="textInput" size="60" maxlength="200"]
[form_ex text="例）" key="common_street_address"]</div>
</div>
<div class="boxInput__caution [form_class class='boxInput__caution-cfm' step=2]">[sv key='contact_caution' type='1' filters='1']</div>
</div>
<div class="boxInput boxInput-bn">
<div class="boxInput__items boxInput__items-mbl [form_class class='boxInput__items-cfm' step=2]">
<div class="boxInput__label">お問い合わせ内容</div>
<div class="boxInput__input">[mwform_textarea name="c_contents" class="textInput textInput-textarea" cols="50" rows="8"]</div>
</div>
<div class="boxInput__privacyPolicy [form_class class='boxInput__privacyPolicy-cfm' step=2]">
<div class="boxInput__title boxInput__title-privacyPolicy">プライバシーポリシー</div>
[sv key='contact_privacy_policy' type='1' filters='1']

</div>
<p class="boxInput__confirm [form_class class='boxInput__confirm-cfm' step=2]">個人情報の取り扱いについては 個人情報保護方針 をお読みいただき、ご同意の上、『 確認画面へ 』ボタンを押してください。</p>

<div class="boxInput__action">[mwform_submitButton name="next" class="boxInput__submit btnContact btnContact-submit" confirm_value="確認画面へ" submit_value="送信する"]
[mwform_backButton class="boxInput__return btnContact btnContact-return" value="修正する"]</div>
</div>
