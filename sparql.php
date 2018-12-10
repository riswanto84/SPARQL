<?php
    /**
     * Making a SPARQL SELECT query
     *
     * This example creates a new SPARQL client, pointing at the
     * dbpedia.org endpoint. It then makes a SELECT query that
     * returns all of the countries in DBpedia along with an
     * english label.
     *
     * Note how the namespace prefix declarations are automatically
     * added to the query.
     *
     * @package    EasyRdf
     * @copyright  Copyright (c) 2009-2013 Nicholas J Humfrey
     * @license    http://unlicense.org/
     */
    set_include_path(get_include_path() . PATH_SEPARATOR . '../lib/');
    require_once "lib/EasyRdf.php";
    require_once "lib/html_tag_helpers.php";
    // Setup some additional prefixes for DBpedia
    EasyRdf_Namespace::set('category', 'http://dbpedia.org/resource/Category:');
    EasyRdf_Namespace::set('dbpedia', 'http://dbpedia.org/resource/');
    EasyRdf_Namespace::set('dbo', 'http://dbpedia.org/ontology/');
    EasyRdf_Namespace::set('dbp', 'http://dbpedia.org/property/');
    $sparql = new EasyRdf_Sparql_Client('http://dbpedia.org/sparql');
?>
<html>
<head>
  <title>EasyRdf Basic Sparql Example</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>EasyRdf Basic Sparql Example</h1>

<h2>Daftar Nama Gunung</h2>
<table border="1" cellpadding="5">
<tr>
<td>Nama Gunung</td>
<td>Ketinggian (meter)</td>
<td>Negara</td>
</tr>
<?php
    $result = $sparql->query(
        'SELECT DISTINCT ?mountain ?elevation ?country WHERE {'.
        '  ?mountain dbo:country ?country.'.
        '  ?mountain dbo:elevation ?elevation .'.
        '} ORDER BY DESC(?elevation) LIMIT 10'
    );
	
    foreach ($result as $row) {
		echo "<tr>";
        echo "<td>".link_to($row->mountain)."</td>\n";
		echo "<td>".link_to($row->elevation)."</td>\n";
		echo "<td>".link_to($row->country)."</td>\n";
		echo "</tr>";
    }
?>
</table>
<p>Total number of countries: <?= $result->numRows() ?></p>

</body>
</html>