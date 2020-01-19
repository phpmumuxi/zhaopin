<?php
// 行为插件
return array(
/**
+------------------------------------------------------------------------------
| 系统标签
+------------------------------------------------------------------------------
*/
		'app_begin' => array(
			'Common\Behavior\CheckIpbanBehavior', //禁止IP
			'Common\Behavior\CheckLangBehavior', //语言
			'Common\Behavior\CronRunBehavior',//定时任务
			'Common\Behavior\IsMobileBehavior',
			'Common\Behavior\SubsiteBehavior',
		),
		'view_filter' => array(
			'Common\Behavior\ContentReplaceBehavior', //路径替换
		),
		// 'template_filter' => array(
		// 	'Common\Behavior\ContentReplaceBehavior', //前端路径替换
		// )
);