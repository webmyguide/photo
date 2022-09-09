<div class="<?php echo ( is_search() )?'ranking-search':'box-side-bnner'; ?>">
  <h2 class="title-common-01">条件別ランキング</h2>
  <ul class="list-ranking-by <?php if( is_search() ) echo 'search'; ?> cf">
    <?php
        $rankingByConditionPosts = getRankingByConditionPosts();
        foreach($rankingByConditionPosts as $rankingByPost) {
      ?>
        <li>
          <a href="<?php echo esc_url( get_home_url() ); ?>/?tr=<?php echo $rankingByPost->ID;?>&age=<?php echo the_field('age',$rankingByPost->ID);?>&gakureki=<?php echo the_field('gakureki',$rankingByPost->ID);?>&zyoukyou=<?php echo the_field('zyoukyou',$rankingByPost->ID);?>&nenshuu=<?php echo the_field('nenshuu',$rankingByPost->ID);?>&job=<?php echo the_field('job',$rankingByPost->ID);?>&zaiseki=<?php echo the_field('zaiseki',$rankingByPost->ID);?>&tenshoku=<?php echo the_field('tenshoku',$rankingByPost->ID);?>&s=" class="button-ranking-by"><?php echo $rankingByPost->post_title;?><span class="pc">の転職</span></a>
        </li>
      <?php
      }  ?>
  </ul>
</div>
