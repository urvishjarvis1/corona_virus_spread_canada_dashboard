<!DOCTYPE html>
<html lang="en">

<head>
  <title>Confirmed COVID Cases in Canada</title>


  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $.ajax({
        type: "GET",
        url: "/RestAPI/DataCountAPI.php?regionid=6",
        dataType: "JSON",
        success: function(response) {
          $("#totalcase").text(response.total_count)
          $('#activecase').text(response.active_count)
          $('#recoveredcase').text(response.recovered_count)
        }
      });
    });
  </script>
</head>


<style type="text/css">
  /* Remove the navbar's default margin-bottom and rounded borders */
  .navbar {
    margin-bottom: 0;
    border-radius: 0;
  }

  /* Add a gray background color and some padding to the footer */
  footer {
    background-color: #ffffff;
    padding: 25px;
  }

  body {
    font: 10px sans-serif;
    background-color: #ffffff;
  }

  .axis path,
  .axis line {
    fill: none;
    stroke: #000;
    shape-rendering: crispEdges;
  }

  .x.axis path {
    display: none;
  }

  .line {
    fill: none;
    stroke: steelblue;
    stroke-width: 1.5px;
  }

  div.count {
    position: fixed;
    text-align: center;
    width: 100px;
    height: 100px;
    padding: 2px;
    font: 12px sans-serif;
    background: #FFFFFF;
    border: 2px;
    border-radius: 8px;
    pointer-events: none;


  }
</style>

<body>
  <div class="header">
    <div class="container-fluid bg-3  text-center">
      <div class="row">
        <div class="col-sm-4">
          <p style="font-size:20px"> Total Cases</p>
          <p id="totalcase" style="font-size: 30px;color: black "></p>
        </div>
        <div class="col-sm-4">
          <p style="font-size:20px"> Acitve Cases</p>
          <p id="activecase" style="font-size: 30px;color: red"></p>
        </div>
        <div class="col-sm-4">
          <p style="font-size:20px"> Recovered Cases</p>
          <p id="recoveredcase" style="font-size: 35px;color: blue"></p>
        </div>
      </div>
    </div>

  </div>

  <div class="container-fluid bg-3 text-center">

    <div class="row">
      <div class="col-sm-4">

        <div id="map" class="img-responsive" style="width:100%;height: 50%">
          <svg viewBox="0 0 500 350"></svg>
          <script src="https://unpkg.com/d3@5.9.2/dist/d3.min.js"></script>
          <script src="https://unpkg.com/topojson@3.0.2/dist/topojson.min.js"></script>
          <script src="color.js"></script>
          <script>
            d3map = d3
            window.d3 = null
            const svg = d3map.select('svg');
            //  const titleText     = 'Confirmed COVID Cases in Canada Choropleth Map';
            const width = +svg.attr('width');
            const height = +svg.attr('height');
            const projection = d3map.geoMercator();
            const pathGenerator = d3map.geoPath().projection(projection);
            const div = d3map.select("body").append("div")
              .attr("class", "count")
              .style("opacity", 0);
            //    const graph           = d3.select("body").append("div")
            //                            .attr("class", "period")
            //                            .style("opacity", 0);
            //  var parseDate = d3.time.format("%Y%m%d").parse;
            var RegionID = 0;
            var color = null;
            var RegionCount = [0, 0, 0, 0, 0, 0];
            var RegionName = [];
            var ActiveCount = [0, 0, 0, 0, 0, 0];
            var RecoverCount = [0, 0, 0, 0, 0, 0];
            var RegionNames = ['', 'Atlantic', 'Quebec', 'Ontario and Nunavut', 'Prairies', 'British Columbia and Yukon'];
            //  var color = d3.scale.category10();
            const g = svg.append('g');

            //  var parseDate = d3.time.format("%Y%m%d").parse;
            //  var x = d3.time.scale().range([0, width]);

            //  var y = d3.scale.linear().range([height, 0]);
            //    var color = d3.scale.category10();

            //    var xAxis = d3.svg.axis().scale(x).orient("bottom");

            //    var yAxis = d3.svg.axis().scale(y).orient("left");

            //  var line = d3.svg.line().interpolate("basis").x(function(d) {return x(d.date);}).y(function(d) {return y(d.count);});
            var mapData
            $.ajax({
              type: "GET",
              url: "/RestAPI/DataCountAPI.php",
              dataType: "JSON",
              success: function(response) {

                mapData = response
              }
            });

            svg.call(d3map.zoom().on('zoom', () => {
              4
              g.attr('transform', d3map.event.transform);
            }));

            g.append("text")
              .attr("x", (width / 2))
              .attr("y", 40)
              .attr("text-anchor", "middle")
              .style("font-size", "20px")
            //   .html(titleText);
            $.ajax({
              type: "GET",
              url: "/RestAPI/GetRegion.php",

              success: function(response) {
                responseData = response.toString();
                res = $.parseJSON(responseData)
                RegionName = res["reg"].map(function(d) {
                  return d.region_name;
                })

              }
            });

            d3map.json('http://localhost/RestAPI/DataCountAPI.php').then((region) => {
              d3map.json('canada.json').then((data) => {

                region.forEach(function(d, i) {


                  RegionCount[d.region] += parseInt(d.total_count);
                  ActiveCount[d.region] += parseInt(d.active_count);
                  RecoverCount[d.region] += parseInt(d.recoverd_count);
                });
                color = d3map.scaleOrdinal().domain([d3map.min(RegionCount), d3map.max(RegionCount)])
                  .range(['#bdd7e7', '#6baed6', '#bdd7e7', '#2171b5', '#2171b5'])

                g.selectAll('path')
                  .data(data.features)
                  .enter()
                  .append('path')
                  .attr('d', pathGenerator)
                  .style('stroke', 'black')
                  .style('stroke-width', '0.1')
                  .attr('transform', 'translate(-170,100) scale(2,2)')
                  .attr('fill', function(d) {
                    return color(d.RegionID)
                  });

                g.selectAll('path')
                  .data(data.features)
                  .on("mouseover", function(d) {


                    d3map.selectAll('path').data(data.features).style('stroke-width', '0.1')

                    d3map.selectAll('path')
                      .filter(function(data, i) {

                        if (data != null)
                          if (data.RegionID == d.RegionID) {
                            return data.RegionID;
                          }
                      })
                      .style('stroke-width', '0.5')
                      .style("opacity", 1);

                    d3map.selectAll('path')
                      .filter(function(data, i) {
                        if (data != null)
                          if (data.RegionID != d.RegionID) {
                            return data.RegionID;
                          }
                      })
                      .style('stroke-width', '0.1')
                      .style("opacity", 0.5);

                    div.html(
                        "<table>" +
                        "<tr>" +
                        "<th style=\"font-size:15px\">" + RegionName[d.RegionID - 1] + "</th>" +
                        "</tr>" +
                        "<tr>" +
                        "<th>Total Cases:</th>" +
                        "<td>" + RegionCount[d.RegionID] + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<th>Active Cases: </th>" +
                        "<td>" + ActiveCount[d.RegionID] + "</td>" +
                        "</tr>" +

                        "<tr>" +
                        "<th>Recovered Cases: </th>" +
                        "<td>" + RecoverCount[d.RegionID] + "</td>" +
                        "</tr>" +
                        "</table>"
                      )
                      .style("left", 10 + "px")
                      .style("top", 120 + "px")
                      .style("width", 200 + "px")
                      .style("opacity", .9)

                  })
                  .on('mouseout', function(d) {
                    d3map.selectAll('path')
                      .data(data.features)
                      .style('stroke-width', '0.2')
                      .style("opacity", 1);
                    div.style("opacity", 0);

                  })
                  .on("click", function(d) {
                    d3map.selectAll('path').data(data.features).style('stroke-width', '0.1')

                    d3map.selectAll('path')
                      .filter(function(data, i) {

                        if (data != null)
                          if (data.RegionID == d.RegionID) {
                            return data.RegionID;
                          }
                      })
                      .style('stroke-width', '1')
                      .style("opacity", 1);
                    fetchData(d.RegionID);
                    //fucntion call
                  });
                //        .on("click", function(clicked_data) {
                //            d3map.selectAll('path')
                //              .data(data.features)
                //              .style('stroke-width', '0.1')
                //            .style("opacity", 1);
                //          graph.style("opacity", 0);
                //          });
              });


            });

            function fetchData(region_id) {
              $.ajax({
                type: "GET",
                url: "/RestAPI/GetTimelineData.php?regionid=" + region_id,
                datatype: "json",
                success: function(response) {
                  pushData($.parseJSON(response))
                  pushGenderData(region_id)
                  pushTransData(region_id)
                  pushHospitalData(region_id)
                  pushOccupationData(region_id)
                  console.log(response)

                }
              });
            }
            //}(d3map, topojson));
          </script>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="img-responsive" style="width:100%; height:50%" alt="Image">
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
          <canvas id="mixed-chart" width="800" height="500"></canvas>
          <script>
            $(document).ready(function() {
              $.ajax({
                type: "GET",
                url: "/RestAPI/GetTimelineData.php?regionid=1",
                datatype: "json",
                success: function(response) {
                  isdefined = false
                  loadData($.parseJSON(response))

                }
              });
            })

            function pushData(responseData) {
              chart.destroy();
              loadData(responseData)
            }

            function loadData(responseData) {

    //          label = responseData["jsonarray"].map(function(d) {
    //            return d.onsetweekofsym;
    //          })
              label = responseData["jsonarray"].map(function(d) {
                if (d.onsetweekofsym == 8) {
                  return "Feb 23";
                } else if (d.onsetweekofsym == 9) {
                  return "Mar 01";
                } else if (d.onsetweekofsym == 10) {
                  return "Mar 08";
                } else if (d.onsetweekofsym == 11) {
                  return "Mar 15";
                } else if (d.onsetweekofsym == 12) {
                  return "Mar 22";
                } else if (d.onsetweekofsym == 13) {
                  return "Mar 29";
                } else if (d.onsetweekofsym == 14) {
                  return "Apr 05"
                } else if (d.onsetweekofsym == 15) {
                  return "Apr 12";
                }else if (d.onsetweekofsym == 16) {
                  return "Apr 19";
                }else if (d.onsetweekofsym == 17) {
                  return "Apr 26";
                }else if (d.onsetweekofsym == 18) {
                  return "May 03";
                }else if (d.onsetweekofsym == 19) {
                  return "May 10";
                }else if (d.onsetweekofsym == 20) {
                  return "May 17";
                }else if (d.onsetweekofsym == 21) {
                  return "May 24";
                }else if (d.onsetweekofsym == 22) {
                  return "May 31";
                }else if (d.onsetweekofsym == 99) {
                  return "Unknown";
                }
              })
              datas = responseData["jsonarray"].map(function(d) {
                return d.count;
              })
              lebel_death = responseData["deathdata"].map(function(d) {
                return d.onsetweekofsym;
              })
              death_datas = responseData["deathdata"].map(function(d) {
                return d.count;
              })

              var ctx = document.getElementById("mixed-chart")
            //  Chart.defaults.scale.gridLines.display = true;
              var config = {
                type: 'bar',
                data: {
                  labels: label,
                  datasets: [{
                    label: "Onset week of Symptoms",
                    type: "line",
                    borderColor: "#31a354",
                    data: datas,
                    fill: false
                  }, {
                    label: "Dead ",
                    type: "line",
                    borderColor: "#e30f0b",
                    data: death_datas,
                    fill: false
                  }]
                },
                options: {
                  title: {
                    display: true,
                    text: 'COVID Spread- Infected and dead'
                  },
                  legend: {
                    display: true
                  },
                  scales: {
                   xAxes: [{

                //     gridThickness:5,
                //      gridLines: {
                //        display: false,
                //        color: "#808080"
                //      },
                      scaleLabel: {
                        display: true,
                        labelString: "Weeks of the year 2020",
                        fontColor: "black"
                      }
                    }],
                    yAxes: [{
                  //    gridLines: {
                  //      color: "#808080",
                  //      borderDash: [1, 8],
                  //    },
                      scaleLabel: {
                        display: true,
                        labelString: "No: of Cases",
                        fontColor: "black"
                      }
                    }]
                  }
                }
              }
              chart = new Chart(ctx, config);
            }
          </script>
        </div>
      </div>

      <div class="col-sm-4">

        <div class="img-responsive" style="width:100% height=50%" alt="Image">
          <canvas id="bar-chart-grouped" width="800" height="500"></canvas>
          <script>
            $(document).ready(function() {
              $.ajax({
                type: "GET",
                url: "/RestAPI/GenderData.php?regionid=1",
                datatype: "json",
                success: function(response) {
                  isdefined = false
                  loadGenderData($.parseJSON(response))

                }
              });
            })

            function pushGenderData(region_id) {
              $.ajax({
                type: "GET",
                url: "/RestAPI/GenderData.php?regionid=" + region_id,
                datatype: "json",
                success: function(response) {
                  isdefined = false
                  pushGenderDataGraph($.parseJSON(response))

                }
              });
            }

            function pushGenderDataGraph(responseData) {
              chartGender.destroy();
              loadGenderData(responseData)
            }

            function loadGenderData(responseData) {
              label = responseData["male"].map(function(d) {
                if (d.agegroup == 1) {
                  return "0-19";
                } else if (d.agegroup == 2) {
                  return "20-29";
                } else if (d.agegroup == 3) {
                  return "30-39";
                } else if (d.agegroup == 4) {
                  return "40-49";
                } else if (d.agegroup == 5) {
                  return "50-59";
                } else if (d.agegroup == 6) {
                  return "60-69";
                } else if (d.agegroup == 7) {
                  return "70-79"
                } else if (d.agegroup == 8) {
                  return "80-";
                }
              })
              datas = responseData["male"].map(function(d) {
                return d.male_count;
              })

              death_datas = responseData["female"].map(function(d) {
                return d.female_count;
              })
              var ctxgender = document.getElementById("bar-chart-grouped")
              var configgender = {
                type: 'bar',
                data: {
                  labels: label,
                  datasets: [{
                    label: "Male",
                    backgroundColor: "#17becf",
                    data: datas
                  }, {
                    label: "Female",
                    backgroundColor: "#fb8072",
                    data: death_datas
                  }]
                },
                options: {
                  title: {
                    display: true,
                    text: 'COVID Spread- Total Cases:Gender & Age wise'
                  },
                  scales: {
                    xAxes: [{
                    zeroLineColor: '#FFFFFF',

                    scaleLabel: {
                        display: true,
                        labelString: "Age Groups",
                        fontColor: "black"
                      }
                    }],
                    yAxes: [{
                    zeroLineColor: '#FFFFFF',

                      scaleLabel: {
                        display: true,
                        labelString: "No: of Cases",
                        fontColor: "black"
                      }
                    }]
                  }
                }
              }
              chartGender = new Chart(ctxgender, configgender);
            }
          </script>


        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div id="" class="img-responsive" style="width:100% height=50%" alt="Image">
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
          <canvas id="bar-chart2" height="160"></canvas>
          <script type="text/javascript">
            $(document).ready(function() {
              $.ajax({
                type: "GET",
                url: "/RestAPI/GetTransmissionData.php?regionid=1",
                datatype: "json",
                success: function(response) {
                  isdefined = false
                  loadTransmissionData($.parseJSON(response))
                }
              });
            })

            function pushTransData(region_id) {
              $.ajax({
                type: "GET",
                url: "/RestAPI/GetTransmissionData.php?regionid=" + region_id,
                datatype: "json",
                success: function(response) {
                  isdefined = false
                  pushDataToGraph($.parseJSON(response))
                }
              });
            }

            function pushDataToGraph(responseData) {
              transChart.destroy();
              loadTransmissionData(responseData)
            }

            function loadTransmissionData(responseData) {
              var datas = [];
              dataTransmission1 = responseData.transmission_count;
              dataTransmission2 = responseData.transmission2_count;
              dataTransmission3 = responseData.transmission3_count;
              datas.push(dataTransmission1);
              datas.push(dataTransmission2);
              datas.push(dataTransmission3);
              var ctx = document.getElementById("bar-chart2");
              var config = {
                type: 'bar',
                data: {
                  labels: ["Domestic", "International Travel", "Unknown"],
                  datasets: [{
                    label: "Transmission",
                    backgroundColor: ["#8c96c6", "#8c96c6", "#8c96c6"],
                    data: datas
                  }]
                },
                options: {
                  legend: {
                    display: false
                  },
                  title: {
                    display: true,
                    text: 'COVID Spread through Transmission'
                  },
                  scales: {
                    yAxes: [{
                  //    gridLines: {
                  //      color: "#808080",
                  //      borderDash: [1, 8],
                  //    },
                      scaleLabel: {
                        display: true,
                        labelString: "No: of Cases",
                        fontColor: "black"
                      }
                    }]
                  }
                }
              }
              transChart = new Chart(ctx, config)
            }
          </script>
        </div>
      </div>
      <div class="col-sm-4">

        <div id="hospital" class="img-responsive" style="width:100% height=100%" alt="Image">
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
          <canvas id="mixed-chart2" width="800" height="430" style="margin-left: 300"></canvas>
          <script>
            $(document).ready(function() {
              $.ajax({
                type: "GET",
                url: "/RestAPI/GetHospitalData.php?regionid=1",
                datatype: "json",
                success: function(response) {
                  isdefined = false

                  loadHospitalData($.parseJSON(response))


                }
              });
            })

            function pushHospitalData(region_id) {

              $.ajax({
                type: "GET",
                url: "/RestAPI/GetHospitalData.php?regionid=" + region_id,
                datatype: "json",
                success: function(response) {
                  isdefined = false
                  pushHospitalDataToGraph($.parseJSON(response))

                }
              });
            }


            function pushHospitalDataToGraph(responseData) {
              hospitalChart.destroy();
              loadHospitalData(responseData)
            }

            function loadHospitalData(responseData) {
          //    label = responseData["icu"].map(function(d) {
        //        return d.onsetweekofsym;
          //    })
              label = responseData["icu"].map(function(d) {
                if (d.onsetweekofsym == 8) {
                  return "Feb 23";
                } else if (d.onsetweekofsym == 9) {
                  return "Mar 01";
                } else if (d.onsetweekofsym == 10) {
                  return "Mar 08";
                } else if (d.onsetweekofsym == 11) {
                  return "Mar 15";
                } else if (d.onsetweekofsym == 12) {
                  return "Mar 22";
                } else if (d.onsetweekofsym == 13) {
                  return "Mar 29";
                } else if (d.onsetweekofsym == 14) {
                  return "Apr 05"
                } else if (d.onsetweekofsym == 15) {
                  return "Apr 12";
                }else if (d.onsetweekofsym == 16) {
                  return "Apr 19";
                }else if (d.onsetweekofsym == 17) {
                  return "Apr 26";
                }else if (d.onsetweekofsym == 18) {
                  return "May 03";
                }else if (d.onsetweekofsym == 19) {
                  return "May 10";
                }else if (d.onsetweekofsym == 20) {
                  return "May 17";
                }else if (d.onsetweekofsym == 21) {
                  return "May 24";
                }else if (d.onsetweekofsym == 22) {
                  return "May 31";
                }else if (d.onsetweekofsym == 99) {
                  return "Unknown";
                }
              })
              datas = responseData["icu"].map(function(d) {
                return d.count;
              })

              hospital_datas = responseData["hospital"].map(function(d) {
                return d.count;
              })
              notHospital_datas = responseData["nothospital"].map(function(d) {
                return d.count;
              })

              var ctx = document.getElementById("mixed-chart2")
              var config = {
                type: 'bar',
                data: {
                  labels: label,
                  datasets: [{
                    label: "ICU",
                    type: "line",
                    borderColor: "#ff7f0e",
                    data: datas,
                    fill: false
                  }, {
                    label: "Hospitalized ",
                    type: "line",
                    borderColor: "#bcbd22",
                    data: hospital_datas,
                    fill: false
                  }, {
                    label: "Not Hospitalized ",
                    type: "line",
                    borderColor: "#17becf",
                    data: notHospital_datas,
                    fill: false
                  }],
                },
                options: {
                  title: {
                    display: true,
                    text: 'COVID- Stages of Medication'
                  },
                  legend: {
                    display: true
                  },
                  scales: {
                    xAxes: [{
                      scaleLabel: {
                        display: true,
                        labelString: "Weeks of the year 2020",
                        fontColor: "black"
                      }
                    }],
                    yAxes: [{
                  //    gridLines: {
                  //      color: "#808080",
                  //      borderDash: [1, 8],
                  //    },
                      scaleLabel: {
                        display: true,
                        labelString: "No: of Cases",
                        fontColor: "black"
                      }
                    }]
                  }
                }
              }
              hospitalChart = new Chart(ctx, config);
            }
          </script>
        </div>
      </div>
      <div class="col-sm-4">

        <div id="" class="img-responsive" style="width:100% height=100%" alt="Image">
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
          <canvas id="bar-chart-horizontal" width="800" height="450"></canvas>
          <script>
            $(document).ready(function() {
              $.ajax({
                type: "GET",
                url: "/RestAPI/GetOccupation.php?regionid=1",
                datatype: "json",
                success: function(response) {
                  isdefined = false
                  loadOccupation($.parseJSON(response))
                }
              });
            })

            function pushOccupationData(region_id) {
              $.ajax({
                type: "GET",
                url: "/RestAPI/GetOccupation.php?regionid=" + region_id,
                datatype: "json",
                success: function(response) {
                  isdefined = false
                  pushOccupationDataToGraph($.parseJSON(response))
                }
              });
            }

            function pushOccupationDataToGraph(response) {
              chartOccupation.destroy()
              loadOccupation(response)
            }

            function loadOccupation(responseData) {
              dataOccupation = []
              dataOccupation.push(responseData.healthcare_count)
              dataOccupation.push(responseData.schoolworker_count)
              dataOccupation.push(responseData.care_count)
              dataOccupation.push(responseData.other_count)
              var ctx = document.getElementById("bar-chart-horizontal")
              var config = {
                type: 'horizontalBar',
                data: {
                  labels: ["Health care worker", "School/daycare worker", "Longterm care resident", "Other"],
                  datasets: [{
                    label: "Occupation",
                    backgroundColor: ["#74c476", "#74c476", "#74c476", "#74c476", "#74c476"],
                    data: dataOccupation
                  }]
                },
                options: {
                  legend: {
                    display: false
                  },
                  title: {
                    display: true,
                    text: 'COVIDSpread - Occupation of Patients '
                  },
                  scales: {
                    xAxes: [{
                  //    gridLines: {
                  //      color: "#808080",
                  //      borderDash: [1, 8],
                  //    },
                      scaleLabel: {
                        display: true,
                        labelString: "No: of Cases",
                        fontColor: "black"
                      }
                    }]
                  }
                }
              }
              chartOccupation = new Chart(ctx, config)
            }
          </script>
        </div>
      </div>
    </div>

  </div>
</body>

</html>
