DROP TABLE h_admin;

CREATE TABLE `h_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `add_time` int(11) NOT NULL,
  `modify_time` int(11) NOT NULL,
  `last_login` int(11) DEFAULT NULL,
  `login_ip` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='admin table';

INSERT INTO h_admin VALUES("1","","allen","f502b8389bafbfda9cf7e80f68889d7a6d325d8d","0","0","1406249715","127.0.0.1");

DROP TABLE h_blog_category;

CREATE TABLE `h_blog_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `level` tinyint(4) DEFAULT '0',
  `path` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` varchar(256) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `path` (`path`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Resources';

INSERT INTO h_blog_category VALUES("22","0","1","0","0","Programing","");
INSERT INTO h_blog_category VALUES("32","22","1","1","0-22","Test","");
INSERT INTO h_blog_category VALUES("30","22","1","1","0-22","PHP","");
INSERT INTO h_blog_category VALUES("26","22","1","1","0-22","Java","");

DROP TABLE h_blog_posts;

CREATE TABLE `h_blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `title` text COLLATE utf8_bin NOT NULL,
  `post_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `content` longtext COLLATE utf8_bin NOT NULL,
  `post_status` enum('publish','draft','private') COLLATE utf8_bin NOT NULL DEFAULT 'publish',
  `comment_status` enum('open','closed') COLLATE utf8_bin NOT NULL DEFAULT 'open',
  `post_date` int(11) NOT NULL,
  `post_modifyed` int(11) DEFAULT NULL,
  `comment_count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `post_name` (`post_name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO h_blog_posts VALUES("2","1","测试","测试","<p><img width=\"530\" height=\"340\" src=\"http://api.map.baidu.com/staticimage?center=121.361365,31.158883&zoom=16&width=530&height=340&markers=121.361365,31.158883\"/></p>","publish","open","1405329748","1405413338","0");
INSERT INTO h_blog_posts VALUES("3","1","PHP函数测试","PHP函数测试","<pre class=\"brush:php;toolbar:false\">public&nbsp;function&nbsp;indexAction()&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;assign(&#39;menu_blog&#39;,&nbsp;1);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;saveUrlRef();
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$tbname&nbsp;=&nbsp;$result&nbsp;=&nbsp;$this-&gt;db()-&gt;tb_name(&#39;blog_posts&#39;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$params&nbsp;=&nbsp;array();
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$params[&#39;page&#39;]&nbsp;=&nbsp;$this-&gt;get(&#39;page&#39;,&nbsp;0);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$result&nbsp;=&nbsp;$this-&gt;db()-&gt;query(&quot;select&nbsp;*&nbsp;from&nbsp;$tbname&nbsp;WHERE&nbsp;1&nbsp;&quot;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$page&nbsp;=&nbsp;new&nbsp;\\H1Soft\\H\\Web\\Page();
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$page-&gt;setCurPage($this-&gt;get(&#39;page&#39;,&nbsp;0))-&gt;setUrl(&#39;blog/index&#39;)-&gt;setParams($params);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$page-&gt;count(&quot;select&nbsp;count(*)&nbsp;from&nbsp;`$tbname`&quot;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;assign(&#39;page&#39;,&nbsp;$page);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;assign(&#39;list&#39;,&nbsp;$result);

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;render(&#39;admin/blog_index&#39;);
&nbsp;&nbsp;&nbsp;&nbsp;}</pre><p><br/></p>","publish","open","1405330175","1405346193","0");
INSERT INTO h_blog_posts VALUES("4","1","test","test","<p>test</p>","publish","open","1405330199","1405349062","0");
INSERT INTO h_blog_posts VALUES("5","1","新文章","新文章","<p>新文章 欢迎大家阅读</p>","publish","open","1405592314","1405593451","0");

DROP TABLE h_blog_tags;

CREATE TABLE `h_blog_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO h_blog_tags VALUES("6","test");

DROP TABLE h_blog_tags_to_post;

CREATE TABLE `h_blog_tags_to_post` (
  `tag_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`,`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE h_blog_to_category;

CREATE TABLE `h_blog_to_category` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO h_blog_to_category VALUES("4","22");
INSERT INTO h_blog_to_category VALUES("4","26");
INSERT INTO h_blog_to_category VALUES("4","30");
INSERT INTO h_blog_to_category VALUES("4","32");
INSERT INTO h_blog_to_category VALUES("5","30");

DROP TABLE h_currency;

CREATE TABLE `h_currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL,
  `symbol_left` varchar(12) NOT NULL,
  `symbol_right` varchar(12) NOT NULL,
  `decimal_place` char(1) NOT NULL,
  `value` float(15,8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO h_currency VALUES("1","Pound Sterling","GBP","£","","2","0.58670002","1","2014-07-23 15:24:12");
INSERT INTO h_currency VALUES("2","US Dollar","USD","$","","2","1.00000000","1","2014-07-24 03:05:00");
INSERT INTO h_currency VALUES("3","Euro","EUR","","€","2","0.74250001","1","2014-07-23 15:24:12");

DROP TABLE h_group;

CREATE TABLE `h_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO h_group VALUES("5","Administrator","");
INSERT INTO h_group VALUES("16","Demo","test");

DROP TABLE h_lang;

CREATE TABLE `h_lang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `default_lang` tinyint(4) NOT NULL DEFAULT '0',
  `iso_code` char(2) NOT NULL,
  `language_code` char(5) NOT NULL,
  `directory` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lang_iso_code` (`iso_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO h_lang VALUES("1","中文简体","1","0","zh","zh-cn","chinese");
INSERT INTO h_lang VALUES("2","English","1","1","en","en-us","english");

DROP TABLE h_resources;

CREATE TABLE `h_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `level` tinyint(4) DEFAULT '0',
  `path` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `namespace` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` varchar(256) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `path` (`path`),
  KEY `namespace` (`namespace`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Resources';


DROP TABLE h_setting;

CREATE TABLE `h_setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(32) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`setting_id`),
  KEY `group` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

INSERT INTO h_setting VALUES("1","system","usessl","0","0");
INSERT INTO h_setting VALUES("2","system","store_name","You Store","0");
INSERT INTO h_setting VALUES("7","system","address","QiBao","0");
INSERT INTO h_setting VALUES("6","system","store_owner","H1Cart Ltd.","0");
INSERT INTO h_setting VALUES("8","system","email","83390286@qq.com","0");
INSERT INTO h_setting VALUES("9","system","telephone","15216688667","0");
INSERT INTO h_setting VALUES("10","system","fax","","0");
INSERT INTO h_setting VALUES("11","system","meta_tag_keywords","SSL","0");
INSERT INTO h_setting VALUES("12","system","meta_tag_description","H1Cart Store","0");
INSERT INTO h_setting VALUES("13","system","theme","default","0");
INSERT INTO h_setting VALUES("14","system","language","2","0");
INSERT INTO h_setting VALUES("15","system","admin_language","2","0");
INSERT INTO h_setting VALUES("16","system","item_pre_page","20","0");
INSERT INTO h_setting VALUES("17","system","admin_item_pre_page","20","0");
INSERT INTO h_setting VALUES("18","system","allow_reviews","1","0");
INSERT INTO h_setting VALUES("19","system","store_logo","http://127.0.0.1/h1cart/upload/geotrust_logo.gif","0");
INSERT INTO h_setting VALUES("20","system","store_icon","http://127.0.0.1/h1cart/upload/logo-icon.png","0");
INSERT INTO h_setting VALUES("21","mail","mail_protocol","MAIL","0");
INSERT INTO h_setting VALUES("22","mail","smtp_host","127.0.0.1","0");
INSERT INTO h_setting VALUES("23","mail","smtp_username","","0");
INSERT INTO h_setting VALUES("24","mail","smtp_password","","0");
INSERT INTO h_setting VALUES("25","mail","smtp_port","25","0");
INSERT INTO h_setting VALUES("26","mail","smtp_timeout","10","0");
INSERT INTO h_setting VALUES("27","mail","new_order_alert","0","0");

