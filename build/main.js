$(function () {

  var breakpoints = {
    'sm': 480,
    'md': 769,
    'lg': 1000,
    'xl': 1516,
    'xxl': 1862
  };

  /* ==================================================================================
     スムーススクロール
　   ================================================================================== */
    //スクロールしてトップ
      //スクロールのアニメーションスピード
    // $(document).on('click','a[href^="#"]',function(){
    //     let w_window = $(document).width();
    //     var href= $(this).attr("href");
    //     var target = $(href == "#" || href == "" ? 'html' : href);
    //
    //     if(w_window >= breakpoints['md']){
    //         var nav_h = $('.listNav').height();
    //         var position = target.offset().top - nav_h - 40;
    //     }else {
    //         var position = target.offset().top;
    //     }
    //     console.log(target);
    //
    //     $("html, body").animate({scrollTop:position}, speed, "swing");
    //     return false;
    // });
    var speed = 500;
    var urlHash = location.hash;
    if(urlHash) {
        $('body,html').stop().scrollTop(0);
        setTimeout(function(){
            let w_window = $(document).width();
            var target = $(urlHash);
            if(w_window >= breakpoints['md']){
                var nav_h = $('.listNav').height();
                var position = target.offset().top - nav_h - 40;
            }else {
                var position = target.offset().top;
            }
            $('body,html').stop().animate({scrollTop:position}, 500);
        }, 100);
    }
    $(document).on('click','a[href^="#"]',function(){
        let w_window = $(document).width();
        var href= $(this).attr('href');
        var url = location.protocol + '//' + location.hostname + location.pathname;
        href = href.replace(url, '');
        var target = $(href == '#' || href == '' ? 'html' : href);

        // if( target.size() < 1 ) return true;

        if(w_window >= breakpoints['md']){
            var nav_h = $('.listNav').height();
            var position = target.offset().top - nav_h - 40;
        }else {
            var position = target.offset().top;
        }

        $('html, body').animate({scrollTop:position}, speed, 'swing');
        return false;
    });

    /* ==================================================================================
    お問い合わせを下固定の処理（SP）
    　  ================================================================================== */
    if($('#contact_fixed').length > 0){
        var target_contact = $('#contact_fixed');
        var offset_contact = target_contact.offset().top;
        disp_contact_fixed();

        $(window).scroll(function () {
            disp_contact_fixed();
        });

        function disp_contact_fixed(){
            let w_window = $(document).width();
            let h_window = $(window).height();

            //PCの場合、何もしない
            if(w_window >= breakpoints['md']) return false;

            var offset_current = $(window).scrollTop();
            var offset_res = offset_contact + target_contact.height();

            if (offset_current >= offset_res) {
                target_contact.css('position','fixed').addClass('ani-disp-1');
            }else {
                target_contact.css('position','initial').removeClass('ani-disp-1');
            }
        }

    }


    /* ==================================================================================
    お問い合わせを下固定の処理（SP）
    　  ================================================================================== */
    if($('.js_contact_type').length > 0){
        $(document).on("click",'.js_contact_type', function(){
            let self = $(this);
            let val = self.attr('value');
            let host = location.href;
            host = host.replace("contact/", "");
            host = host.replace("reserve/", "");
            host = host.replace("#mw_wp_form_mw-wp-form-1355", "");
            host = host.replace("#mw_wp_form_mw-wp-form-974", "");

            if(val == 2){
                $('input[name=contact_type]:eq(0)').prop('checked', true);
                window.location.href = host + 'contact/#mw_wp_form_mw-wp-form-1355';
            }else {
                $('input[name=contact_type]:eq(1)').prop('checked', true);
                window.location.href = host + 'reserve/#mw_wp_form_mw-wp-form-974';
            }
        });
    }


    /* ==================================================================================
    マスクのサイズを調整
    　  ================================================================================== */
    if($('.msimg').length > 0){
        resize_mask_img();

    }
    function resize_mask_img(single = ''){

        if(single){
            let img = single;
            let img_h = img.height();
            let parent = img.parent();
            // let parent_w = parent.width();
            let parent_h = parent.height();

            if(img_h <= parent_h){
                // let rate = img_w/img_h;
                // console.log;
                img.css({'width':'auto','height':'100%'});
            }
        }else {
            let img_count = $('.msimg').length;

            for (var i = 0; i < img_count; i++) {
                let img = $('.msimg').eq(i);
                // let img_w = img.width();
                let img_h = img.height();
                let parent = img.parent();
                // let parent_w = parent.width();
                let parent_h = parent.height();

                if(img_h <= parent_h){
                    // let rate = img_w/img_h;
                    // console.log;
                    img.css({'width':'auto','height':'100%'});
                }
            }
        }
    }

    /* ==================================================================================
        MV非同期処理
    ================================================================================== */
    var wWindow = $(document).width();
    if(breakpoints['md'] >= wWindow){
        $('#targetMv').remove();
    }else {
        resizeMv();

        let selectar_mv = $('#targetMv');
        let mv_id = selectar_mv.attr('data-mv-id');

        var ajaxData_mv = {
            "action": "ajax_mv",
            "mv_id": mv_id,
        };

        //ajax用dataをセット
        var jqXHR_mv =  $.ajax(ajaxUrl, {
            "type": "post",
            "data": ajaxData_mv,
            "timeout":  20000
        });


        //ajax成功
        jqXHR_mv.done(function(data, textStatus, jqXHR){
            selectar_mv.find('.contentMv__loader').remove();
            selectar_mv.append(data);
            disp_mv();
            resizeMv();
        });

        //ajax失敗
        jqXHR_mv.fail(function(jqXHR, textStatus, errorThrown){
            // console.log('通信失敗');
            alert('取得に失敗しました、もう一度お試し下さい。');
         });
    }

  /* ==================================================================================
        サイドのMV
  	　================================================================================== */


    //サイズが変更されたとき
    $(window).resize(function() {
        let wWindow = $(document).width();

        if(breakpoints['md'] >= wWindow) return false;
        resizeMv();
    });

    function resizeMv(){
        let wWindow = $(document).width();
        let wHeader = $('header').width();
        let wContact = $('.contentMv__contact').width();


        //親のサイズを調整
        let targetSelector = $('#targetMv');
        let imgSelector = targetSelector.find('.contentMv__sideimg ');
        let wTarget = wWindow-wHeader-wContact;
        targetSelector.width(wTarget);
        imgSelector.css({'width':'auto','height':'100%'});

        //画像の横幅が足りない場合にサイズを調整
        let wImg = imgSelector.width();
        if(wTarget >　wImg){
            imgSelector.css({'width':'100%','height':'auto'});
        }
    }

    function disp_mv(){
        //SPだったら何もしない
        let wWindow = $(document).width();
        if(breakpoints['md'] >= wWindow) return false;

        var interval = 5000; // 切り替わりの間隔（ミリ秒）
        var fade_speed = 1000; // フェード処理の早さ（ミリ秒）
        var targetSelector = $('#targetMv');
        var imgSelector = targetSelector.find('.contentMv__sideimg ');
        imgSelector.eq(0).addClass('active');

        if(imgSelector.length > 1){
            setInterval(function(){
                var active = targetSelector.find('.active');
                var next = active.next('img').length?active.next('img'):imgSelector.eq(0);

                active.fadeOut(fade_speed).removeClass("active");
                next.fadeIn(fade_speed).addClass("active");
            },interval);
        }
    }



  /* ==================================================================================
     		メニュー
  	　================================================================================== */
    //サイズが変更されたとき
    // $(window).resize(function() {
    //     var wWindow = $(document).width();
    //     var targetSelector = $('#targetMenu');
    //     if(breakpoints['md'] > wWindow){
    //       targetSelector.hide();
    //     }else {
    //       targetSelector.show().css({'top':'','height':'auto'});
    //     }
    // });

   $(document).on("click",'#onMenu', function(){
        var wWindow = $(document).width();
        var self = this;
        var hHeader = $('header').height();
        var hWindow = $(document).height();
        var targetSelector = $('#targetMenu');
        var scrollTop = $(window).scrollTop();
        // console.log(hHeader);
        if(targetSelector.css('display') == 'none'){
            if(breakpoints['md'] >= wWindow){
                targetSelector.show().css({'height':hWindow,'padding-top':scrollTop});
                targetSelector.find('.boxNav__close').css('top',scrollTop);
            }else {
                targetSelector.show();
            }
        }else {
            if(breakpoints['md'] >= wWindow){
                targetSelector.hide().css('padding-top',0);
                targetSelector.find('.boxNav__close').css('top',0);
            }else {
                targetSelector.hide();
            }
        }
   });

   $(document).on("click",'#offMenu', function(){
       var self = this;
       var wWindow = $(document).width();
       var targetSelector = $('#targetMenu');
       if(breakpoints['md'] >= wWindow){
           targetSelector.hide().css('padding-top',0);
           targetSelector.find('.boxNav__close').css('top',0);
       }else {
           targetSelector.hide();
       }
   });

   $(document).on("click",'.listNav a', function(){
       let w_window = $(document).width();

       //SPの場合
       if(w_window < breakpoints['md']) {
           var self = this;
           var targetSelector = $('#targetMenu');
           targetSelector.hide();
       }


   });

   /* ==================================================================================
      	お問い合わせ項目で非表示
　  ================================================================================== */
    //name="c_type"があった場合
    if($('input[name="c_type"]').length > 0){
        disp_reservation();//初期処理

        $(document).on('click','input[name="c_type"]',function(){
            disp_reservation();
        });

        $(document).on('click','select[name="c_time"]',function(){
            disp_reservation();
        });
    }

    function disp_reservation() {
        let val = $('input[name="c_type"]:checked').val();
        let val_plan = $('input[name="c_plan"]:checked').val();
        let val_time = $('select[name="c_time"] option:selected').val();

        if(val == 2){
            val_plan = $('[data-plan-value]').attr('data-plan-value');
            $('.disp_reservation').show();
            $('input[name="c_plan"][value="'+ val_plan +'"]').prop('checked', true);
            if(Number(val_time) < 1)$('select[name="c_time"]').val(1);
            $('select[name="c_time"] option[value="0"]').attr("disabled", "disabled");
        }else {
            data_time = $('[data-time-value]').attr('data-time-value');
            $('.disp_reservation').hide();
            $('input[name="c_plan"]:checked').prop('checked', false);
            $('select[name="c_time"] option[value="0"]').removeAttr("disabled");
        }

        $('[data-plan-value]').attr('data-plan-value',val_plan);
        $('[data-time-value]').attr('data-time-value',val_time);
    }

    /* ==================================================================================
        プランの選択時に処理
 　  ================================================================================== */
    $(document).on('click','input[name="c_plan"]',function(){
        let val_plan = $('input[name="c_plan"]:checked').val();
        $('[data-plan-value]').attr('data-plan-value',val_plan);
    });


    /* ==================================================================================
       	pitchoutの処理
 　  ================================================================================== */
    if($('[data-pitchout-group]').length > 0){
        //groupにIDをつける
        for (let i = 0; i < $('[data-pitchout-group]').length; i++) {
            $('[data-pitchout-group]').eq(i).attr('data-pitchout-group',i+1);
            $('[data-pitchout-group]').eq(i).find('[data-pitchout]').attr('data-group',i+1);
            $('[data-pitchout-group]').eq(i).find('[data-gallarey-target]').attr('data-group',i+1);
            if($('[data-pitchout-group]').eq(i).find('[data-more]').length > 0){
                $('[data-pitchout-group]').eq(i).find('[data-more]').attr('data-group',i+1);
            }
        }

        //ダブルクリックのfalg
        var flag_pitchout_img = false;
        var flag_pitchout_nav = false;

        $(document).on('click','[data-pitchout]',function(){
            //ダブルクリックの処理
            if(flag_pitchout_img) return false;
            flag_pitchout_img = true;

            let self = $(this);
            let img_id = Number( self.attr('data-pitchout') );
            let group_id = Number( self.attr('data-group') );
            let src = self.attr('data-pitchout-src');
            let style = (self.attr('style'))?self.attr('style'): '';
            let selectar_group = $('[data-pitchout-group="' + group_id + '"]');
            let disp_type = selectar_group.attr('data-pitchout-disp');


            //data-pitchout-dispがあった場合の処理
            if(disp_type){
                let w_window = $(document).width();
                flag_pitchout_img = false;
                if(w_window < breakpoints[disp_type])  return false;
            }


            //画像がなければ何もしない
            if(!src) return false;

            let img_count = selectar_group.find('[data-pitchout]').length;
            let prev_id = (0 >= img_id)? img_count-1:img_id - 1;
            let next_id = (img_count <= (img_id+1))? 0:img_id + 1;


            let ele = '<div class="boxPitchout ani-disp-1"><div class="boxPitchout__wrap">';
            ele = ele + '<figure class="boxPitchout__figure"><img src="' + src + '" class="boxPitchout__img msimg ani-disp-1" style="' + style + '" /></figure>';
            ele = ele + '<div class="boxPitchout__prev icoNavigation" data-group="' + group_id + '"  data-pitchout-prev="' + prev_id + '"><img src="' + img_url + 'ico_prev_01.svg" alt="前の画像へ" width="18" height="36" class="img-r verAlign-b" /></div>';
            ele = ele + '<div class="boxPitchout__next icoNavigation" data-group="' + group_id + '"  data-pitchout-next="' + next_id + '"><img src="' + img_url + 'ico_next_01.svg" alt="次の画像へ" width="18" height="36" class="img-r verAlign-b" /></div>';
            ele = ele + '<div class="boxPitchout__close btnClose" data-pitchout-close="">close</div>';
            ele = ele + '</div></div>';

            selectar_group.append(ele + '<div class="boxMask ani-disp-1" data-pitchout-close="mask"></div>');

            let pitchout_img =  $('.boxPitchout').find('.msimg');


            let countup = function(){
                //マスクリサイズの処理
                resize_mask_img(pitchout_img);
              }
            setTimeout(countup, 500);

            flag_pitchout_img = false;

        });

        $(document).on('click','[data-pitchout-close]',function(){
            $('.boxPitchout').remove();
            $('[data-pitchout-close="mask"]').remove();
        });

        $(document).on('click','[data-pitchout-prev]',function(){
            //ダブルクリックの処理
            if(flag_pitchout_nav) return false;
            flag_pitchout_nav = true;

            let self = $(this);
            let target_img_id = Number( self.attr('data-pitchout-prev') );
            let group_id = Number( self.attr('data-group') );
            pitchout_nav(group_id,target_img_id);
        });

        $(document).on('click','[data-pitchout-next]',function(){
            //ダブルクリックの処理
            if(flag_pitchout_nav) return false;
            flag_pitchout_nav = true;

            let self = $(this);
            let target_img_id = Number( self.attr('data-pitchout-next') );
            let group_id = Number( self.attr('data-group') );
            pitchout_nav(group_id,target_img_id);
        });

        function pitchout_nav(group_id,target_img_id){
            var selectar_group = $('[data-pitchout-group="' + group_id + '"]');
            selectar_group.find('.boxPitchout').find('.boxPitchout__img').removeClass('ani-disp-1');
            selectar_group.find('.boxPitchout__prev').hide();
            selectar_group.find('.boxPitchout__next').hide();

            let countup = function(){
                let selectar_img = selectar_group.find('[data-pitchout="' + target_img_id + '"]');

                let src = selectar_img.attr('data-pitchout-src');
                let style = (selectar_img.attr('style'))?selectar_img.attr('style'): '';


                $('.boxPitchout').find('.boxPitchout__img').addClass('ani-disp-1').attr({'src':src,'style':style});

                let img_count = selectar_group.find('[data-pitchout]').length;
                let prev_id = (0 >= target_img_id)? img_count-1:target_img_id - 1;
                let next_id = (img_count <= (target_img_id+1))? 0:target_img_id + 1;

                $('[data-pitchout-prev]').attr('data-pitchout-prev',prev_id);
                $('[data-pitchout-next]').attr('data-pitchout-next',next_id);
                selectar_group.find('.boxPitchout__prev').show();
                selectar_group.find('.boxPitchout__next').show();
                flag_pitchout_nav = false;
              }
            setTimeout(countup, 20);
        }
    }
    /* ==================================================================================
       	ギャラリーmoreの処理
 　  ================================================================================== */
    if($('[data-gallarey-target]').length > 0){
        //IDをつける
        var h_window = $(window).height();
        var target_offset = [];
        for (let i = 0; i < $('[data-gallarey-target]').length; i++) {
            let parent_type = Number( $('[data-gallarey-target]').eq(i).attr('data-parent') );
            $('[data-gallarey-target]').eq(i).attr('data-gallarey-target',i+1);
            if(parent_type == 1){
                $('[data-gallarey-target]').eq(i).parent().parent().find('[data-more]').attr('data-more',i+1);
            }else {
                $('[data-gallarey-target]').eq(i).parent().find('[data-more]').attr('data-more',i+1);
            }

            target_offset[i] = $('[data-gallarey-target]').eq(i).offset().top;

            if ($(window).scrollTop() > (target_offset[i]-h_window-20) ) {
                $('[data-gallarey-target]').eq(i).attr('data-int-display','true');
                //表示
                ajax_gallarey(i+1);
            }
            // ajax_gallarey(i+1);
        }

        $(window).scroll(function () {
            for (let i = 0; i < target_offset.length; i++) {
                var int_display = ($('[data-gallarey-target]').eq(i).attr('data-int-display'))? $('[data-gallarey-target]').eq(i).attr('data-int-display'): '';
                if ($(this).scrollTop() > (target_offset[i]-h_window-20) && (!int_display) ) {
                    $('[data-gallarey-target]').eq(i).attr('data-int-display','true');
                    //表示
                    ajax_gallarey(i+1);
                }
            }
        });

        $(document).on('click','[data-more]',function(){
            let self = $(this);
            let gallarey_id = Number( self.attr('data-more') );
            let paged = Number( $('[data-gallarey-target="' + gallarey_id + '"]').attr('data-paged') );
            let count = Number( $('[data-gallarey-target="' + gallarey_id + '"]').attr('data-count') );

            //countが超えていなかったら処理
            if( (paged*12) <= count){
                ajax_gallarey(gallarey_id);
            }
        });

        //ダブルクリックのfalg
        var flag_gallarey_nav = false;
        $(document).on('click','[data-gallarey-nav]',function(){
            //ダブルクリックの処理
            if(flag_gallarey_nav) return false;
            flag_gallarey_nav = true;
            let self = $(this);
            let gallarey_id = Number( self.attr('data-gallarey') );
            let selectar_target = $('[data-gallarey-target="' + gallarey_id + '"]');
            let nav_type = self.attr('data-gallarey-nav');
            disp_costume(selectar_target,nav_type);
        });

    }

    function ajax_gallarey(gallarey_id = ''){
        //gallarey_idが空だったら何もしない
        if(!gallarey_id) return false;

        let selectar_target = $('[data-gallarey-target="' + gallarey_id + '"]');
        let w_window = $(window).width();

        //ローディング表示
        selectar_target.parent().find('.secGallarey__loader').show();


        let paged = Number( selectar_target.attr('data-paged') );
        let count = Number( selectar_target.attr('data-count') );
        let id = Number( selectar_target.attr('data-id') );
        let group_id = Number( selectar_target.attr('data-group') );
        let type = selectar_target.attr('data-type');
        let term = (selectar_target.attr('data-term'))?selectar_target.attr('data-term'):'';
        let is_sp = (w_window >= breakpoints['md'])? '': 1;


        var ajaxData = {
            "action": "ajax_gallarey_more",
            "paged": paged,
            "count": count,
            "id": id,
            "group_id": group_id,
            "type": type,
            "term": term,
            "is_sp": is_sp
        };


        //ajax用dataをセット
        var jqXHR =  $.ajax(ajaxUrl, {
            "type": "post",
            "data": ajaxData,
            "timeout":  20000
        });


        //ajax成功
        jqXHR.done(function(data, textStatus, jqXHR){
            // console.log('通信成功');
            // console.log(data);
            //targetの取得
            //target末尾に追加
            selectar_target.append(data);
            //マスクリサイズの処理
            resize_mask_img();
            //pagedの更新
            paged++;
            selectar_target.attr('data-paged',paged)
            //moreを消すかの判定
            if( (paged*12) >= count){
                $('[data-more="' + gallarey_id + '"]').hide();
            }else {
                $('[data-more="' + gallarey_id + '"]').show();
            }

            //ローディング消す
            selectar_target.parent().find('.loader').hide();

            //衣装の場合の処理
            if(type == 'costume'){
                disp_costume(selectar_target);
            }
        });

        //ajax失敗
        jqXHR.fail(function(jqXHR, textStatus, errorThrown){
            // console.log('通信失敗');
            alert('取得に失敗しました、もう一度お試し下さい。');

            //ローディング消す
            selectar_target.parent().find('.loader').hide();
        });

    }


    function disp_costume(selectar_target,nav_type = ''){
        let w_window = $(window).width();

        let id = Number( selectar_target.attr('data-gallarey-target') );
        let added_li = selectar_target.attr('data-added-li');
        let selectar_li = selectar_target.find('li');
        let w_li = selectar_li.eq(0).width();
        let w_margin = (w_window-w_li)/2;

        let li_length = selectar_li.length;

        //PCの場合、何もしない
        if(w_window >= breakpoints['md'])  return false;


        //アニメーションの処理を追加
        selectar_target.addClass('ani-slider');

        //moreを消すかの判定
        $('[data-more="' + id + '"]').hide();

        //初期処理時
        if(!added_li){
            let selectar_li_first = selectar_li.eq(0).prop('outerHTML');
            let selectar_li_second = selectar_li.eq(1).prop('outerHTML');
            let selectar_li_booby = selectar_li.eq(li_length-2).prop('outerHTML');
            let selectar_li_last = selectar_li.eq(li_length-1).prop('outerHTML');

            //最後のliを先頭に追加
            selectar_target.prepend(selectar_li_last);
            selectar_target.prepend(selectar_li_booby);

            //最初のliを最後に追加
            selectar_target.append(selectar_li_first);
            selectar_target.append(selectar_li_second);

            selectar_target.attr('data-added-li',true);

            //矢印の処理
            if(li_length > 1) {
                selectar_target.parent().find('.panelCostume__prev').show().attr('data-gallarey',id);
                selectar_target.parent().find('.panelCostume__next').show().attr('data-gallarey',id);
            }
        }

        //activeが付いているindex取得
        let selectar_active = selectar_target.find('[data-active="true"]');
        let index = selectar_li.index(selectar_active);

        //activeを一旦リセット
        selectar_target.find('li').attr('data-active','').find('img').removeClass('listCostume__img-active');

        //indexが-1だった場合、1を入れる
        if(index < 0){
            index = 2;
        }

        //nav_typeに値があった場合
        let current_first = false;
        let current_last = false;
        if(nav_type == 'next'){
            index++;
            if(index >= (li_length-2)) {
                current_last = 2;
            }
            // if( index == (li_length-3) ){
            //     current_last = 1;
            // }else if(index >= (li_length-2)) {
            //     current_last = 2;
            // }
        }else if (nav_type == 'prev') {
            index--;
            if( index < 2 ){
                current_first = 3;
            }
            // if( index == 1 ){
            //     current_first = 3;
            // }else if (index == 0) {
            //     current_first = 2;
            // }
        }

        selectar_target.find('li').eq(index).attr('data-active','true').find('img').addClass('listCostume__img-active');

        //activeの位置に移動
        selectar_target.css('transform','translateX(-' + ((w_li*index)-w_margin) + 'px)');


        //事後処理
        let countup = function(){
            //アニメーションの処理を削除
            selectar_target.removeClass('ani-slider');

            //最後の画像の場合
            if(current_last){
                selectar_target.find('li').attr('data-active','').find('img').removeClass('listCostume__img-active');
                selectar_target.find('li').eq(current_last).attr('data-active','true').find('img').addClass('listCostume__img-active');
                selectar_target.css('transform','translateX(-' + ((w_li*current_last)-w_margin) + 'px)');

            }else if (current_first) {
                let translateX = w_li*(li_length-current_first);
                selectar_target.find('li').attr('data-active','').find('img').removeClass('listCostume__img-active');
                selectar_target.find('li').eq(li_length-current_first).attr('data-active','true').find('img').addClass('listCostume__img-active');
                selectar_target.css('transform','translateX(-' + (translateX-w_margin) + 'px)');

            }
            flag_gallarey_nav = false;
          }
        setTimeout(countup, 500);
    }


    /* ==================================================================================
       	カレンダーの設定
 　  ================================================================================== */
    //id="reception_calendar"があった場合
    if($('#reception_calendar').length > 0){
        //ダブルクリックの初期値
        var flag_calendar_day = false;
        var flag_calendar_time = false;

        disp_reception_calendar();//初期処理
        $('input[name="c_day"]').prop('disabled', true);
        $('select[name="c_time"]').prop('disabled', true);
        let val_day_h = $('input[name="c_day_h"]').val();
        let val_time_v_h = $('input[name="c_time_v_h"]').val();
        if(val_day_h){
            $('input[name="c_day"]').attr({'value':val_day_h,'data-provisional':val_day_h});
            $('#datepicker_reception').text('変更する');
        }

        if(val_time_v_h){
            $('select[name="c_time"] option[value="'+ val_time_v_h +'"]').prop('selected', true);
            $('#select_calendarTime').text('変更する');

            //時間の比較のため取得
            let day_provisional = $('input[name="c_day"]').attr('data-provisional');
            let day_select = Date.parse(day_provisional);
            let day_change_3frames = $('[data-3frames]').attr('data-3frames');

            //3枠フラグをセット
            let is_3frames = false;
            if(day_change_3frames){
                let day_c_remaining = Date.parse(day_change_3frames);
                if(day_select >= day_c_remaining) is_3frames = true;
            }

            let target_time = $('select[name="c_time"] option[value="'+ val_time_v_h +'"]');
            let target_time_text = target_time.text();
            target_time_text = target_time_text.trim();

            if(is_3frames){
                target_time_text = reception_change_time(target_time_text,1);
                target_time.text(target_time_text);
            }else {
                target_time_text = reception_change_time(target_time_text);
            }

            //　時間帯が3つの場合、真ん中の時間帯のみ消す753を消す
            if(is_3frames){

                check_plan_753(val_time_v_h,target_time_text)
            }
        }


        $(document).on('click','[data-prev]',function(){
            let self = $(this);
            let enable = Number( self.attr('data-btn') );

            //enableがfalseだったら何もしない
            if(!enable) return false;

            //targetを取得
            let target = Number( self.attr('data-prev') );

            // //画面表示の処理
            disp_reception_calendar(target);
        });

        $(document).on('click','[data-next]',function(){
            let self = $(this);
            let enable = Number( self.attr('data-btn') );

            //enableがfalseだったら何もしない
            if(!enable) return false;

            //targetを取得
            let target = Number( self.attr('data-next') );

            //画面表示の処理
            disp_reception_calendar(target);
        });



        //カレンダー：日付の選択
        $(document).on('click','[data-day]',function(){
            let self = $(this);
            let day = self.attr('data-day');
            let calendar = $('#reception_calendar');

            //dayの値がなかったら何もしない
            if(!day) return false;

            //ダブルクリックの処理
            if(flag_calendar_time) return false;
            flag_calendar_time = true;

            let input = $('input[name="c_day"]');

            let is_datepicker = Number( calendar.attr('data-datepicker') );

            //値をinputに入れる
            input.attr('data-provisional',day);
            $('#datepicker_reception').text('変更する');

            //仮の値をセット
            let id = Number( self.attr('data-time-id') );
            let time_provisional_h = $('input[name="c_time_h"]').val();
            let time_provisional_v_h = $('input[name="c_time_v_h"]').val();
            $('select[name="c_time"]').attr({'data-provisiona':time_provisional_h,'data-provisiona-v':time_provisional_v_h});
            if(id){
                $('input[name="c_reception_id"]').attr('data-provisiona-id',id);
            }else {
                $('input[name="c_reception_id"]').attr('data-provisiona-id','');
            }


            //timeのinputをリセット
            $('select[name="c_time"] option[value="0"]').prop('selected', true);
            $('input[name="c_time_h"]').val('');
            $('input[name="c_time_v_h"]').val('');
            $('#select_calendarTime').text('選択する');

            var ajaxData = {
                "action": "ajax_reception_time",
                "id": id,
                "day": day,
                "step": true
            };

            //ajax用dataをセット
            var jqXHR =  $.ajax(ajaxUrl, {
                "type": "post",
                "data": ajaxData,
                "timeout":  20000
            });

            //ajax成功
            jqXHR.done(function(data, textStatus, jqXHR){
                // console.log('通信成功');
                // console.log(data);

                $(data).appendTo('body');

                //ダブルクリックの処理終了
                flag_calendar_time = false;
            });

            //ajax失敗
            jqXHR.fail(function(jqXHR, textStatus, errorThrown){
                // console.log('通信失敗');
                alert('取得に失敗しました、もう一度お試し下さい。');

                //ダブルクリックの処理終了
                flag_calendar_time = false;
            });
        });

        //カレンダー：closeの処理
        $(document).on('click','#datepicker_close',function(){
            disp_datepicker(1);
        });

        //カレンダー：マスクを押した処理
        $(document).on('click','#datepicker_mask',function(){
            disp_datepicker(1);
        });

        //カレンダー：時間の決定
        $(document).on('click','#decision_calendarTime',function(){
            let val_time = $('input[name="c_calendar_time"]:checked').val();

            let selector_datepicker = $('.secCalendar-datepicker');

            //時間の比較のため取得
            let day_provisional = $('input[name="c_day"]').attr('data-provisional');
            let day_select = Date.parse(day_provisional);
            let day_change_3frames = $('[data-3frames]').attr('data-3frames');

            //3枠フラグをセット
            let is_3frames = false;
            if(day_change_3frames){
                let day_c_remaining = Date.parse(day_change_3frames);
                if(day_select >= day_c_remaining) is_3frames = true;
            }

            let target_time = $('select[name="c_time"] option[value="'+ val_time +'"]');
            let target_time_text = target_time.text();
            target_time_text = target_time_text.trim();

            //　2021/4/1以降　時間の変更する処理
            if(is_3frames){
                target_time_text = reception_change_time(target_time_text,1);
            }else {
                target_time_text = reception_change_time(target_time_text);
            }
            target_time.text(target_time_text);
            $('input[name="c_day"]').attr('value',day_provisional);
            $('input[name="c_day_h"]').attr('value',day_provisional);
            $('select[name="c_time"] option[value="'+ val_time +'"]').prop('selected', true);
            $('input[name="c_time_h"]').attr('value',target_time_text);
            $('input[name="c_time_v_h"]').attr('value',val_time);
            $('#select_calendarTime').text('変更する');
            $('#target_calendarTime').remove();


            //　時間帯が3つの場合、真ん中の時間帯のみ消す753を消す
            if(is_3frames){
                check_plan_753(val_time,target_time_text)
            }



            //idをセット
            let id = $('input[name="c_reception_id"]').attr('data-provisiona-id');
            if(id){
                $('input[name="c_reception_id"]').val(id);
            }else {
                $('input[name="c_reception_id"]').val('');
            }

            if(selector_datepicker.length > 0){
                disp_datepicker(1);
            }

            //仮の値を削除
            $('input[name="c_day"]').attr('data-provisional','');
            $('select[name="c_time"]').attr({'data-provisiona':'','data-provisiona-v':''});
            $('input[name="c_reception_id"]').attr('data-provisiona-id','');

            let top_step2 = $('#form_step1').offset().top;
            let w_window = $(document).width();
            if (w_window >= breakpoints['md']){
                let h_header = $('.navHeader__list').eq(0).height();
                top_step2 = top_step2-h_header-30;
            }

            $('body,html').animate({scrollTop:top_step2}, 500);
        });

        //カレンダー：時間の戻る
        $(document).on('click','#return_calendarTime',function(){
            let time_provisional_h = $('select[name="c_time"]').attr('data-provisiona');
            let time_provisional_v_h = $('select[name="c_time"]').attr('data-provisiona-v');

            $('select[name="c_time"] option[value="'+ time_provisional_v_h + '"]').prop('selected', true);
            $('input[name="c_time_h"]').val(time_provisional_h);
            $('input[name="c_time_v_h"]').val(time_provisional_v_h);
            $('#target_calendarTime').remove();

            //仮の値を削除
            $('input[name="c_day"]').attr('data-provisional','');
            $('select[name="c_time"]').attr({'data-provisiona':'','data-provisiona-v':''});
            $('input[name="c_reception_id"]').attr('data-provisiona-id','');
        });

        //フォーム：日付の選択/変更
        $(document).on('click','#datepicker_reception',function(){
            //表示の処理
            disp_datepicker();
        });

        //フォーム：時間の選択/変更
        $(document).on('click','#select_calendarTime',function(){
            let self = $(this);
            let id = $('input[name="c_reception_id"]').val();
            let day = $('input[name="c_day_h"]').val();

            //仮の値をセット
            let time_provisional_h = $('input[name="c_time_h"]').val();
            let time_provisional_v_h = $('input[name="c_time_v_h"]').val();
            $('input[name="c_day"]').attr('data-provisional',day);
            $('select[name="c_time"]').attr({'data-provisiona':time_provisional_h,'data-provisiona-v':time_provisional_v_h});
            $('input[name="c_reception_id"]').attr('data-provisiona-id',id);
            if(id){
                $('input[name="c_reception_id"]').attr('data-provisiona-id',id);
            }else {
                $('input[name="c_reception_id"]').attr('data-provisiona-id','');
            }

            if(day){
                //ダブルクリックの処理
                if(flag_calendar_time) return false;
                flag_calendar_time = true;

                var ajaxData = {
                    "action": "ajax_reception_time",
                    "id": id,
                    "day": day,
                    "step": false
                };

                //ajax用dataをセット
                var jqXHR =  $.ajax(ajaxUrl, {
                    "type": "post",
                    "data": ajaxData,
                    "timeout":  20000
                });

                //ajax成功
                jqXHR.done(function(data, textStatus, jqXHR){
                    // console.log('通信成功');
                    // console.log(data);

                    $(data).appendTo('body');

                    //ダブルクリックの処理終了
                    flag_calendar_time = false;
                });

                //ajax失敗
                jqXHR.fail(function(jqXHR, textStatus, errorThrown){
                    // console.log('通信失敗');
                    alert('取得に失敗しました、もう一度お試し下さい。');

                    //ダブルクリックの処理終了
                    flag_calendar_time = false;
                });
            }else {
                //ダブルクリックの処理
                if(flag_calendar_day) return false;
                flag_calendar_day = true;

                //表示の処理
                disp_datepicker();

                //ダブルクリックの処理（終了）
                flag_calendar_day = false;
            }
        });

        //フォーム：確認ボタンの処理
        // $(document).on('click','input[name="submitConfirm"]',function(){
        //     let val_day_h = $('input[name="c_day_h"]').val();
        //     let val_time_v_h = $('input[name="c_time_v_h"]').val();
        //     let val_name_1 = $('input[name="c_name_1"]').val();
        //     let val_name_2 = $('input[name="c_name_2"]').val();
        //     let val_email = $('input[name="c_email"]').val();
        //     let val_tel_data_1 = $('input[name="c_tel[data][0]"]').val();
        //     let val_tel_data_2 = $('input[name="c_tel[data][1]"]').val();
        //     let val_tel_data_3 = $('input[name="c_tel[data][2]"]').val();
        //     let val_address = $('input[name="c_address"]').val();
        //
        //     console.log(val_name_1);
        //     console.log(val_name_2);
        //
        //     let is_error = false;
        //     let error_mass = '';
        //
        //     //日付のチェック
        //     if (val_day_h == "" || !val_day_h.match(/[^\s\t]/)) {
        //       is_error = true;
        //       error_mass = error_mass + '・希望日付が選択されていません<br>';
        //     }
        //
        //     //時間のチェック
        //     if (val_time_v_h == "" || !val_time_v_h.match(/[^\s\t]/)) {
        //       is_error = true;
        //       error_mass = error_mass + '・希望時間が選択されていません<br>';
        //     }
        //
        //     //名前のチェック
        //     if (val_name_1 == "" || !val_name_1.match(/[^\s\t]/)) {
        //         is_error = true;
        //         error_mass = error_mass + '・お名前が未入力です<br>';
        //     }else if (val_name_2 == "" || !val_name_2.match(/[^\s\t]/)) {
        //         is_error = true;
        //         error_mass = error_mass + '・お名前が未入力です<br>';
        //     }
        //
        //     //電話のチェック
        //     if (val_tel_data_1 == "" || !val_tel_data_1.match(/[^\s\t]/)) {
        //         is_error = true;
        //         error_mass = error_mass + '・電話番号が未入力です<br>';
        //     }else if (val_tel_data_2 == "" || !val_tel_data_2.match(/[^\s\t]/)) {
        //         is_error = true;
        //         error_mass = error_mass + '・電話番号が未入力です<br>';
        //     }else if (val_tel_data_3 == "" || !val_tel_data_3.match(/[^\s\t]/)) {
        //         is_error = true;
        //         error_mass = error_mass + '・電話番号が未入力です<br>';
        //     }else if (!Number.isFinite(Number(value))) {
        //         is_error = true;
        //         error_mass = error_mass + '・電話番号の形式ではありません<br>';
        //     }else if (!Number.isFinite(Number(value))) {
        //         is_error = true;
        //         error_mass = error_mass + '・電話番号の形式ではありません<br>';
        //     }else if (!Number.isFinite(Number(value))) {
        //         is_error = true;
        //         error_mass = error_mass + '・電話番号の形式ではありません<br>';
        //     }
        //
        //     //住所のチェック
        //     if (val_email == "" || !val_email.match(/[^\s\t]/)) {
        //         is_error = true;
        //         error_mass = error_mass + '・メールアドレスが未入力です<br>';
        //     }else if(!val_email.match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)){
        //         is_error = true;
        //         error_mass = error_mass + '・メールアドレスの形式ではありません<br>';
        //     }else if(val_email.length > 255){
        //         is_error = true;
        //         error_mass = error_mass + '・メールアドレスの形式ではありません<br>';
        //     }
        //
        //     //住所のチェック
        //     if (val_address == "" || !val_address.match(/[^\s\t]/)) {
        //       is_error = true;
        //       error_mass = error_mass + '・住所が未入力です<br>';
        //     }
        //
        //     console.log(error_mass);
        //
        //     if (is_error) {
        //
        //         return false;
        //     }
        //
        // });


 }

    function disp_reception_calendar(target) {
        let calendar = $('#reception_calendar');
        let prev = $('[data-prev]');
        let next = $('[data-next]');
        let max = Number( calendar.attr('data-max') );
        let w_window = $(document).width();

        //targetが空の場合、0以下の場合の処理
        if(!target || target < 0) target = 0;

        //一旦全て非表示
        calendar.find('.boxCalendar').hide();

        //該当の月を表示
        if(w_window >= breakpoints['md']){
            calendar.find('.boxCalendar').eq(target).show();
            calendar.find('.boxCalendar').eq(target + 1).show();
        } else {
            calendar.find('.boxCalendar').eq(target).show();
        }

        //前次の月のボタンの処理
        let disp_num = (w_window >= breakpoints['md'])? 2 : 1;
        let value_prev = target - disp_num;
        let value_next = target + disp_num;

        //prevが0以下の場合
        let enable_prev = 1;
        if(value_prev < 0){
            value_prev = 0;
            enable_prev = 0;
        }

        //nextがmax以上の場合
        let enable_next = 1;
        if(value_next >= max){
            value_next = max -1;
            enable_next = 0;
        }

        //値を入れる
        prev.attr({'data-prev':value_prev,'data-btn':enable_prev});
        next.attr({'data-next':value_next,'data-btn':enable_next});

        //ボタンの表示/非表示
        disp_prev_next(enable_prev);
        disp_prev_next(enable_next,1);
    }

    function disp_datepicker(type){
        let calendar = $('#reception_calendar');
        let day = calendar.find('[data-day]');

        if(type == 1){
            calendar.removeClass('secCalendar-datepicker').attr('data-datepicker',0).css({'position':'relative','top':'0'});
            // day.find('.boxCalendar__status').removeClass('boxCalendar__status-datepicker');
            $("#datepicker_mask").remove();
            $("#datepicker_close").remove();
        }else {
            let src_close = calendar.attr('data-close');
            let scroll_top = $(window).scrollTop();
            let window_h = $(window).height();
            let calendar_h = calendar.height();
            let top_h = (window_h - calendar_h)/2 + (calendar_h/2);
            calendar.addClass('secCalendar-datepicker').attr('data-datepicker',1).css({'position':'absolute','top':scroll_top+top_h});
            day.find('.boxCalendar__status').addClass('boxCalendar__status-datepicker');

            $('<div class="secCalendar__mask" id="datepicker_mask"></div>').appendTo('body');
            $('<div class="secCalendar__close" id="datepicker_close"><img src="' + src_close + '" alt="datepickerクローズ" width="100" height="100" class="img-r verAlign-b" /></div>').appendTo('.secCalendar__panel');
        }
    }

    function disp_prev_next(enable,type){
        let type_name = (type == 1)?'data-next':'data-prev';
        let selectar = $('[' + type_name + ']').find('img');
        let def = selectar.attr('data-def');
        let off = selectar.attr('data-off');
        let url = selectar.attr('data-url');

        let res_src = '';
        if(enable){
            res_src = url + def;
        }else {
            res_src = url + off;
        }

        selectar.attr('src',res_src);
    }

    /*
     * 時間の変更
     */
    function reception_change_time(time = '',type = ''){
        if(!time) return false;

        let res_time = '';
        if(type == 1){
            switch (time) {
                case '10:00':
                    res_time = '9:30';
                    break;
                case '10時00分':
                    res_time = '9時30分';
                    break;
                case '13:30':
                    res_time = '12:30';
                    break;
                case '13時30分':
                    res_time = '12時30分';
                    break;
                case '14:30':
                    res_time = '14:30';
                    break;
                case '14時30分':
                    res_time = '14時30分';
                    break;
                default:
                   res_time = time;
            }
        }else {
            switch (time) {
                case '9:30':
                    res_time = '10:00';
                    break;
                case '9時30分':
                    res_time = '10時00分';
                    break;
                case '12:30':
                    res_time = '13:30';
                    break;
                case '12時30分':
                    res_time = '13時30分';
                    break;
                case '14:30':
                    res_time = '14:30';
                    break;
                case '14時30分':
                    res_time = '14時30分';
                    break;
                default:
                   res_time = time;
            }
        }


        return res_time;
    }


    function check_plan_753(val = '',text = '') {
        let plan_753 = $('input[name="c_plan"][value="2445"]');
        let plan_ul = plan_753.parents('.boxInput__input');
        if(val == 2){
            let plan_753_id = plan_753.attr('id');
            let plan_753_text = $('label[for="' + plan_753_id +'"]').text();
            let plan_753_checked = plan_753.prop('checked')

            plan_753.prop("disabled", true);
            if( plan_ul.find('.boxInput__caution-r').length == 0 ){
                plan_ul.append('<div class="boxInput__caution boxInput__caution-r">ご希望時間が「' + text + '」の場合は「' + plan_753_text + '」は選択できません</div>');
            }


            //753が選択されていた場合は強制的に変更
            if(plan_753_checked){
                $('input[name=c_plan]:eq(0)').prop('checked', true);
            }

        }else {
            plan_753.prop("disabled", false);
            plan_ul.find('.boxInput__caution-r').remove();
        }

    }

 });
