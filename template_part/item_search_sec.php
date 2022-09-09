<div class="item_seach_sec">
  <h2 class="sec_title page-header">商品検索</h2>
  <div class="search_list">
  <table class="table">
    <tbody>
      <tr>
        <th>値段</th>
        <td>
          <div><input type="radio" name="price" value="price_none" checked="checked"><label for="price_none">指定なし</label></div>
          <div><input type="radio" name="price" value="price_10000"><label for="price_10000">～10,000円</label></div>
          <div><input type="radio" name="price" value="price_10001"><label for="price_10001">10,001円～15,000円</label></div>
          <div><input type="radio" name="price" value="price_15001"><label for="price_15001">15,001円～20,000円</label></div>
          <div><input type="radio" name="price" value="price_20001"><label for="price_20001">20,001円～</label></div>
        </td>
      </tr>
      <tr>
        <th>成分種類</th>
        <td>
          <div><input type="radio" name="componentcount" value="componentcount_none" checked="checked"><label for="componentcount_none">指定なし</label></div>
          <div><input type="radio" name="componentcount" value="componentcount_20"><label for="componentcount_20">～20種類</label></div>
          <div><input type="radio" name="componentcount" value="componentcount_21"><label for="componentcount_21">21～50種類</label></div>
          <div><input type="radio" name="componentcount" value="componentcount_51"><label for="componentcount_51">51～100種類</label></div>
          <div><input type="radio" name="componentcount" value="componentcount_101"><label for="componentcount_101">101種類～</label></div>
        </td>
      </tr>
      <tr>
        <th>成分指定</th>
        <td>
          <div><input type="radio" name="componentkind" value="componentkind_none" checked="checked"><label for="componentkind_none">指定なし</label></div>
          <div><input type="radio" name="componentkind" value="componentkind_citrulline"><label for="componentkind_citrulline">シトルリン</label></div>
          <div><input type="radio" name="componentkind" value="componentkind_zinc"><label for="componentkind_zinc">亜鉛</label></div>
          <div><input type="radio" name="componentkind" value="componentkind_maca"><label for="componentkind_maca">マカ</label></div>
          <div><input type="radio" name="componentkind" value="componentkind_arginine"><label for="componentkind_arginine">アルギニン</label></div>
          <div><input type="radio" name="componentkind" value="componentkind_carrot"><label for="componentkind_carrot">高麗人参</label></div>
          <div><input type="radio" name="componentkind" value="componentkind_animal"><label for="componentkind_animal">動物系エキス</label></div>
          <div><input type="radio" name="componentkind" value="componentkind_krachaidam"><label for="componentkind_krachaidam">クラチャイダム</label></div>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="search_tit_more">さらに詳細な条件を指定</div>
  <table class="table">
    <tbody>
      <tr>
        <th>キャンペーン</th>
        <td>
          <div><input type="checkbox" name="care" value="care_waribiki"><label for="detailed">割引キャンペーン</label></div>
          <div><input type="checkbox" name="care" value="care_zouryou"><label for="detailed">増量キャンペーン</label></div>
          <div><input type="checkbox" name="care" value="care_henkinhosyo"><label for="detailed">返金保証</label></div>
        </td>
      </tr>
      <tr>
        <th>配送について</th>
        <td>
          <div><input type="checkbox" name="delivery" value="delivery_free"><label for="delivery_free">送料無料</label></div>
          <div><input type="checkbox" name="delivery" value="delivery_privacy"><label for="delivery_privacy">プライバシー梱包</label></div>
          <div><input type="checkbox" name="delivery" value="delivery_stop"><label for="delivery_stop">営業所止め</label></div>
          <div><input type="checkbox" name="delivery" value="delivery_date"><label for="delivery_date">時間指定</label></div>
          <div><input type="checkbox" name="delivery" value="delivery_speed"><label for="delivery_speed">当日・翌日発送</label></div>
        </td>
      </tr>
      <tr>
        <th>支払方法</th>
        <td>
          <div><input type="checkbox" name="pay" value="pay_credit"><label for="pay_credit">クレジットカード利用</label></div>
          <div><input type="checkbox" name="pay" value="pay_cash"><label for="pay_cash">代金引換</label></div>
          <div><input type="checkbox" name="pay" value="pay_bank"><label for="pay_bank">銀行振込</label></div>
          <div><input type="checkbox" name="pay" value="pay_after"><label for="pay_after">後払い</label></div>
        </td>
      </tr>
    </tbody>
  </table>

<div class="entry-content">
  <div class="search-button"><a href="#" id="show-json">上記の条件で検索結果を表示</a></div>
  <div class="sort" id="sort">
  <ul class="cf">
  <li class="price"><a href="#" id="show-json-price">値段順に並び替え</a></li>
  <li class="componentcount"><a href="#" id="show-json-componentcount">成分種類に並び替え</a></li>
  <li class="cost"><a href="#" id="show-json-cost">1粒あたりのコスト順に並び替え</a></li>
  </ul>
  <div class="delete cf">
  <div class="delete_in"><a href="#" id="show-json-close">検索結果を閉じる</a></div>
  </div>
  </div>

    <div class="item_sort_sec">
    <h2 class="sec_title">商品一覧</h2>
      <div id="json-data" class="media_wrap">
      <?php foreach ( $item_val as $value) { ?>
      <div class="media">
        <div class="media-body">
          <?php echo $value['html']; ?>
          <!-- <a href="#" class="btn btn-danger">この商品を詳しく見る</a> -->
        </div>
      </div>
      <?php } ?>
      </div><!-- /.media_wrap -->
    </div><!-- / item_sort_sec -->
  </div><!-- / entry-content -->

</div>
</div><!-- /.item_seach_sec -->
