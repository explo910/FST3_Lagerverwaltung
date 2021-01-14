<?php
/**
 * @package DasPlugin
 */
global $id, $stockup, $DataTitle, $DataQua, $DataId,  $DataStockStatus, $DataProduktBeschreibung, $DataStk;

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
        <h2>Ware entsorgen</h2>
    </div>
    <h1><?php global $DataTitle; echo $DataTitle; ?></h1>
    <div class="row">
        <div class="container col-8">
            <h4>Status <span class="label label-default float-right"><?php echo $DataStockStatus; ?></span></h4>
            <h4>Gesamte Menge: <span class="label label-default float-right"><?php echo  $DataStk; ?></span></h4>
            <h4>Nicht verkaufte Menge: <span class="label label-default float-right"><?php echo  $DataQua; ?></span></h4>

                <h4>Entsorgte Menge:
                    
                    <button class="btn btn-primary float-right" onclick="DomSub()">Speichern</button>
                    <input type="hidden" id="idfeld" value="<?php echo $id; ?>">

                    <input type="number" min="0" class="form-control float-right col-2" id="StockZugang" value="0">
                </h4>

            <form action="form_submit.php" method="post" >
            


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
    global $wpdb, $id, $DataTitle, $DataQua, $DataId, $DataStockStatus, $DataProduktBeschreibung, $DataStk;
    // this adds the prefix which is set by the user upon instillation of wordpress
    $table_name1 = $wpdb->prefix . "posts";
    $table_name2 = $wpdb->prefix . "wc_product_meta_lookup";
    // this will get the data from your table
    //$retrieve_data = $wpdb->get_results( "SELECT ID, post_title FROM $table_name where post_type = 'product' and post_status='publish'" );

    $retrieve_data = $wpdb->get_results
    ( 
        "SELECT po.post_title, pm.stock_quantity, po.ID ,pm.stock_status, po.post_excerpt, is.stock
        FROM $table_name1 AS `po` , $table_name2 AS `pm` , internal_stock as `is`
        WHERE
        po.ID = pm.product_id and
        po.ID = is.wc_post and
        po.post_type = 'product' and
        po.post_status = 'publish' and
        po.id = $id"
    );
    foreach ($retrieve_data as $retrieved_data)
    {
        $DataTitle = $retrieved_data->post_title;
        $DataQua = $retrieved_data->stock_quantity;
        $DataStk = $retrieved_data->stock;
        $DataId = $retrieved_data->ID;
        $DataStockStatus = $retrieved_data->stock_status;
        $DataProduktBeschreibung = $retrieved_data->post_excerpt;
    }


}

function updateStock()
{
    global $wpdb,$stockup, $id, $DataTitle, $DataAvRating, $DataRatingCount, $DataQua, $DataId, $DataStockStatus, $DataProduktBeschreibung, $DataStk;
    $table_name1 = $wpdb->prefix . "postmeta";
    $table_name2 = $wpdb->prefix . "wc_product_meta_lookup";
    $table_posts = $wpdb->prefix . "posts";

    $tempstockint = $wpdb->get_var("select stock from internal_stock where wc_post=$id");
    $tempstockpub = $wpdb->get_var("select stock_quantity from $table_name2 WHERE product_id='$id' ");

    if ($tempstockpub-$stockup > 0 && $tempstockint-$stockup > 0) {
        $productname=$wpdb->get_var("select post_title from $table_posts where id=$id");
        $wpdb->query("update internal_stock set stock=stock-'$stockup' where wc_post=$id");
        $wpdb->query("UPDATE $table_name1 SET meta_value=meta_value - '$stockup' WHERE post_id='$id' and meta_key = '_stock' ");
        $wpdb->query("UPDATE $table_name1 SET meta_value= 'instock' WHERE post_id='$id' and meta_key = '_stock_status' ");
        $wpdb->query("UPDATE $table_name2 SET stock_quantity=stock_quantity - '$stockup' WHERE product_id='$id' ");
        $wpdb->query("UPDATE $table_name2 SET stock_status='instock' WHERE product_id='$id' and stock_quantity > '0' ");
        $current_user = wp_get_current_user();
        $newstock=$tempstockint-$stockup;
        $wpdb->query("insert hist(timestmp,person,change_log,change_type) values ('".date("Y.m.d H:i:s")."','".$current_user->user_login."','$productname wurde von $tempstockint auf $newstock geändert','Entsorgt')");
    } else {
        echo "ERROR - nicht genügend Produkte vorhanden";
    }
}

