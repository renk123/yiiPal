YiiPal 
===============================
熟悉Drupal的人应该都会对CCK和Views这两个模块影响非常深刻，并且Drupal8 已经将这两个模块集至Drupal核心。不过由于Drupal的上手难度等种种原因，在中国Drupal的人才还是相对匮乏，招聘难度比较大，从头开始学习的话，周期会比较长。所以我计划以Yii2 为基础，开发一套类似集成Drupal CCK和Views的可配置系统，功能肯定没有CCK和Views强大，不过第一个版本计划做到简单实用即可，有兴趣的朋友可以联系我加入这个项目  QQ:359876077


计划功能列表
-------------------
Content Type  字段配置/显示配置
CCK  设置配置
	Text
	DropDown
	File
	Image
	Float
	Reference
	Date
	等等
Views  第一版可配置一个搜索页面即可（可配置搜索条件、结果字段，可分页、排序）
Taxonomy  保持跟Drupal功能一致
User	未定
Permission 用Yii2 RBAC实现
Profile 根据Content Type实现
...
