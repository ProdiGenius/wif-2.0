<?php
include '../datalogin.php';

$doc = new DomDocument('1.0');
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;

$urlset = $doc->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9','urlset');
$urlset = $doc->appendChild($urlset);

$table_list = "select table_name from information_schema.tables
 where table_schema = 'heroku_e4756db2750b0d8'";
$rs = mysqli_query($conn, $table_list);

while ($row = mysqli_fetch_array($rs)){

	$datetime = new DateTime('NOW');
	$link = "http://www.watchitfree.me/movie.php?id=$row[0]";
	$signed_values = array('loc' => $link, 'lastmod' => $datetime->format('c'), 'changefreq' => 'weekly', 'priority' => '0.8');
	
  $occ = $doc->createElement('url');
  $occ = $urlset->appendChild($occ);

   foreach ($signed_values as $fieldname => $fieldvalue) {
       $child = $doc->createElement($fieldname);
       $child = $occ->appendChild($child);
       $value = $doc->createTextNode($fieldvalue);
       $value = $child->appendChild($value);
   }
}
echo $doc->saveXML();
$doc->save("sitemap.xml");
?>
