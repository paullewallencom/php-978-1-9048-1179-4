<?php
require_once 'XML/RSS.php';

$rss = new XML_RSS('http://blog.php-tools.net/feeds/index.rss2');
$rss->parse();

$channel = $rss->getChannelInfo();

print 'Channel data<br />';
printf('Title: %s<br />', $channel['title']);
printf('Description: %s<br />', $channel['description']);
printf('Link: <a href="%s">%s</a><br />', $channel['link'],
                                              $channel['link']);
print '<ul>';
$items = $rss->getItems();
foreach ($items as $item) {
    if (isset($item['dc:date'])) {
        $date = strtotime($item['dc:date']);
    } elseif ($item['pubDate']) {
        $date = strtotime($item['pubDate']);
    }
	printf('<li><a href="%s">%s</a> (%s)</li>', $item['link'],
	                                        $item['title'],
	                                        date('Y-m-d', $date));
}
print '</ul>';

$images = $rss->getImages();
foreach ($images as $image) {
	$size = getimagesize($image['url']);
	printf('<img src="%s" width="%d" height="%d" alt="%s" /><br />', $image['url'],
	       $size[0],
	       $size[1],
	       $image['title']);
}
?>