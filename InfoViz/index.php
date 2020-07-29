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
    background-color: #f2f2f2;
    padding: 25px;
  }

  body {
    font: 10px sans-serif;
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
          <p style="font-size:20px"> recovered Cases</p>
          <p id="recoveredcase" style="font-size: 35px;color: blue"></p>
        </div>
      </div>
    </div>

  </div>

  <div class="container-fluid bg-3 text-center">

    <div class="row">
      <div class="col-sm-4">
        <p>Some text..</p>
        <div id="map" class="img-responsive" style="width:100%;height: 50%">
          <svg viewBox="0 0 500 350"></svg>
          <script src="https://unpkg.com/d3@5.9.2/dist/d3.min.js"></script>
          <script src="https://unpkg.com/topojson@3.0.2/dist/topojson.min.js"></script>

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
            d3map.json('http://localhost/RestAPI/DataCountAPI.php').then((region) => {
              d3map.json('canada.json').then((data) => {

                region.forEach(function(d, i) {

                  RegionCount[d.region] += parseInt(d.total_count);
                  ActiveCount[d.region] += parseInt(d.active_count);
                  RecoverCount[d.region] += parseInt(d.recoverd_count);
                });
                color = d3map.scaleOrdinal().domain([d3map.min(RegionCount), d3map.max(RegionCount)])
                  .range(['#fcba03', '#2bd4e0', '#db0d0d', '#27d62c', '#303330'])


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
                      .style('stroke-width', '1')
                      .style("opacity", 1);

                    d3map.selectAll('path')
                      .filter(function(data, i) {
                        if (data != null)
                          if (data.RegionID != d.RegionID) {
                            return data.RegionID;
                          }
                      })
                      .style('stroke-width', '0.1')
                      .style("opacity", 0.9);

                    div.html(
                        "<table>" +
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
                      .style("opacity", .9)

                  })
                  .on('mouseout', function(d) {
                    d3map.selectAll('path')
                      .data(data.features)
                      .style('stroke-width', '0.2')
                      .style("opacity", 1);
                    div.style("opacity", 0);

                  })
                  .on("click", function(clicked_data) {

                    fetchData(clicked_data.RegionID);
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
                }
              });


            }
            //}(d3map, topojson));
          </script>
        </div>
      </div>
      <div class="col-sm-4">
        <p>Some text..</p>
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
              label = responseData["jsonarray"].map(function(d) {
                return d.onsetweekofsym;
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
              var config = {
                type: 'bar',
                data: {
                  labels: label,
                  datasets: [{
                    label: "Onset week of Symptoms",
                    type: "line",
                    borderColor: "#8e5ea2",
                    data: datas,
                    fill: true
                  }, {
                    label: "Death ",
                    type: "line",
                    borderColor: "#3e95cd",
                    data: death_datas,
                    fill: true
                  }]
                },
                options: {
                  title: {
                    display: true,
                    text: 'Corona Virus spread infected and death'
                  },
                  legend: {
                    display: false
                  }
                }
              }
              chart = new Chart(ctx, config);
            }

            function loadData(responseData) {

              label = responseData["jsonarray"].map(function(d) {
                return d.onsetweekofsym;
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
              var config = {
                type: 'bar',
                data: {
                  labels: label,
                  datasets: [{
                    label: "Onset week of Symptoms",
                    type: "line",
                    borderColor: "#8e5ea2",
                    data: datas,
                    fill: true
                  }, {
                    label: "Death ",
                    type: "line",
                    borderColor: "#3e95cd",
                    data: death_datas,
                    fill: true
                  }]
                },
                options: {
                  title: {
                    display: true,
                    text: 'Corona Virus spread infected and death'
                  },
                  legend: {
                    display: false
                  }
                }
              }
              chart = new Chart(ctx, config);
            }
          </script>
        </div>
      </div>

      <div class="col-sm-4">
        <p>Some text..</p>
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
            function pushGenderData(region_id){
              $.ajax({
                type: "GET",
                url: "/RestAPI/GenderData.php?regionid="+region_id,
                datatype: "json",
                success: function(response) {
                  isdefined = false
                  pushGenderDataGraph($.parseJSON(response))

                }
              });
            }
            function pushGenderDataGraph(responseData){
              chartGender.destroy();
              label = responseData["male"].map(function(d) {
                if(d.agegroup==1){
                  return "0-19";
                }else if(d.agegroup==2){
                  return "20-29";
                }else if(d.agegroup==3){
                  return "30-39";
                }else if(d.agegroup==4){
                  return "40-49";
                }else if(d.agegroup==5){
                  return "50-59";
                }else if(d.agegroup==6){
                  return "60-69";
                }else if(d.agegroup==7){
                  return "70-79"
                }else if(d.agegroup==8){
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
                  backgroundColor: "#3e95cd",
                  data: datas
                }, {
                  label: "Female",
                  backgroundColor: "#8e5ea2",
                  data: death_datas
                }]
              },
              options: {
                title: {
                  display: true,
                  text: 'Corona Spread gender & age wise'
                }
              }
            }
            chartGender=new Chart(ctxgender,configgender );
          }

            function loadGenderData(responseData){
              label = responseData["male"].map(function(d) {
                if(d.agegroup==1){
                  return "0-19";
                }else if(d.agegroup==2){
                  return "20-29";
                }else if(d.agegroup==3){
                  return "30-39";
                }else if(d.agegroup==4){
                  return "40-49";
                }else if(d.agegroup==5){
                  return "50-59";
                }else if(d.agegroup==6){
                  return "60-69";
                }else if(d.agegroup==7){
                  return "70-79"
                }else if(d.agegroup==8){
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
                  backgroundColor: "#3e95cd",
                  data: datas
                }, {
                  label: "Female",
                  backgroundColor: "#8e5ea2",
                  data: death_datas
                }]
              },
              options: {
                title: {
                  display: true,
                  text: 'Corona Spread gender & age wise'
                }
              }
            }
            chartGender=new Chart(ctxgender,configgender );
          }
            
          </script>


        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <p>Some text..</p>
        <div id="" class="img-responsive" style="width:100% height=50%" alt="Image">
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
          <canvas id="bar-chart2" height="130"></canvas>
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
            function pushTransData(region_id){
              $.ajax({
                type: "GET",
                url: "/RestAPI/GetTransmissionData.php?regionid="+region_id,
                datatype: "json",
                success: function(response) {
                  isdefined = false
                  pushDataToGraph($.parseJSON(response))
                }
              });
            }
            function pushDataToGraph(responseData){
              transChart.destroy();
              var datas=[];
              dataTransmission1=responseData.transmission_count;
              dataTransmission2=responseData.transmission2_count;
              dataTransmission3=responseData.transmission3_count;
              datas.push(dataTransmission1);
              datas.push(dataTransmission2);
              datas.push(dataTransmission3);
              var ctx=document.getElementById("bar-chart2");
              var config={
              type: 'bar',
              data: {
                labels: ["Domestic","Internation Travel","Unknown"],
                datasets: [{
                  label: "Transmission",
                  backgroundColor: ["#3e95cd", "#8e5ea2","#4a1ea2"],
                  data: datas
                }]
              },
              options: {
                legend: {
                  display: false
                },
                title: {
                  display: true,
                  text: 'Corona Virus Transmission'
                }
              }
            }
            transChart=new Chart(ctx,config)
            }
            function loadTransmissionData(responseData){
              var datas=[];
              dataTransmission1=responseData.transmission_count;
              dataTransmission2=responseData.transmission2_count;
              dataTransmission3=responseData.transmission3_count;
              datas.push(dataTransmission1);
              datas.push(dataTransmission2);
              datas.push(dataTransmission3);
              var ctx=document.getElementById("bar-chart2");
              var config={
              type: 'bar',
              data: {
                labels: ["Domestic","Internation Travel","Unknown"],
                datasets: [{
                  label: "Transmission",
                  backgroundColor: ["#3e95cd", "#8e5ea2","#8e2ea2"],
                  data: datas
                }]
              },
              options: {
                legend: {
                  display: false
                },
                title: {
                  display: true,
                  text: 'Corona Virus Transmission'
                }
              }
            }
            transChart=new Chart(ctx,config)
            }
            
          </script>
        </div>
      </div>
      <div class="col-sm-4">
        <p>Some text..</p>
        <div id="hospital" class="img-responsive" style="width:100% height=100%" alt="Image">
          <script data-require="d3@3.5.3" data-semver="3.5.3" src="//cdnjs.cloudflare.com/ajax/libs/d3/3.5.3/d3.js"></script>
          <script>
            d3hos = d3
            window.d3 = null
            const title = "Atlantic"
            var myData = "date,Hospitalized,ICU,Not Hospitalized\n\
20200217,2,0,42\n\
20200224,35,3,107\n\
20200302,59,57,744\n\
20200309,950,101,1265\n\
20200316,234,93,2110\n\
20200323,292,103,2296\n\
20200330,302,69,3098\n\
20200406,369,72,3999\n\
20200413,373,71,3334\n\
20200420,357,43,3168\n\
20200427,212,43,2533\n\
20200504,220,43,2596\n\
20200511,141,32,2166\n\
20200518,100,18,1723\n\
20200525,33,1,963\n";

            var margin = {
                top: 20,
                right: 100,
                bottom: 30,
                left: 10
              },
              width2 = 510 - margin.left - margin.right,
              height2 = 200 - margin.top - margin.bottom;

            var parseDate = d3hos.time.format("%Y%m%d").parse;


            var x = d3hos.time.scale()
              .range([0, width2]);

            var y = d3hos.scale.linear()
              .range([height2, 0]);

            var color = d3hos.scale.category10();

            var xAxis = d3hos.svg.axis()
              .scale(x)
              .orient("bottom");

            var yAxis = d3hos.svg.axis()
              .scale(y)
              .orient("left");

            var line = d3hos.svg.line()
              .interpolate("basis")
              .x(function(d) {
                return x(d.date);
              })
              .y(function(d) {
                return y(d.count);
              });

            var svg2 = d3hos.select("#hospital").append("svg")
              .attr("width", width2 + margin.left + margin.right)
              .attr("height", height2 + margin.top + margin.bottom)
              .append("g")
              .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            //  var data1=  d3hos.csv("data.csv", function(data) {
            //    for (var i = 0; i < data.length; i++) {
            //        data[i].date= data[i].date.time.format("%Y%m%d").parse;
            //          console.log(data);
            //console.log(data[i].Totalcases);
            //      }
            //      });
            var data2 = d3hos.csv.parse(myData);


            color.domain(d3hos.keys(data2[0]).filter(function(key) {
              return key !== "date";
            }));

            data2.forEach(function(d) {
              d.date = parseDate(d.date);
            });

            var patients = color.domain().map(function(name) {
              return {
                name: name,
                values: data2.map(function(d) {
                  return {
                    date: d.date,
                    count: +d[name]
                  };
                })
              };
            });

            x.domain(d3hos.extent(data2, function(d) {
              return d.date;
            }));

            y.domain([
              d3hos.min(patients, function(c) {
                return d3hos.min(c.values, function(v) {
                  return v.count;
                });
              }),
              d3hos.max(patients, function(c) {
                return d3hos.max(c.values, function(v) {
                  return v.count;
                });
              })
            ]);

            var legend = svg2.selectAll('g')
              .data(patients)
              .enter()
              .append('g')
              //  .html(titleText)
              .attr('class', 'legend');

            legend.append('rect')
              .attr('x', width2 - 20)
              .attr('y', function(d, i) {
                return i * 20;
              })
              .attr('width', 10)
              .attr('height', 10)
              .style('fill', function(d) {
                return color(d.name);
              });

            legend.append('text')
              .attr('x', width2 - 8)
              .attr('y', function(d, i) {
                return (i * 20) + 9;
              })
              .text(function(d) {
                return d.name;
              });

            svg2.append("g")
              .attr("class", "x axis")
              .attr("transform", "translate(0," + height2 + ")")
              .call(xAxis);

            svg2.append("g")
              .attr("class", "y axis")
              .call(yAxis)
              .append("text")
              .attr("transform", "rotate(-90)")
              .attr("y", 6)
              .attr("dy", ".71em")
              .style("text-anchor", "end")
              .text("count");

            var patient = svg2.selectAll(".patient")
              .data(patients)
              .enter().append("g")
              .attr("class", "patient");

            patient.append("path")
              .attr("class", "line")
              .attr("d", function(d) {
                return line(d.values);
              })
              .style("stroke", function(d) {
                return color(d.name);
              });

            patient.append("text")
              .datum(function(d) {
                return {
                  value: d.values[d.values.length - 1]
                };
              })
              .attr("transform", function(d) {
                return "translate(" + x(d.value.date) + "," + y(d.value.count) + ")";
              })
              .attr("x", 3)
              .attr("dy", ".35em")
              .text(function(d) {
                return d.name;
              });

            var mouseG = svg2.append("g")
              .attr("class", "mouse-over-effects");

            mouseG.append("path") // this is the black vertical line to follow mouse
              .attr("class", "mouse-line")
              .style("stroke", "white")
              .style("stroke-width", "1px")
              .style("opacity", "0");

            var lines = document.getElementsByClassName('line');

            var mousePerLine = mouseG.selectAll('.mouse-per-line')
              .data(patients)
              .enter()
              .append("g")
              .attr("class", "mouse-per-line");

            mousePerLine.append("circle")
              .attr("r", 7)
              .style("stroke", function(d) {
                return color(d.name);
              })
              .style("fill", "none")
              .style("stroke-width", "1px")
              .style("opacity", "0");

            mousePerLine.append("text")
              .attr("transform", "translate(10,3)");

            mouseG.append('svg:rect') // append a rect to catch mouse movements on canvas
              .attr('width', width2) // can't catch mouse events on a g element
              .attr('height', height2)
              .attr('fill', 'none')
              .attr('pointer-events', 'all')
              .on('mouseout', function() { // on mouse out hide line, circles and text
                d3hos.select(".mouse-line")
                  .style("opacity", "0");
                d3hos.selectAll(".mouse-per-line circle")
                  .style("opacity", "0");
                d3hos.selectAll(".mouse-per-line text")
                  .style("opacity", "0");
              })
              .on('mouseover', function() { // on mouse in show line, circles and text
                d3hos.select(".mouse-line")
                  .style("opacity", "1");
                d3hos.selectAll(".mouse-per-line circle")
                  .style("opacity", "1");
                d3hos.selectAll(".mouse-per-line text")
                  .style("opacity", "1");
              })
              .on('mousemove', function() { // mouse moving over canvas
                var mouse = d3hos.mouse(this);
                d3hos.select(".mouse-line")
                  .attr("d", function() {
                    var d = "M" + mouse[0] + "," + height2;
                    d += " " + mouse[0] + "," + 0;
                    return d;
                  });

                d3hos.selectAll(".mouse-per-line")
                  .attr("transform", function(d, i) {
                    //  console.log(width/mouse[0])
                    var xDate = x.invert(mouse[0]),
                      bisect = d3hos.bisector(function(d) {
                        return d.date;
                      }).right;
                    idx = bisect(d.values, xDate);
                    //console.log(idx)

                    var beginning = 0,
                      end = lines[i].getTotalLength(),
                      target = null;

                    while (true) {
                      target = Math.floor((beginning + end) / 2);
                      //    console.log(target)
                      pos = lines[i].getPointAtLength(target);
                      if ((target === end || target === beginning) && pos.x !== mouse[0]) {
                        break;
                      }
                      if (pos.x > mouse[0]) end = target;
                      else if (pos.x < mouse[0]) beginning = target;
                      else break; //position found
                    }

                    d3hos.select(this).select('text')
                      .text(y.invert(pos.y).toFixed(0));

                    return "translate(" + mouse[0] + "," + pos.y + ")";
                  });
              });
          </script>

        </div>
      </div>
      <div class="col-sm-4">
        <p>Some text..</p>
        <div id="" class="img-responsive" style="width:100% height=100%" alt="Image">
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
          <canvas id="radar-chart" width="800" height="350"></canvas>
          <script>
            new Chart(document.getElementById("radar-chart"), {
              type: 'radar',
              data: {
                labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
                datasets: [{
                  label: "1950",
                  fill: true,
                  backgroundColor: "rgba(179,181,198,0.2)",
                  borderColor: "rgba(179,181,198,1)",
                  pointBorderColor: "#fff",
                  pointBackgroundColor: "rgba(179,181,198,1)",
                  data: [8.77, 55.61, 21.69, 6.62, 6.82]
                }, {
                  label: "2050",
                  fill: true,
                  backgroundColor: "rgba(255,99,132,0.2)",
                  borderColor: "rgba(255,99,132,1)",
                  pointBorderColor: "#fff",
                  pointBackgroundColor: "rgba(255,99,132,1)",
                  pointBorderColor: "#fff",
                  data: [25.48, 54.16, 7.61, 8.06, 4.45]
                }]
              },
              options: {
                title: {
                  display: true,
                  text: 'Distribution in % of world population'
                }
              }
            });
          </script>
        </div>
      </div>
    </div>

  </div>
</body>

</html>