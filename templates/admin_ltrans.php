<div class="wrap">
    <h2>Dies wird die Lagertransaktionsliste</h2>
</div>


 <?php
            global $wpdb;
            $table_hist = $wpdb->prefix . "hist";

            $retrieve_data = $wpdb->get_results
            ( 
                "SELECT hist.histID, hist.timestmp, hist.person, hist.change_log, hist.change_type
                FROM $table_hist AS `hist` 
            );
        ?>

<div class="container; col-8">
    <div class="row">

          <table class="table">
            <thead>
                <tr>
                <th style="font-weight: bold;text-align: left" scope="col">History ID</th>
                <th style="font-weight: bold;text-align: left" scope="col">Datum / Zeitpunk</th>
                <th style="font-weight: bold;text-align: left" scope="col">Person</th>
                <th style="font-weight: bold;text-align: left" scope="col">Art</th>
                <th style="font-weight: bold;text-align: left" scope="col">Änderung</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($retrieve_data as $retrieved_data)
                    { 
                        ?>
                        <tr>
                            <td style="text-align: left"><?php echo $retrieved_data->histID;?></td>
                            <td style="text-align: left"><?php echo $retrieved_data->timestmp;?></td>
                            <td style="text-align: left"><?php echo $retrieved_data->person;?></td>
                            <td style="text-align: left"><?php echo $retrieved_data->change_log;?></td>
                            <td style="text-align: left"><?php echo $retrieved_data->change_type;?></td>
                            <td style="text-align: left">Weitere Einträge Laden</td>
                            <td style="text-align: left"><a href="admin.php?page=gyc_lakt&id=<?php echo $retrieved_data->ID;?>">aktualisieren</a></td>
                        </tr>
                        <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
