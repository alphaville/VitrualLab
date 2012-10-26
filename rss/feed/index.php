<?php
include "../../global.php";
include "../../database.php";
$lang = $_GET['lang'];
if (!$lang) {
    $lang = 'en';
}
$type = $_GET['type'];
if (!$type) {
    $type = "rss";
}
if ($type == "rss") {
    header("Content-type:application/rss+xml; charset=utf-8");
} else {
    header("Content-type:application/atom+xml; charset=utf-8");
}
if ($type == "rss") {
    echo '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
        <channel>
                <title>Virtual Lab</title>
                <description>Automatic Control Virtual Lab</description>
                <link>' . $__URL__ . '</link>
                <lastBuildDate>Tue, 03 Apr 2012 15:52:28 +0000</lastBuildDate>
                <generator>VLAB Internal RSS Generator</generator>
                <atom:link rel="self" type="application/rss+xml" href="' . $__URL__ . '"/>
                <language>en-gb</language>';
} elseif ($type == "atom") {
    echo '<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom"  xml:lang="en-gb">
	<title type="text">Virtual Lab</title>
	<subtitle type="text">Automatic Control Virtual Lab</subtitle>
	<link rel="alternate" type="text/html" href="' . $__URL__ . '"/>
	<id>' . $__URL__ . '</id>
	<updated>2012-04-07T11:19:34+00:00</updated>
	<generator uri="http://vlab.mooo.info" version="1.0">VLAB internal generator</generator>
	<link rel="self" type="application/atom+xml" href="' . $__URL__ . '/rss/feed?type=' . $type . '"/>';
}

$con = connect();
if ($con) {
    $query = "SELECT `title`,`link`, `guid`, `author`, `description`, `pubDate` from `rss` where lang='" . $lang . "' order by `pubDate` desc limit 25";
    $result = mysql_query($query, $con);
    while ($row = mysql_fetch_array($result)) {
        //TODO: Modify to comply to ATOM standards
        echo "<item>
                        <title>" . $row['title'] . "</title>
                        <link>" . $row['link'] . "</link>
                        <guid isPermaLink=\"false\">" . $row['guid'] . "</guid>
                        <description><![CDATA[<p>" . $row['description'] . "<p>]]></description>
                        <author>" . $row['author'] . "</author>
                        <pubDate>" . date('r',strtotime($row['pubDate'])) . "</pubDate>
              </item>
              ";
    }
}
mysql_close($con);
echo '</channel></rss>';
?>