<!DOCTYPE>
<html lang="en">
<meta charset="utf-8">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ThesesLink</title>
    <link href="assets/style.css?id=<?php echo rand(100,500000); ?>" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container contSimulation">
            <a class="navbar-brand" href="#">ThesisLink</a>
            <a class="btn btn-primary" href="index.php">Go to landing page</a>
        </div>
    </nav>
    <div class="container contSimulation">
        <div class="row" style="padding-top:10px; padding-bottom:15px; min-height:100%; height:100%">
            <div class="col-lg-8">
                <div id="mapDiv" height="550" width="100%">
                    <div class="divisionText" id="divisionText" style="float:left; position:absolute;">
                        <button type="button" class="btn btn-primary" class="alldivisionButton" style="margin-top:5px;">
                            <- Go Back</button> </div> <div class="list" style="margin:auto;" style="float:left;">
                                <center>
                                    <h1>
                                        <div id="nodeTitle" style="margin-top:5px;">List of AOCs</div>
                                    </h1>
                                </center>
                    </div>
                    <div class="nodeTitle2" style="margin:auto;">
                        <center>
                            <font size="3px"><span id="detailedName">&nbsp;</span></font>
                        </center>
                    </div>
                    <svg width="100%" id="map" style="height:80%; min-height:80%"></svg>
                    <div width="100%" id="loading" style="height:80%; min-height:80%; display:none;">

                        <div class="loaderdiv" style="padding-top:30%;">
                            <div class="loader" style="margin:auto;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" id="charts">
                <form id="searchAoc" autocomplete="off">
                    <div class="input-group mb-3" style="padding-top:10px">
                        <input type="text" id="search" class="form-control" placeholder="Search in AOCs" aria-label="Username" aria-describedby="basic-addon1" style="margin-right:20px">
                        <input type="button" class="btn btn-outline-secondary" id="doSearch" value="Search" style="color:black" />
                    </div>
                </form>
                <div class="alert alert-primary"><input type="checkbox" id="multi" /> <b>Only show multidisciplinary theses</b></div>
                <hr />
                <h2>
                    <center>
                        <div id="category">All Divisions</div>
                    </center>
                </h2>
                <hr />
                <button class="btn btn-primary" id="gobackList" style="display:none; margin:auto; margin-bottom:5px;">Go back to AOC list</button>
                <div id="divCharts">
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
                    © 2019 <br /></p>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://d3js.org/d3.v4.min.js"></script>
<script src="js/main.js?id=<?php echo rand(100,500000); ?>"></script>

</html>
