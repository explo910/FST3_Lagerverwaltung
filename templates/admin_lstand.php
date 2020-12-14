<?php
/**
 * @package DasPlugin
 */

?>


<div class="container; col-8">
    <div class="row">
        <h1>Lagerstand Zutaten</h1>
    </div>
</div>

<div class="container; col-8">
    <div class="row">
        <?php
            global $wpdb;
            // this adds the prefix which is set by the user upon instillation of wordpress
            $table_name1 = $wpdb->prefix . "posts";
            $table_name2 = $wpdb->prefix . "wc_product_meta_lookup";
            // this will get the data from your table
            //$retrieve_data = $wpdb->get_results( "SELECT ID, post_title FROM $table_name where post_type = 'product' and post_status='publish'" );

            $retrieve_data = $wpdb->get_results
            ( 
                "SELECT po.post_title, pm.stock_quantity, po.ID
                FROM $table_name1 AS `po` , $table_name2 AS `pm` 
                WHERE
                po.ID = pm.product_id and
                po.post_type = 'product' and
                po.post_status = 'publish' and
                po.post_excerpt = 'ZUTAT'"
            );
        ?>
        <table class="table">
            <thead>
                <tr>
                <th style="font-weight: bold;text-align: left" scope="col">Zutat</th>
                <th style="font-weight: bold;text-align: left" scope="col">Lagermenge</th>
                <th style="font-weight: bold;text-align: left" scope="col">Bestand aktualisieren</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($retrieve_data as $retrieved_data)
                    { 
                        ?>
                        <tr>
                            <td style="text-align: left"><?php echo $retrieved_data->post_title;?></td>
                            <td style="text-align: left"><?php echo $retrieved_data->stock_quantity;?></td>
                            <td style="text-align: left"><a href="admin.php?page=gyc_lakt&id=<?php echo $retrieved_data->ID;?>">aktualisieren</a></td>
                        </tr>
                        <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>



<?php