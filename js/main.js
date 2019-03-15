
var radius = [30, 10, 4]; // Radius values for node types. Divisions, AOCs and theses respectively.
var colors = ["#0094e0", "#18c97e", "#CC54B3"]; // Node colors for divisions. Humanities, natural sciences, social sciences respectively.
var colorsAOC = ["#59b7e0", "#8fc9ac", "#cc7fc0"]; // Node colors for AOCs. Humanities, natural sciences, social sciences respectively.
var states = []; // Queue for states. States include : Type ( 0 = All divisions ( main ), 1 = Division, 2 = AOC), Group (Division name or AOC name), Minimum Year, Maximum Year, Multidisciplinary Option 
var multivalue = 0; // Variable for multidisciplinary option. Defult = 0
var currentState = [0, 0, 0, 0, 0]; // Setting currentState to all 0s to start with "All Division" map.
var divisionNames = ["Humanities", "Natural Sciences", "Social Sciences", "All Divisions"];
updateDivision(3); // There is no division 3, it is defined 3 to get all divisions. Division ids are 0,1,2 for humanities, natural sciences, social sciences respestively.

$('#multi').change(function() { // Everytime the multidisciplinary option changes, the map should be updated.
    multivalue = $("#multi").prop('checked');
    if (multivalue) {
        multivalue = 1;
    } else {
        multivalue = 0;
    }
    if (currentState[0] == 1) {
        updateAoc(currentState[1], currentState[2], currentState[3], $("#multi").prop('checked'));
    }
    if (currentState[0] == 2) {
        updateSearch(currentState[1], currentState[2], currentState[3], $("#multi").prop('checked'));
    }
});

$("#searchAoc").submit(function(event) { // Handles the search bar.
    if( $("#search").val().length > 2) {
    updateSearch($("#search").val(), 1900, 2020, $("#multi").prop('checked'));
    } 
    event.preventDefault();
});

$('#doSearch').click(function() { // Handles the search bar again, in a bad way. Couldn't find another solution to handle clicking the button.
    if( $("#search").val().length > 2) {
    updateSearch($("#search").val(), 1900, 2020, $("#multi").prop('checked'));
    } 
    event.preventDefault();
});

$('#gobackList').click(function() { // Recolors the nodes and gets the theses list for the AOC in the right panel.
    d3.select("svg").selectAll("circle")
      .attr("fill", circleColour);
    goBackAoc();
    $('#gobackList').hide();
});

$('#goBackText').click(function() { // Goes back to the previous state.
    states.pop(); 
    latestState = states[states.length-1][0];
    console.log(latestState);
    if (latestState[0] == 0) { 
        updateDivision(latestState[1]);
        $("#divCharts").html();
        $("#category").html(divisionNames[latestState[1]]);
    }
    if (latestState[0] == 1) {
        updateAoc(latestState[1], latestState[2], latestState[3], latestState[4]);
    }
    if (latestState[0] == 2) {
        updateSearch(latestState[1], latestState[2], latestState[3], latestState[4]);
    }
    
    if(states.length == 1) {
    $('#gobackList').hide();
    }
    $('#detailedName').html("&nbsp;");

    states.pop();
});

$(document).ready(function() { // Handles the browsers' go-back button.
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function() {
        window.history.pushState(null, "", window.location.href);
    };
});

function goBackAoc() { // Takes theses list for AOC.
  $.ajax({
        url: "system/ajaxAOC.php?id=" + currentState[1] + "&year=" + currentState[2] + "&year2=" + currentState[3] + "&multi=" + currentState[4],
        type: "POST",
        success: function(msg2) {
            $("#divCharts").html(msg2);
            $("#category").html(currentState[1]);
        },
            contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        });
}

function getDetail(id) { // Gets thesis detail.
    $.ajax({
        url: "system/ajaxDetail.php?id=" + id,
        type: "POST",
        success: function(msg) {
            $("#divCharts").html(msg);
            $("#category").html("Thesis");
            $('#gobackList').show();
        },
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
    });
}

function addState(state) { // Adds state to the states queue.
    states.push(state);
}

function updateDivision(group) { // Updates the map with a division with id "group". If 3, shows all divisions.

    nodes_data2 = new Array();
    links_data2 = new Array();
    $.ajax({
        url: "system/ajaxDivision.php?id=" + group,
        type: "POST",
        success: function(msg) {
            nodes_data2 = msg[0];
            links_data2 = msg[1];
            drawGraph(nodes_data2, links_data2,0);

            if (group != 3) {
                $("#goBackText").show(); 
                currentState = [0, group, 0, 0, 0];
                addState([currentState]);
            } else {
                $("#goBackText").hide(); 
                currentState = [0, group, 0, 0, 0];
                addState([currentState]);
            }
        },
        dataType: "json"
    });

}

function updateAoc(group, year, year2, multivalue) { // Updates the map with an AOC with all the related AOCs.
    $("#map").hide();
    $("#loading").show();
    nodes_data2 = new Array();
    links_data2 = new Array();

    if (multivalue) {
        multivalue = 1;
    } else {
        multivalue = 0;
    }
    $.ajax({
        url: "system/ajaxAOCS.php?id=" + group + "&year=" + year + "&year2=" + year2 + "&multi=" + multivalue,
        type: "POST",
        success: function(msg) {

            $.ajax({
                url: "system/ajaxAOC.php?id=" + group + "&year=" + 1900 + "&year2=" + 2020 + "&multi=" + multivalue,
                type: "POST",
                success: function(msg2) {
                    nodes_data2 = msg[0];
                    links_data2 = msg[1];
                    drawGraph(nodes_data2, links_data2,1);
                    currentState = [1, group, year, year2, multivalue];
                    addState([currentState]);
                    $("#goBackText").show();
                    $("#category").html(group);
                    $("#nodeTitle").html("List of theses");
                    $("#divCharts").html(msg2);
                    $("#map").show();
                    $("#loading").hide();
                },
                contentType: "application/x-www-form-urlencoded;charset=UTF-8",
            });
        },
        dataType: "json"
    });

}

function updateSearch(group, year, year2, multivalue) { // Updates the map with all the AOCs that have the searched text in them and their related AOCs.
    $("#map").hide();
    $("#loading").show();
    nodes_data2 = new Array();
    links_data2 = new Array();
    if (multivalue) {
        multivalue = 1;
    } else {
        multivalue = 0;
    }
    $.ajax({
        url: "system/ajaxSearch.php?id=" + group + "&year=" + year + "&year2=" + year2 + "&multi=" + multivalue,
        type: "POST",
        success: function(msg) {
            $.ajax({
                url: "system/ajaxAOC.php?id=" + group + "&year=" + year + "&year2=" + year2 + "&multi=" + multivalue + "&search=1",
                type: "POST",
                success: function(msg2) {
                    nodes_data2 = msg[0];
                    links_data2 = msg[1];
                    drawGraph(nodes_data2, links_data2,1);
                    $("#goBackText").show();
                    $("#category").html("Search: " + group);
                    currentState = [2, group, year, year2, multivalue];
                    addState([currentState]);
                    $("#nodeTitle").html("List of theses");
                    $("#divCharts").html(msg2);
                    $("#map").show();
                    $("#loading").hide();
                },
                contentType: "application/x-www-form-urlencoded;charset=UTF-8",
            });

        },
        dataType: "json"
    });

}

function drawGraph(nodes_data, links_data, currents) { // D3.JS stuff.
    var svg = d3.select("svg"),
        width = $("#map").width(),
        height = +$("#map").height();

    svg.selectAll("*").remove();
    var simulation = d3.forceSimulation()
        //add nodes
        .nodes(nodes_data);

    function forceSimulation(nodes_data, links_data) {
        return d3.forceSimulation(nodes_data)
            .force("link", d3.forceLink().distance(linkDistance).strength(0.3))
            .force("charge", d3.forceManyBody())
            .force("center", d3.forceCenter());
    }

    var link_force = d3.forceLink(links_data)
        .id(function(d) {
            return d.name;
        });

    var charge_force = d3.forceManyBody()
        .strength(10);

    var center_force = d3.forceCenter(width / 2, height / 2);

    simulation
        .force("charge_force", charge_force)
        .force("center_force", center_force)
        .force("links", link_force)
        .force('collision', d3.forceCollide().radius(function(d) {
          if(currents == 1 || currents == 2) {
            if(d.type == 1) {
            return radius[d.type] + d.radius / 2 + 8;
            } else {
            return radius[d.type] + d.radius / 2 + 1;
            }
          } else {
            return radius[d.type] + d.radius / 2 + 3;
          }          
        }));

    ;

    simulation.on("tick", tickActions);
    if(currents == 1 || currents == 2) {
    for (var i = 0; i < 200; ++i) simulation.tick();
    } else {
    for (var i = 0; i < 150; ++i) simulation.tick(); 
    }
    function linkDistance(d) {
        return Math.sqrt(d.value);
    }

    //draw lines for the links 
    var link = svg.append("g")
        .attr("class", "links")
        .selectAll("line")
        .data(links_data)
        .enter().append("line")
        .attr("stroke-opacity", 0.6)
        .attr("stroke-width", 2.5)
        .style("stroke", linkColour);

    var node = svg.append("g")
        .attr("class", "nodes")
        .selectAll("circle")
        .attr("duration", function(d) {
            return 1000;
        })
        .data(nodes_data)
        .enter().append("circle")
        .attr("cx", function(d) {
            return d.x;
        })
        .attr("cy", function(d) {
            return d.y;
        })
        .attr("node-name", function(d) {
            return d.name;
        })
        .attr("node-id", function(d) {
            return d.id;
        })
        .attr("r", function(d) {
            return radius[d.type] + d.radius / 2;
        })
        .attr("fill", circleColour)
        .on('mouseover', function(d) {

            if (d.type == "1") {
                $('circle[node-id="' + d.id + '"]').attr('r', radius[d.type] + d.radius / 2 + 10);
                $('#detailedName').html("AOC : " + d.name);
            }

            if (d.type == "2") {
                $('circle[node-id="' + d.id + '"]').attr('r', radius[d.type] + d.radius / 2 + 5);
                $('#detailedName').html("Thesis : " + d.name);
            }

        })
        .on('mouseout', function(d) {

            if (d.type == "1") {
                $('circle[node-id="' + d.id + '"]').attr('r', radius[d.type] + d.radius / 2);
                $('#detailedName').html("&nbsp;");
            }

            if (d.type == "2") {
                $('circle[node-id="' + d.id + '"]').attr('r', radius[d.type] + d.radius / 2);
                $('#detailedName').html("&nbsp;");
            }
        })

        .on('click', function(d) {

            if (d.type == "0") {

                updateDivision(d.group);
                $("#category").html(d.name);

            }

            if (d.type == "1") {

                multivalue = $("#multi").prop('checked');
                updateAoc(d.name, 1900, 2019, multivalue);

            }
            if (d.type == "2") {
                d3.select("svg").selectAll("circle")
                .attr("fill", circleColour);
                var results = links_data.filter(function (a) {
                    return a.target.name === d.name;
                });
                results.forEach(function(result) {
                  $('circle[node-name="'+result.source.name+'"]').attr('wcol','1');
                });
                $('circle').not('circle[wcol=1]').attr('fill','#dbdbdb');
                $('circle').attr('wcol','0');
                $('circle[node-id="' + d.id + '"]').attr('fill','black');
                getDetail(d.id);

            }

        });

    var myText = svg.selectAll(".mytext")
        .data(nodes_data)
        .style("word-wrap", "break-word")
        .enter()
        .append("text");

    node.append("title")
        .text(function(d) {
            return d.title;
        })

    myText.style("fill", "black")
        .text(function(d) {
            return d.title;
        })
        .attr('text-anchor', 'middle')
        .attr("text-id", function(d) {
            return d.id;
        })
        .style("width", "50px")
        .style("word-wrap", "break-word")
        .style("cursor", "default")
        .attr('alignment-baseline', 'middle')
        .on('mouseover', function(d) {

        });


    var drag_handler = d3.drag()
        .on("start", drag_start)
        .on("drag", drag_drag)
        .on("end", drag_end);

    drag_handler(node)



    /** Functions **/
 
    //Function to choose what color circle we have
    //Let's return blue for males and red for females
    //Function to choose the line colour and thickness 
    //If the link type is "A" return green 
    //If the link type is "E" return red 
    function linkColour(d) {
        if (d.target == "Natural Sciences") {
            return "red";
        } 
    }




    //drag handler
    //d is the node 
    function drag_start(d) {
        if(currents == 1) {
        if (!d3.event.active) simulation.alphaTarget(0.02).restart();
        } else {
        if (!d3.event.active) simulation.alphaTarget(0.01).restart();
        }

        d.fx = d.x;
        d.fy = d.y;
    }

    function drag_drag(d) {

        d.fx = d3.event.x;
        d.fy = d3.event.y;


    }


    function drag_end(d) {
        if (!d3.event.active) simulation.alphaTarget(0);
        d.fx = null;
        d.fy = null;
    }

    function tickActions() {
        //constrains the nodes to be within a box
        node
            .attr("cx", function(d) {
                return d.x = Math.max(radius[d.type], Math.min(width - radius[d.type], d.x));
            })
            .attr("cy", function(d) {
                return d.y = Math.max(radius[d.type], Math.min(height - radius[d.type], d.y));
            });

        link
            .attr("x1", function(d) {
                return d.source.x;
            })
            .attr("y1", function(d) {
                return d.source.y;
            })
            .attr("x2", function(d) {
                return d.target.x;
            })
            .attr("y2", function(d) {
                return d.target.y;
            });

        myText
            .attr("x", function(d) {
                return d.x;
            })
            .attr("y", function(d) {
                return d.y;
            });
    }
}
      function circleColour(d) {
          if (d.type == "2") {
              return "black";
          } else if(d.type == "1") {
                return colorsAOC[d.group];
            } else {
              return colors[d.group];
          }
      }