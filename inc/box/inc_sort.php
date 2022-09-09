<?php
    //ソートリスト
    $list_sort = get_sort_search();
 ?>
 <ul class="listSort" data-sort-product="true" data-is-reputation="true">
     <?php foreach ($list_sort as $key => $sort) { ?>
         <li class="listSort__item">
             <?php if(isset($sort['list'])) { ?>
                 <span class="listSort__listLabel"><?php echo $sort['name'];?></span>
                 <div>
                     <?php foreach ($sort['list'] as $sortList) { ?>
                         <a href="javascript:void(0)" class="listSort__link listSort__link-list btnSub txtSiz-xs dispIb" data-where="<?php echo $sortList['where'];?>" data-order="<?php echo $sortList['order'];?>" data-order-fix="<?php echo $sortList['order'];?>"><?php echo $sortList['name'];?></a>
                     <?php } ?>
                 </div>
             <?php }else{ ?>
                 <a href="javascript:void(0)" class="listSort__link" data-where="<?php echo $sort['where'];?>" data-order="<?php echo $sort['order'];?>">
                     <?php echo $sort['name'];?><br>
                 </a>
             <?php } ?>
         </li>
     <?php } ?>
 </ul>
