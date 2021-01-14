<?php
/**
 * @package DasPlugin
 */

?>


<div class="container; col-8">
    <div class="row">
        <h2>Lagerstand Zutaten</h2>
    </div>
</div>

<div class="container; col-8">
    <div class="row">
        <?php
            global $wpdb;
            // this adds the prefix which is set by the user upon instillation of wordpress
            $table_posts = $wpdb->prefix . "posts";
            $table_pml = $wpdb->prefix . "wc_product_meta_lookup";
            $table_tr = $wpdb->prefix . "term_relationships";
            $table_t = $wpdb->prefix . "terms";
            // this will get the data from your table
            //$retrieve_data = $wpdb->get_results( "SELECT ID, post_title FROM $table_name where post_type = 'product' and post_status='publish'" );

            $retrieve_data = $wpdb->get_results
            ( 
                "SELECT po.post_title, pm.stock_quantity, po.ID
                FROM $table_posts AS `po` , $table_pml AS `pm`, $table_tr as `tr`, $table_t as `t`
                WHERE
                po.ID = pm.product_id and
                po.ID =tr.object_id and
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
                <th style="font-weight: bold;text-align: left" scope="col">Lagerbestand SOLL</th>
                <th style="font-weight: bold;text-align: left" scope="col">Lagerbestand IST</th>
                <th style="font-weight: bold;text-align: left" scope="col">Auszulagernde Menge</th>
                <th style="font-weight: bold;text-align: left" scope="col">zu ändernde Menge</th>
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
                            <td style="text-align: left">Lagerbestand IST</td>
                            <td style="text-align: left">Auszulagernde Menge</td>
                            <td style="text-align: left"><input type="number" name="<?php echo $retrieved_data->ID;?>"></input></td>
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