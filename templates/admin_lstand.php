<?php
/**
 * @package DasPlugin
 */

?>


<?php

        global $wpdb;
        // this adds the prefix which is set by the user upon instillation of wordpress
        $table_posts = $wpdb->prefix . "posts";
        $table_pml = $wpdb->prefix . "wc_product_meta_lookup";
        $table_tr = $wpdb->prefix . "term_relationships";
        $table_t = $wpdb->prefix . "terms";
        $table_pm = $wpdb->prefix . "postmeta";
        global $Zutatenstring;


        //E,A,B


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // collect value of input field
            $changes="";
            $changetype="";
            for($i=0;$i<9999;$i++) {
                if(isset($_POST[$i])) {
                    if($_POST[$i] != 0) {
                        if ($_POST[$i]>0 && $changetype=="") {
                            $changetype="Eingelagert";
                        } else if ($_POST[$i]<0 && $changetype=="") {
                            $changetype="Ausgelagert";
                        } else if ($_POST[$i]<0 && $changetype=="Eingelagert" || $_POST[$i]>0 && $changetype=="Ausgelagert") {
                            $changetype="Kombiniert";
                        }
                        $tempstockint = $wpdb->get_var("select stock from internal_stock where wc_post=$i");
                        $tempstockpub = $wpdb->get_var("select stock_quantity from $table_pml WHERE product_id='$i' ");

                        if ($_POST[$i] < 0 && $tempstockint+$_POST[$i] >= $tempstockpub) {
                            $wpdb->query("update internal_stock set stock=stock+$_POST[$i] where wc_post=$i");
                        } else {
                            $wpdb->query("update internal_stock set stock=stock+$_POST[$i] where wc_post=$i");
                            $wpdb->query("UPDATE $table_pm SET meta_value=meta_value + $_POST[$i] WHERE post_id='$i' and meta_key = '_stock' ");
                            $wpdb->query("UPDATE $table_pm SET meta_value= 'instock' WHERE post_id='$i' and meta_key = '_stock_status'");
                            $wpdb->query("UPDATE $table_pml SET stock_quantity=stock_quantity + $_POST[$i] WHERE product_id='$i' ");
                            $wpdb->query("UPDATE $table_pml SET stock_status='instock' WHERE product_id='$i' and stock_quantity > '0' ");
                        }

                        $productname=$wpdb->get_var("select post_title from $table_posts where id=$i");
                        $newstock=$tempstockint+$_POST[$i];
                        $changes=$changes."$productname wurde von $tempstockint auf $newstock geändert|";
                    }
                }
            }

            if($changes != "") {
                $current_user = wp_get_current_user();
                $changes=substr($changes, 0, -1);
                $wpdb->query("insert hist(timestmp,person,change_log,change_type) values ('".date("Y.m.d H:i:s")."','".$current_user->user_login."','".$changes."','".$changetype."')");
            }
        }
        ?>

<form method="post" action="admin.php?page=gyc_lstand">

<div class="container; col-8">
    <div class="row">
        <h2>Lagerstand Zutaten</h2>
    </div>
</div>

<div class="container; col-8">
    <div class="row">
        <?php

            // this will get the data from your table
            //$retrieve_data = $wpdb->get_results( "SELECT ID, post_title FROM $table_name where post_type = 'product' and post_status='publish'" );

            $retrieve_data = $wpdb->get_results
            ( 
                "SELECT po.post_title, pm.stock_quantity, po.ID, is.stock
                FROM $table_posts AS `po` , $table_pml AS `pm`, $table_tr as `tr`, $table_t as `t`, internal_stock as `is`
                WHERE
                po.ID = pm.product_id and
                po.ID =tr.object_id and
                po.ID = is.wc_post and
                po.post_type = 'product' and
                po.post_status = 'publish' and
                tr.term_taxonomy_id=t.term_id and
                t.name='Zutaten'"
            );
        ?>
        <table class="table">
            <thead>
                <tr>
                <th style="font-weight: bold;text-align: left" scope="col">Zutat</th>
                <th style="font-weight: bold;text-align: left" scope="col">Lagerbestand Gesamt</th>
                <th style="font-weight: bold;text-align: left" scope="col">Lagerbestand Verfügbar</th>
                <th style="font-weight: bold;text-align: left" scope="col">Mindestlagerbestand</th>
                <th style="font-weight: bold;text-align: left" scope="col">Auftragsmenge</th>
                <th style="font-weight: bold;text-align: left" scope="col">zu ändernde Menge</th>
                <th style="font-weight: bold;text-align: left" scope="col">Ware entsorgen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    global $Zutatenstring;
                    foreach ($retrieve_data as $retrieved_data)
                    { 
                        $minstock = $wpdb->get_var("select meta_value from $table_pm where post_id=$retrieved_data->ID and meta_key='_low_stock_amount'");
                        $colorstring = "";
                        if ($retrieved_data->stock<$minstock) {
                            $colorstring = "; background-color: red";
                            $anzahl = $minstock*1.5-$retrieved_data->stock;
                            $Zutatenstring = $Zutatenstring.$anzahl."x".$retrieved_data->post_title."%0D%0A";
                        } else if ($retrieved_data->stock<$minstock*1.5) {
                            $colorstring = "; background-color: yellow";
                        }
                        ?>
                        <tr>
                            <td style="text-align: left"><?php echo $retrieved_data->post_title;?></td>
                            <td style="text-align: left <?php echo $colorstring; ?>"><?php echo $retrieved_data->stock;?></td>
                            <td style="text-align: left"><?php echo $retrieved_data->stock_quantity;?></td>
                            <td style="text-align: left"><?php echo $minstock;?></td>
                            <td style="text-align: left"><?php echo $retrieved_data->stock-$retrieved_data->stock_quantity;?></td>
                            <td style="text-align: left"><input type="number" name="<?php echo $retrieved_data->ID;?>" value="0"></input></td>
                            <td style="text-align: left"><a href="admin.php?page=gyc_lakt&id=<?php echo $retrieved_data->ID;?>">Ware entsorgen</a></td>
                        </tr>
                        <?php 
                    }
                ?>
                        <tr>
                            <td style="text-align: left"></td>
                            <td style="text-align: left"><a class="btn btn-primary" href="mailto:lieferant@beispiel.com?subject=Zutatenbestellung%20GetYourCake&body=Sehr%20geehrtes%20Verkaufsteam%2C%0D%0A%0D%0AHiermit%20bestellen%20wir%20folgende%20Produkte%3A%0D%0A%0D%0A<?php echo $Zutatenstring ?>%0D%0AMit%20freundlichen%20Gr%C3%BC%C3%9Fen%20%0D%0AGetYourCake%20Einkaufsabteilung">Bestellung erstellen</a></td>
                            <td style="text-align: left"></td>
                            <td style="text-align: left"></td>
                            <td style="text-align: left"></td>
                            <td style="text-align: left"><input class="btn btn-primary" type="submit" value="Lagerstand aktualisieren"></td>
                            <td style="text-align: left"></td>
                        </tr>
            </tbody>
        </table>

        

        
        </form>




    </div>
</div>

<?php