<?php
/**
 * @package DasPlugin
 */
global $id, $stockup, $DataTitle, $DataAvRating, $DataRatingCount, $DataQua, $DataId,  $DataStockStatus, $DataProduktBeschreibung;

if (isset($_GET['id']))
{
    $id = $_GET['id'];
    getData();
    if (isset($_GET['stockupdate']))
    {
        if($_GET['stockupdate']> 0)
        {
            $stockup = $_GET['stockupdate'];
            updateStock();
            $stockup = 0;
            $link = "admin.php?page=gyc_lakt&id="+$id;
            header('Location: admin.php?page=gyc_lakt&id='.$id);
        }

    }

}

?>
<div class="container; col-8">
    <div class="row">
        <h1>Artikel Ansicht</h1>
    </div>
    <h2><?php global $DataTitle; echo $DataTitle; ?></h2>
    <div class="row">
        <div class="container col-8">
            <h4>Durchschnittliche Bewertung: <span class="label label-default float-right"><?php echo $DataAvRating; ?></span></h4>
            <h4>Anzahl an Bewertungen: <span class="label label-default float-right"><?php echo $DataRatingCount; ?></span></h4>
            <h4>Status <span class="label label-default float-right"><?php echo $DataStockStatus; ?></span></h4>
            <h4>Lagernd <span class="label label-default float-right"><?php echo  $DataQua; ?></span></h4>

                <h4>Stock Zugang:
                    
                    <button class="btn btn-primary float-right" onclick="DomSub()">Speichern</button>
                    <input type="hidden" id="idfeld" value="<?php echo $id; ?>">

                    <input type="text" class="form-control float-right col-2" id="StockZugang" value="0">
                </h4>

            <form action="form_submit.php" method="post" >
            


        </div>
        <div class="container col-4">
        <h3>Beschreibung</h3>
        <p><?php global $DataTitle; echo $DataProduktBeschreibung; ?> </p>

        </div>
    </div>
    <div class="row col-8">
       
    </div>


</div>

<script>
    function DomSub() {
        var stock = document.getElementById("StockZugang").value;
        var Curid = document.getElementById("idfeld").value;
        var link = "admin.php?page=gyc_lakt&id="+Curid+"&stockupdate="+stock;
        console.log(link);
        
        window.location.href=link;
        
    }
</script>

<?php

function getData()
{
    global $wpdb, $id, $DataTitle, $DataAvRating, $DataRatingCount, $DataQua, $DataId, $DataStockStatus, $DataProduktBeschreibung;
    // this adds the prefix which is set by the user upon instillation of wordpress
    $table_name1 = $wpdb->prefix . "posts";
    $table_name2 = $wpdb->prefix . "wc_product_meta_lookup";
    // this will get the data from your table
    //$retrieve_data = $wpdb->get_results( "SELECT ID, post_title FROM $table_name where post_type = 'product' and post_status='publish'" );

    $retrieve_data = $wpdb->get_results
    ( 
        "SELECT po.post_title, pm.stock_quantity, po.ID ,pm.stock_status, po.post_excerpt
        FROM $table_name1 AS `po` , $table_name2 AS `pm` 
        WHERE
        po.ID = pm.product_id and
        po.post_type = 'product' and
        po.post_status = 'publish' and
        po.id = $id"
    );
    foreach ($retrieve_data as $retrieved_data)
    {
        $DataTitle = $retrieved_data->post_title;
        $DataQua = $retrieved_data->stock_quantity;
        $DataId = $retrieved_data->ID;
        $DataStockStatus = $retrieved_data->stock_status;
        $DataProduktBeschreibung = $retrieved_data->post_excerpt;
    }


}

function updateStock()
{
    global $wpdb,$stockup, $id, $DataTitle, $DataAvRating, $DataRatingCount, $DataQua, $DataId, $DataStockStatus, $DataProduktBeschreibung;
    $table_name1 = $wpdb->prefix . "postmeta";
    $table_name2 = $wpdb->prefix . "wc_product_meta_lookup";

    $wpdb->query("UPDATE $table_name1 SET meta_value=meta_value + '$stockup' WHERE post_id='$id' and meta_key = '_stock' ");
    $wpdb->query("UPDATE $table_name1 SET meta_value= 'instock' WHERE post_id='$id' and meta_key = '_stock_status' ");
    $wpdb->query("UPDATE $table_name2 SET stock_quantity=stock_quantity + '$stockup' WHERE product_id='$id' ");
    $wpdb->query("UPDATE $table_name2 SET stock_status='instock' WHERE product_id='$id' and stock_quantity > '0' ");

}

