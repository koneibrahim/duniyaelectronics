<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2017 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

$banner = $wpdb->get_row("SELECT `title`, `tracker`, `type` FROM `{$wpdb->prefix}adrotate` WHERE `id` = '{$id}';");
$schedules = $wpdb->get_results("SELECT `{$wpdb->prefix}adrotate_schedule`.`id`, `starttime`, `stoptime`, `maxclicks`, `maximpressions`, COUNT(`clicks`) as `clicks`, COUNT(`impressions`) as `impressions` FROM `{$wpdb->prefix}adrotate_schedule`, `{$wpdb->prefix}adrotate_linkmeta`, `{$wpdb->prefix}adrotate_stats` WHERE `{$wpdb->prefix}adrotate_linkmeta`.`ad` = '{$id}' AND `{$wpdb->prefix}adrotate_linkmeta`.`ad` = `{$wpdb->prefix}adrotate_stats`.`ad` AND `schedule` = `{$wpdb->prefix}adrotate_schedule`.`id` AND `thetime` > `starttime` AND `thetime` < `stoptime` ORDER BY `{$wpdb->prefix}adrotate_schedule`.`id` ASC;"); 

$stats = adrotate_stats($id, false);
$stats_today = adrotate_stats($id, false, adrotate_date_start('day'));
$stats_last_month = adrotate_stats($id, false, mktime(0, 0, 0, date("m")-1, 1, date("Y")), mktime(0, 0, 0, date("m"), 0, date("Y")));
$stats_this_month = adrotate_stats($id, false, mktime(0, 0, 0, date("m"), 1, date("Y")), mktime(0, 0, 0, date("m"), date("t"), date("Y")));
$stats_graph_month = adrotate_stats($id, false, $monthstart, $monthend);

// Prevent gaps in display
if(empty($stats['impressions'])) $stats['impressions'] = 0;
if(empty($stats['clicks']))	$stats['clicks'] = 0;
if(empty($stats_today['impressions'])) $stats_today['impressions'] = 0;
if(empty($stats_today['clicks'])) $stats_today['clicks'] = 0;
if(empty($stats_last_month['impressions'])) $stats_last_month['impressions'] = 0;
if(empty($stats_last_month['clicks'])) $stats_last_month['clicks'] = 0;
if(empty($stats_this_month['impressions'])) $stats_this_month['impressions'] = 0;
if(empty($stats_this_month['clicks'])) $stats_this_month['clicks'] = 0;
if(empty($stats_graph_month['impressions'])) $stats_graph_month['impressions'] = 0;
if(empty($stats_graph_month['clicks'])) $stats_graph_month['clicks'] = 0;

// Get Click Through Rate
$ctr = adrotate_ctr($stats['clicks'], $stats['impressions']);
$ctr_today = adrotate_ctr($stats_today['clicks'], $stats_today['impressions']);
$ctr_last_month = adrotate_ctr($stats_last_month['clicks'], $stats_last_month['impressions']);
$ctr_this_month = adrotate_ctr($stats_this_month['clicks'], $stats_this_month['impressions']);
$ctr_graph_month = adrotate_ctr($stats_graph_month['clicks'], $stats_graph_month['impressions']);
?>
<h2><?php _e('Statistics for advert', 'adrotate'); ?> '<?php echo stripslashes($banner->title); ?>'</h2>
<table class="widefat" style="margin-top: .5em">

	<thead>
  	<tr>
        <th colspan="3"><center><strong><?php _e('Today', 'adrotate'); ?></strong></center></th>
        <th>&nbsp;</th>
		<th colspan="3"><center><strong><?php _e('All time', 'adrotate'); ?></strong></center></th>
  	</tr>
	</thead>
	<tbody>
  	<tr>
        <td width="16%"><div class="stats_large"><?php _e('Impressions', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats_today['impressions']; ?></div></div></td>
        <td width="16%"><div class="stats_large"><?php _e('Clicks', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats_today['clicks']; ?></div></div></td>
        <td width="16%"><div class="stats_large"><?php _e('CTR', 'adrotate'); ?><br /><div class="number_large"><?php echo $ctr_today.' %'; ?></div></div></td>

         <td>&nbsp;</td>
 
		 <td><div class="stats_large"><?php _e('Impressions', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats['impressions']; ?></div></div></td>
        <td width="16%"><div class="stats_large"><?php _e('Clicks', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats['clicks']; ?></div></div></td>
        <td width="16%"><div class="stats_large"><?php _e('CTR', 'adrotate'); ?><br /><div class="number_large"><?php echo $ctr.' %'; ?></div></div></td>
  	</tr>
	</tbody>
	<thead>
  	<tr>
        <th colspan="3"><center><strong><?php _e('Last month', 'adrotate'); ?></strong></center></th>
        <th>&nbsp;</th>
        <th colspan="3"><center><strong><?php _e('This month', 'adrotate'); ?></strong></center></th>
  	</tr>
	</thead>
	<tbody>
  	<tr>
        <td width="16%"><div class="stats_large"><?php _e('Impressions', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats_last_month['impressions']; ?></div></div></td>
        <td width="16%"><div class="stats_large"><?php _e('Clicks', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats_last_month['clicks']; ?></div></div></td>
        <td width="16%"><div class="stats_large"><?php _e('CTR', 'adrotate'); ?><br /><div class="number_large"><?php echo $ctr_last_month.' %'; ?></div></div></td>

        <td>&nbsp;</td>
 
        <td width="16%"><div class="stats_large"><?php _e('Impressions', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats_this_month['impressions']; ?></div></div></td>
        <td width="16%"><div class="stats_large"><?php _e('Clicks', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats_this_month['clicks']; ?></div></div></td>
        <td width="16%"><div class="stats_large"><?php _e('CTR', 'adrotate'); ?><br /><div class="number_large"><?php echo $ctr_this_month.' %'; ?></div></div></td>
  	</tr>
	<tbody>

</table>

<h2><?php _e('Monthly overview of clicks and impressions', 'adrotate'); ?></h2>
<form method="post" action="admin.php?page=adrotate-statistics&view=advert&id=<?php echo $id; ?>">
<table class="widefat" style="margin-top: .5em">
	<tbody>
	<tr>
        <th colspan="3">
        	<div style="text-align:center;"><?php echo adrotate_stats_nav('ads', $id, $month, $year); ?></div>
        	<?php 
				echo adrotate_stats_graph('ads', false, $id, 1, $monthstart, $monthend); 
			?>
        </th>
	</tr>
	<tr>
        <td width="33%"><div class="stats_large"><?php _e('Impressions', 'adrotate'); ?><br /><div class="number_large"><?php echo $stats_graph_month['impressions']; ?></div></div></td>
        <td width="33%"><div class="stats_large"><?php _e('Clicks', 'adrotate'); ?><br /><div class="number_large"><?php if($banner->tracker == "Y") { echo $stats_graph_month['clicks']; } else { echo '--'; } ?></div></div></td>
        <td width="34%"><div class="stats_large"><?php _e('CTR', 'adrotate'); ?><br /><div class="number_large"><?php if($banner->tracker == "Y") { echo $ctr_graph_month.' %'; } else { echo '--'; } ?></div></div></td>
	</tr>
	</tbody>

</table>	
</form>

<h2><?php _e('Periodic overview of clicks and impressions', 'adrotate'); ?></h2>
<table class="widefat" style="margin-top: .5em">	
	<thead>
	<tr>
        <th><?php _e('Shown from', 'adrotate'); ?></th>
        <th><?php _e('Shown until', 'adrotate'); ?></th>
        <th><center><?php _e('Max Clicks', 'adrotate'); ?> / <?php _e('Used', 'adrotate'); ?></center></th>
        <th><center><?php _e('Max Impressions', 'adrotate'); ?> / <?php _e('Used', 'adrotate'); ?></center></th>
	</tr>
	</thead>

	<tbody>
	<?php 
	foreach($schedules as $schedule) {
		$stats_schedule = adrotate_stats($id, false, $schedule->starttime, $schedule->stoptime);
		if($schedule->maxclicks == 0) $schedule->maxclicks = '&infin;';
		if($schedule->maximpressions == 0) $schedule->maximpressions = '&infin;';
	?>
  	<tr id='schedule-<?php echo $schedule->id; ?>'>
        <td><?php echo date_i18n("F d, Y - H:i", $schedule->starttime);?></td>
        <td><?php echo date_i18n("F d, Y - H:i", $schedule->stoptime);?></td>
        <td><center><?php echo $schedule->maxclicks; ?> / <?php echo $stats_schedule['clicks']; ?></center></td>
        <td><center><?php echo $schedule->maximpressions; ?> / <?php echo $stats_schedule['impressions']; ?></center></td>
  	</tr>
  	<?php 
  		unset($stats_schedule);
  	} 
  	?>
  	</tbody>
</table>

<p><center>
	<?php _e('Get more features with AdRotate Pro', 'adrotate'); ?> - <a href="admin.php?page=adrotate-pro"><?php _e('Upgrade now', 'adrotate'); ?></a>!<br />
	<em><small><strong><?php _e('Note:', 'adrotate'); ?></strong> <?php _e('All statistics are indicative. They do not nessesarily reflect results counted by other parties.', 'adrotate'); ?></small></em>
</center></p>