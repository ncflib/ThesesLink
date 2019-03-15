var ctx = document.getElementById("myChart").getContext('2d');
//var ctx2 = document.getElementById("myChart2").getContext('2d');
var config = {
  type: 'doughnut',
  data: {
    labels: ["Humanities","Natural Sciences","Social Sciences"],
    datasets: [{
      backgroundColor: [
        "#0094e0", 
        "#18c97e", 
        "#CC54B3"
      ],
      data: [37,22,42]
    }]
  },
  options: {
    circumference: Math.PI,
    rotation: -Math.PI,
    responsive: true,
    plugins: {
      labels: {
        render: 'value',
        fontSize: 25,
        fontStyle: 'bold',
        fontColor: '#FFF'
      }
    },
    legend: {  
      position:'bottom'
    }
  }
};
var chart = new Chart(ctx, config);
//var chart2 = new Chart(ctx2, config);
var timeout = null;
var doughnut = JSON.parse('{"1970":[16,7,3],"1971":[9,5,4],"1972":[9,7,9],"1973":[22,13,32],"1974":[49,29,44],"1975":[49,33,90],"1976":[21,11,25],"1977":[30,30,35],"1978":[25,19,34],"1979":[35,21,18],"1980":[33,28,30],"1981":[29,27,30],"1982":[52,27,29],"1983":[30,27,27],"1984":[20,15,22],"1985":[20,15,19],"1986":[20,15,18],"1987":[26,25,35],"1988":[31,23,31],"1989":[26,24,27],"1990":[37,22,42],"1991":[50,23,51],"1992":[37,22,48],"1993":[44,16,46],"1994":[57,23,31],"1995":[37,21,44],"1996":[39,25,45],"1997":[48,30,45],"1998":[56,31,42],"1999":[44,39,55],"2000":[41,29,54],"2001":[60,40,74],"2002":[38,36,48],"2003":[50,34,56],"2004":[44,26,72],"2005":[49,29,48],"2006":[51,25,55],"2007":[55,30,62],"2008":[71,37,59],"2009":[59,36,65],"2010":[49,34,70],"2011":[53,44,71],"2012":[64,36,79],"2013":[51,48,100],"2014":[45,38,61],"2015":[68,33,75],"2016":[49,59,64]}');
function randomize(selectObject) {
  var value = selectObject.value;
  var i = -1;
  if (timeout !== null) {
        clearTimeout(timeout);
  }
  document.getElementById("yearName").innerHTML = value;
  timeout = setTimeout(function () {
  config.data.datasets.forEach(function(dataset) {
    dataset.data = dataset.data.map(function() {
      i = i + 1;
      console.log(doughnut[value]);
      return doughnut[value][i];
    });
  });
  
  chart.update();
  }, 40); 
}


 var configLineDivision = {
      type: 'line',
      data: {
        labels: [1970,1971,1972,1973,1974,1975,1976,1977,1978,1979,1980,1981,1982,1983,1984,1985,1986,1987,1988,1989,1990,1991,1992,1993,1994,1995,1996,1997,1998,1999,2000,2001,2002,2003,2004,2005,2006,2007,2008,2009,2010,2011,2012,2013,2014,2015,2016,2017,2018],
        datasets: [{
          label: 'Humanities',
          backgroundColor: "#0094e0",
          borderColor: "#0094e0",
          data: [
            16,9,9,22,49,49,21,30,25,35,33,29,52,30,20,20,20,26,31,26,37,50,37,44,57,37,39,48,56,44,41,60,38,50,44,49,51,55,71,59,49,53,64,51,45,68,49,45,54
          ],
          fill: false,
        }, {
          label: 'Natural Sciences',
          backgroundColor: "#18c97e",
          borderColor: "#18c97e",
          fill: false,
          data: [
            7,5,7,13,29,33,11,30,19,21,28,27,27,27,15,15,15,25,23,24,22,23,22,16,23,21,25,30,31,39,29,40,36,34,26,29,25,30,37,36,34,44,36,48,38,33,59,59,60
          ],
        },{
          label: 'Social Sciences',
          backgroundColor: "#CC54B3",
          borderColor: "#CC54B3",
          fill: false,
          data: [
            3,4,9,32,44,90,25,35,34,18,30,30,29,27,22,19,18,35,31,27,42,51,48,46,31,44,45,45,42,55,54,74,48,56,72,48,55,62,59,65,70,71,79,100,61,75,64,60,66
          ],
        }
        ]
      },
      options: {
        responsive: true,
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        plugins: {
          labels: {
            render: 'value'
          }
        },
        legend: {  
          position:'bottom'
        } ,
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Year'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Theses Number'
            }
          }]
        }
      }
    };

var ctx2 = document.getElementById("lineChart").getContext('2d');
var chart2 = new Chart(ctx2, configLineDivision);


var configLineMulti = {
      type: 'line',
      data: {
        labels: [1970,1971,1972,1973,1974,1975,1976,1977,1978,1979,1980,1981,1982,1983,1984,1985,1986,1987,1988,1989,1990,1991,1992,1993,1994,1995,1996,1997,1998,1999,2000,2001,2002,2003,2004,2005,2006,2007,2008,2009,2010,2011,2012,2013,2014,2015,2016,2017,2018],
        datasets: [{
          label: 'Single Disciplinary',
          backgroundColor: "#2ecc71",
          borderColor: "#2ecc71",
          data: [
            22,14,22,56,103,144,47,85,66,64,78,74,91,72,51,44,42,67,72,66,94,103,93,88,85,91,82,102,104,117,96,137,94,114,117,96,104,115,131,125,119,118,141,144,97,117,125,129,145
          ],
          fill: false,
        }, {
          label: 'Multi Disciplinary',
          backgroundColor: "#3498db",
          borderColor: "#3498db",
          fill: false,
          data: [
            4,4,3,11,19,28,10,10,12,10,13,12,17,12,6,10,11,19,13,11,7,21,14,18,26,11,27,21,25,21,28,37,28,26,25,30,27,32,36,35,34,50,38,55,47,59,47,35,35
          ],
        }
        ]
      },
      options: {
        responsive: true,
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        plugins: {
          labels: {
            render: 'value'
          }
        },
        legend: {  
          position:'bottom'
        } ,
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{ 
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Year'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Number of Theses'
            }
          }]
        }
      }
    };
var ctx3 = document.getElementById("lineChartMulti").getContext('2d');
var chart3 = new Chart(ctx3, configLineMulti);

