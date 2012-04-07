<?

header("Content-type:application/rss+xml");
include "../global.php";
include "../database.php";
$lang=$_GET['lang'];
if (!$lang) {
    $lang = 'en';
}

echo '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
        <channel>
                <title>Virtual Lab</title>
                <description>Automatic Control Virtual Lab</description>
                <link>http://vlab.mooo.info</link>
                <lastBuildDate>Tue, 03 Apr 2012 15:52:28 +0000</lastBuildDate>
                <generator>VLAB Internal RSS Generator</generator>
                <atom:link rel="self" type="application/rss+xml" href="http://vlab.mooo.info/rss/feed.php"/>
                <language>en-gb</language>';
$con = connect();
if ($con) {
    $query = "SELECT `title`,`link`, `guid`, `author`, `description`, `pubDate` from `rss` where lang='" . $lang . "' order by `pubDate` desc";
    echo $query;
    $result = mysql_query($query, $con);
    while ($row = mysql_fetch_array($result)) {
        echo "<item>
                        <title>" . $row['title'] . "</title>
                        <link>" . $row['link'] . "</link>
                        <guid isPermaLink=\"false\">" . $row['guid'] . "</guid>
                        <description><![CDATA[<p>" . $row['description'] . "<p>]]></description>
                        <author>" . $row['author'] . "</author>
                        <pubDate>" . $row['pubDate'] . "</pubDate>
                </item>";
    }
}
mysql_close($con);
echo '</channel></rss>';
?>