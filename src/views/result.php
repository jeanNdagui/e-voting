<?php if (isset($results) && count($results) > 0):?>
<section class="container mt-5">
  <div class="row">
    <div class="col-12 col-md-6">
      <div class="d-flex justify-content-center">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th scope="col">Num</th>
              <th scope="col">Nom</th>
              <th scope="col">Parti</th>
              <th scope="col">Votes</th>
            </tr>
          </thead>
          <tbody>
            <?php showResult($results); ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <!--Div that will hold the pie chart-->
      <div id="chart_div" class="w-100 h-100 d-inline-block">

      </div>

    </div>
  </div>


</section>
<?php else: ?>
  <section class="admin__login container pt-5">
      <div class="alert alert-info text-center" role="alert">
        Les résultats ne sont pas encore disponibles.
      </div>
  </section>
<?php endif ?>

<?php
function showResult(array $results)
{
  $results = $results;
  if (isset($results)) {
    $i = 1;
    foreach ($results as $el) {
      print <<<HTML
         <tr>
           <th scope="row">$i</th>
           <td>{$el["name"]}</td>
           <td>{$el["party"]}</td>
           <td>{$el["nb_cast"]}</td>
         </tr>
HTML;
      $i++;
    }
  }else{echo "fhuhughjuhg";}
}
?>

<script type="text/javascript">
  // Load the Visualization API and the corechart package.
  google.charts.load('current', {
    'packages': ['corechart']
  });

  // Set a callback to run when the Google Visualization API is loaded.
  google.charts.setOnLoadCallback(drawChart);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function drawChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
      <?php foreach ($results as $el) : ?>['<?= $el["name"] ?>', <?= $el["nb_cast"] ?>],
      <?php endforeach; ?>
    ]);

    // Set chart options
    var options = {
      'title': 'Répartition des votes'
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script>