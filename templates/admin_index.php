<div class="wrap">
    <h2>Dies wird die Lagerverwaltung</h2>
</div>
<div class="wrap">
    <h3>Akuteller Status: Auslesen von Datenbank informationen und einfache Anzeige dieser</h3>
<?php


global $wpdb;
// this adds the prefix which is set by the user upon instillation of wordpress
$table_name = $wpdb->prefix . "posts";
// this will get the data from your table
$retrieve_data = $wpdb->get_results( "SELECT ID, post_title FROM $table_name where post_type = 'product' and post_status='publish'" );
?> <table style="width:400px">
<tr>
    <th style="font-weight: bold;text-align: right">ProduktID</th>
    <th style="font-weight: bold;text-align: left">ProduktName</th>
</tr>
<?php 
foreach ($retrieve_data as $retrieved_data){ ?>
<tr>
<td style="text-align: right"><?php echo $retrieved_data->ID;?></td>
<td style="text-align: left"><?php echo $retrieved_data->post_title;?></td>
</tr>
<?php 
}
?>
</table> 
<?php