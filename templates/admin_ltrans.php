<div class="wrap">
  <h1>Lagertransaktionsliste - Spechtelliste
  </h1>
</div>


</br>

<div class="container; col-8">
    <div class="col">
      <form method="post" action="admin.php?page=gyc_ltrans">
      <div class="row-4">
         Von: <input type="date" name="von">
         Bis: <input type="date" name="bis">
      </div>
      <div class="row-3">
        Anzahl Eintr&auml;ge: 
        <input type="text" name="lines">
        <input type="submit" value="aktualisieren"> 
        </div>
      </form>
    </div>

</br>

  <div class="row">
    <table class="table">
      <thead>
        <tr>
          <th style="font-weight: bold;text-align: left" scope="col">History ID
          </th>
          <th style="font-weight: bold;text-align: left" scope="col">Datum / Zeitpunk
          </th>
          <th style="font-weight: bold;text-align: left" scope="col">Person
          </th>
          <th style="font-weight: bold;text-align: left" scope="col">Art
          </th>
          <th style="font-weight: bold;text-align: left" scope="col">&Auml;nderung
          </th>
        </tr>
      </thead>
      <tbody>
       <?php
            $count = 50;
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if (isset($_POST['lines']) and $_POST['lines'] > 0)
                {
                    $count = $_POST['lines'];
                }
                if (isset($_POST['von']) and $_POST['von'] > 0)
                {
                    $von = $_POST['von'];
                }
                if (isset($_POST['bis']) and $_POST['bis'] > 0)
                {
                    $bis = $_POST['bis'];
                }

                global $wpdb;
                $table_hist = "hist";
                if (isset($von) && isset($bis))
                {
                    $retrieve_data = $wpdb->get_results("SELECT hist.histID, hist.timestmp, hist.person, hist.change_log, hist.change_type
            FROM $table_hist AS `hist` where hist.timestmp between \'$von\' and \'$bis\' order by hist.histID desc");
                }
                else
                {
                    $retrieve_data = $wpdb->get_results("SELECT hist.histID, hist.timestmp, hist.person, hist.change_log, hist.change_type
            FROM $table_hist AS `hist` order by hist.histID desc");
                }

            }
            $counter = 2;
            foreach ($retrieve_data as $retrieved_data)
            {
            ?>

        <tr>
          <td style="text-align: left">
            <?php echo $retrieved_data->histID;?>
          </td>
          <td style="text-align: left">
            <?php echo $retrieved_data->timestmp;?>
          </td>
          <td style="text-align: left">
            <?php echo $retrieved_data->person;?>
          </td>
          <td style="text-align: left">
            <?php echo $retrieved_data->change_log;?>
          </td>
          <td style="text-align: left">
            <?php echo $retrieved_data->change_type;?>
          </td>
        </tr>
        <?php
            if ($counter>$count) {
                break;
            }
                $counter++;
            }
            ?>
      </tbody>
    </table>
  </div>
</div>
