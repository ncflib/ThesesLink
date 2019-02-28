var radius = [30, 10, 4, 10];
var colors = ["#0094e0", "#18c97e", "#CC54B3"];
var clicked = 0;
var states = []; 
// humanities, natural sciences, social sciences.
var currentState = [0, 0, 0, 0, 0];
updateDivision(3);
$('#multi').change(function() {
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

$("#searchAoc").submit(function(event) {
    if( $("#search").val().length > 2) {
    updateSearch($("#search").val(), 1900, 2020, $("#multi").prop('checked'));
    } 
    event.preventDefault();
});
$('#doSearch').click(function() {
    if( $("#search").val().length > 2) {
    updateSearch($("#search").val(), 1900, 2020, $("#multi").prop('checked'));
    } 
    event.preventDefault();
});
$('#gobackList').click(function() {
    d3.select("svg").selectAll("circle")
      .attr("fill", circleColour);
    goBackAoc();
    $('#gobackList').hide();
});
$('#divisionText').click(function() {
    // Take the latest state from the list
    console.log(states); 
    states.pop(); 
    latestState = states[states.length-1][0];
    console.log(latestState)
    states.pop();
    if (latestState[0] == 0) { 
        updateDivision(latestState[1]);
        $("#divCharts").html();
        $("#category").html("All Divisions");
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
});

$(document).ready(function() {
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function() {
        window.history.pushState(null, "", window.location.href);
    };
});

function goBackAoc() {
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

function getDetail(id) {

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
function addState(state) {
    states.push(state);
}
function updateDivision(group) {

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
                $("#divisionText").show();
                currentState = [0, group, 0, 0, 0];
                addState([currentState]);
            } else {
                $("#divisionText").hide();
                currentState = [0, group, 0, 0, 0];
                addState([currentState]);
            }
        },
        dataType: "json"
    });

}

function updateAoc(group, year, year2, multivalue) {
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
                    $("#divisionText").show();
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

function updateSearch(group, year, year2, multivalue) {
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
                    $("#divisionText").show();
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

function drawGraph(nodes_data, links_data, currents) {
    var svg = d3.select("svg"),
        width = $("#map").width(),
        height = +$("#map").height();

    svg.selectAll("*").remove();
    //set up the simulation 
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
                clicked = 1;
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
          } else {
              return colors[d.group];
          }
      }