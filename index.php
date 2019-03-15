<?php
include('system/config.php');
?>
<!DOCTYPE>
<html lang="en">
<meta charset="utf-8">

<head>
    <title>ThesisLink</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="assets/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-light bg-light static-top" style="height:70px">
        <div class="container contSimulation">
            <a class="navbar-brand" href="#">ThesisLink</a>
            <div style="float:right;">
            <a class="btn btn-primary" href="https://github.com/ncflib/ThesesLink" target="_BLANK">Github</a>
            <a class="btn btn-primary" href="simulation.php">Get started</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row" style="padding-top:15px">
            <div class="col-md-12" >
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Welcome</h2>
                        <p class="card-text"><em>ThesisLink</em> is a web application that visualizes over 50 years of metadata from undergraduate theses by New College of Florida students. It presents users with an alternative: to view undergraduate theses as objects that are associated to each other via what we call intellectual links. The landing page gives you an idea of the intellectual production of NCF undergraduate students. Navigating to the simulation page via the "Get Started" button will redirect you to the network graph. You can use the network graph to <strong>discover</strong> Areas of Concentration, <strong>identify</strong> multidisciplinary Areas of Concentration, and <strong>discover</strong> theses related to topics you are interested in. Please navigate to the <strong>About</strong> page for more information and documentation. The project is still in its infancy.</p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary">More Info</a>
                    </div>
                </div>
            </div>
        </div>        
        <div class="row" style="padding-top:20px; padding-bottom:20px;">
            <div class="col-md-12 mb-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Yearly Distributions</h2>
                        <p class="card-text"><canvas id="myChart"></canvas>
                            <center>
                                <h2>Year</h2>
                                <input type="range" name="doughnut" id="doughnut" value="1990" min="1970" max="2018" oninput="randomize(this)" onChange="randomize(this)">
                                <br />
                                <h2>
                                    <div id="yearName" style="margin-top:30px;">1990</div>
                                </h2>
                            </center>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary">More Info</a>
                    </div>
                </div>
            </div>
          </div>
          <div class="row" style="padding-top:20px; padding-bottom:20px;">
            <div class="col-md-12 mb-12 center-block">
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
                <div class="row" style="padding-top:20px; padding-bottom:20px;">
            <div class="col-md-12 mb-12 center-block">
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
          </div>
        <div class="row">
            <div class="col-md-12 mb-12 center-block">
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
                        $query = $db->query("SELECT aoc, count(*) c FROM aocs WHERE aoc != 'Humanities' GROUP BY aoc ORDER BY `c` DESC LIMIT 0,10", PDO::FETCH_ASSOC);
                          foreach ( $query as $data ) { 
                            ?>
                                    <tr>
                                        <td>
                                            <?php echo $data['aoc']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['c']; ?>
                                        </td>
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
            <div class="row">
                <div class="col-lg-1">
                </div>
                <div class="col-lg-2">
                    <p class="m-0 text-white">
                        <font size="5">Contact</font> <br />
                        Jane Cook Library<br />
                        New College of Florida <br />
                        5800 Bay Shore Road <br />
                        Sarasota, FL 34243 <br />
                        (941) 487-5000 <br />
                        © 2019 <a href="example.html">asdasd</a><br />
                    </p>
                </div>
                <div class="col-lg-2">
                    <img src="http://dss.ncf.edu/main/user/images/g5_hydrogen/JBClogosmall_400x400.JPG?5c6f1aad" width="150" />
                </div>
                <div class="col-lg-4">
                </div>
            </div>
        </div>
    </footer>
</body>
<script src="js/jquery.js"></script>
<script src="js/d3.js"></script>
<script src="js/main.js"></script>
<script src="js/chartBundle.js"></script>
<script src="js/chartjs-plugin-labels.min.js"></script>
<script src="js/chart.js"></script>

</html>
