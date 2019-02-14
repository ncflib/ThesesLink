<?php
include('system/config.php');
?>
<!DOCTYPE>
<html lang="en">
<meta charset="utf-8">
  <head>
    <title>Library Thesis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="assets/style.css?id=<?php echo rand(100,500000); ?>" rel="stylesheet">
  </head>
<body>
    <nav class="navbar navbar-light bg-light static-top" style="height:70px">
      <div class="container">
        <a class="navbar-brand" href="#">Library Theses</a>
        <a class="btn btn-primary" href="simulation.php">Go to simulation</a>
      </div>
    </nav>
    <div class="container">
      <div class="row" style="padding-top:15px">
        <div class="col-md-12 mb-12">
          <div class="card">
            <div class="card-body">
              <h2 class="card-title">Card One</h2>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">More Info</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="padding-top:20px; padding-bottom:20px;">
        <div class="col-md-6 mb-6">
          <div class="card">
            <div class="card-body">
              <h2 class="card-title">Card One</h2>
              <p class="card-text"><canvas id="myChart" height="200"></canvas>
              <center><h2>Year</h2>
              <input type="range" name="doughnut" id="doughnut" value="1990" min="1970" max="2018" oninput="randomize(this)" onChange = "randomize(this)">
              <br />
              <h2><div id="yearName" style="margin-top:30px;">1990</div></h2></center>
            </p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">More Info</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-6">
          <div class="card">
            <div class="card-body">
              <h2 class="card-title">Card Two</h2>
              <p class="card-text"><canvas id="lineChart" height="200"></canvas>
              </p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">More Info</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="padding-top:10px; padding-bottom:20px;">
          <div class="col-md-6 mb-6">
            <div class="card">
              <div class="card-body">
                <h2 class="card-title">Card Three</h2>
                <p class="card-text"><canvas id="lineChartMulti" height="200"></canvas>
                </p>
              </div>
              <div class="card-footer">
                <a href="#" class="btn btn-primary">More Info</a>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-6">
            <div class="card">
              <div class="card-body">
                <h2 class="card-title">AOC</h2>
                <p class="card-text">
                  <table class="table table-dark">
                    <thead>
                      <tr>
                        <th scope="col">AOC</th>
                        <th scope="col">Number of Theses</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $query = mysql_query("SELECT aoc, count(*) c FROM aocs WHERE aoc != 'Humanities' GROUP BY aoc ORDER BY `c` DESC LIMIT 0,10");
                        while($data = mysql_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo mysql_real_escape_string($data['aoc']); ?></td>
                            <td><?php echo $data['c']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </p>
              </div>
              <div class="card-footer">
                <a href="#" class="btn btn-primary">More Info</a>
              </div>
            </div>
          </div>
      </div>
    </div>
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Library Theses 2018</p>
      </div>
    </footer>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://d3js.org/d3.v4.min.js"></script>
<script src="js/main.js?id=<?php echo rand(100,500000); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
<script src="js/chartjs-plugin-labels.min.js"></script>
<script src="js/chart.js?id=<?php echo rand(); ?>"></script>
</html>