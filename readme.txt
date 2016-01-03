=== oEmbed Internal Link ===
Contributors: miyauchi
Donate link: http://firegoby.jp/
Tags: widget
Requires at least: 3.2
Tested up to: 4.4
Stable tag: 0.5.0

Easy internal link by oEmbed.

== Description ==

Easy internal link by oEmbed.

[This plugin maintained on GitHub.](https://github.com/miya0001/oembed-internal-link)

= filter hooks example =

Filter for default template.

`<?php
    add_filter("oembed-internal-link-template", "my_template");
    function my_template($template) {
        return '<div class="%class%"><a href="%post_url%">%post_thumb%</a></div>';
    }
?>`

You can use tags in the template as below.

* %post_id%
* %post_url%
* %post_thumb%
* %post_excerpt%


Filter for stylesheet URI.

`<?php
    add_filter("oembed-internal-link-stylesheet", "my_style");
    function my_style($url) {
        return 'http://example.com/path/to/style.css';
    }
?>`


= Contributors =

* [Takayuki Miyauchi](http://firegoby.jp/)

== Installation ==

* A plug-in installation screen is displayed on the WordPress admin panel.
* It installs it in `wp-content/plugins`.
* The plug-in is made effective.

== Changelog ==

= 0.1.0 =
* The first release.

== Credits ==

This plug-in is not guaranteed though the user of WordPress can freely use this plug-in free of charge regardless of the purpose.
The author must acknowledge the thing that the operation guarantee and the support in this plug-in use are not done at all beforehand.

== Contact ==

twitter @miya0001
