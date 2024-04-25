<?php
session_start();

if (!isset($_SESSION["user_name"])) {
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>GRAPHS
    </title>

    <link rel="stylesheet" href="style.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>

<body>

    <div class="container">

        <div class="chart-container" id="chart-container1">
            <canvas id="MovementGraph"></canvas>
            <select id="movementInterval" onchange="show_MovementGraph(this.value)">
                <option value="day">Day</option>
                <option value="week">Week</option>
                <option value="month">Month</option>
                <option value="year">Year</option>
            </select>
        </div>
        <div class="chart-container" id="chart-container2">
            <canvas id="ToiletGraph"></canvas>
            <select id="toiletInterval" onchange="show_ToiletGraph(this.value)">
                <option value="day">Day</option>
                <option value="week">Week</option>
                <option value="month">Month</option>
                <option value="year">Year</option>
            </select>
        </div>
        <div class="chart-container" id="chart-container3">
            <canvas id="ToiletDurationGraph"></canvas>
            <select id="toiletDurations" onchange="show_Toilet_Durations_Graph(this.value)">
                <option value=10>10</option>
                <option value=25>25</option>
                <option value=50>50</option>
                <option value=100>100</option>
            </select>
        </div>
        <div class="chart-container" id="chart-container4">
            <div id="insertHere">
            </div>
        </div>
    </div>

    <script>

        var data = null;
        $(document).ready(function () {
            // Initially show graphs for day
            window.Tgraph = null;
            window.MGraph = null;
            window.TDGraph = null;
            fetchData();


        });

        async function fetchData() {
            await $.post("data.php", function (response) {
                data = response; // Store the response in the global variable
                console.log(data);
            });

            show_log();
            show_MovementGraph('day');
            show_ToiletGraph('day');
            show_Toilet_Durations_Graph(10);
        }

        function show_MovementGraph(interval) {
            {
                if (window.MGraph !== null) {
                    window.MGraph.destroy();
                }

                if (data) {

                    var movements = [];
                    var device_ids = [];

                    // get current day/month/year
                    decomposed_cur = decompose_timestamp(new Date());

                    for (var i in data) {
                        if (data[i].type_ !== 'movement') { continue };

                        decomposed_data = decompose_timestamp(new Date(data[i].timestamp_));

                        if (interval === 'day' && decomposed_cur.weekNr == decomposed_data.weekNr && decomposed_cur.month == decomposed_data.month && decomposed_cur.year == decomposed_data.year) {
                            updateArray(data[i].device_id, device_ids, movements);
                        } else if (interval === 'week' && decomposed_cur.year == decomposed_data.year) {
                            updateArray(data[i].device_id, device_ids, movements);
                        } else if (interval === 'month' && decomposed_cur.year == decomposed_data.year) {
                            updateArray(data[i].device_id, device_ids, movements);
                        } else if (interval === 'year') {
                            updateArray(data[i].device_id, device_ids, movements);
                        }

                    };

                    var chartdata = {
                        labels: device_ids,
                        datasets: [
                            {
                                label: 'Number of Movements by Room',
                                backgroundColor: '#66CC99', // Cooler green color
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: movements,
                                borderWidth: 1
                            }
                        ]
                    };

                    const ctx = document.getElementById('MovementGraph');

                    window.MGraph = new Chart(ctx, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        },
                    });

                };
            }
        }

        function decompose_timestamp(date) {
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear(); // Use getFullYear() instead of getYear()

            var firstJanuary = new Date(date.getFullYear(), 0, 1);
            var dayNr = Math.ceil((date - firstJanuary) / (24 * 60 * 60 * 1000));
            var weekNr = Math.ceil((dayNr + firstJanuary.getDay()) / 7);

            return { day: day, weekNr: weekNr, month: month, year: year };
        }

        // Helper function to update arrays
        function updateArray(value, array, counterArray) {
            var index = array.indexOf(value);
            if (index === -1) {
                array.push(value);
                counterArray.push(1);
            } else {
                counterArray[index]++;
            }
        }

        function show_ToiletGraph(interval) {
            if (window.Tgraph !== null) {
                window.Tgraph.destroy();
            }
            if (data) {
                // Initialize arrays for storing toilet visits counts
                var toiletvisitsday = [];
                var toiletvisitsweek = [];
                var toiletvisitsmonth = [];
                var toiletvisitsyear = [];

                // Initialize arrays for storing timestamps
                var day = [];
                var week = [];
                var month = [];
                var year = [];

                // Loop through data
                for (var i in data) {
                    // Skip entries that are not related to toilet visits
                    if (data[i].type_ !== "toilet") {
                        continue;
                    }
                    // Decompose timestamp
                    var date = new Date(data[i].timestamp_);
                    var decomposed = decompose_timestamp(date);

                    // Update counts and indices
                    updateArray(decomposed.day, day, toiletvisitsday);
                    updateArray(decomposed.weekNr, week, toiletvisitsweek);
                    updateArray(decomposed.month, month, toiletvisitsmonth);
                    updateArray(decomposed.year, year, toiletvisitsyear);
                }


                // Chart data for daily visits
                var chartdata = {
                    labels: interval === 'day' ? day : interval === 'week' ? week : interval === 'month' ? month : year,
                    datasets: [{
                        axis: 'y',
                        label: 'No. of Toiletvisits',
                        backgroundColor: '#FFFF66',
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#666666',
                        data: interval === 'day' ? toiletvisitsday : interval === 'week' ? toiletvisitsweek : interval === 'month' ? toiletvisitsmonth : toiletvisitsyear,
                    }],
                };

                // Render chart
                var graphTarget = $("#ToiletGraph");
                window.Tgraph = new Chart(graphTarget, {
                    type: 'bubble',
                    data: chartdata,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    },
                });
            };

        }

        /* show latest x toilet visits */
        function show_Toilet_Durations_Graph(interval) {
            {
                if (window.TDGraph !== null) {
                    window.TDGraph.destroy();
                }

                if (data) {
                    var durations = [];
                    var visits = [];


                    var count = 1;
                    for (var i in data) {
                        if (data[i].type_ !== 'ToiletDuration') { continue };
                        if (visits.length >= interval) { break; };

                        if (visits.length < interval) {
                            visits.push(count);
                            durations.push(data[i].measurement / 60);
                            count++;
                        }
                    };

                    console.log(visits);
                    console.log(durations);

                    var chartdata = {
                        labels: visits,
                        datasets: [
                            {
                                label: 'Latest ' + interval + ' Toilet Visit Durations (minutes)',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: durations,
                                borderWidth: 1
                            }
                        ]
                    };

                    const ctx = document.getElementById('ToiletDurationGraph');

                    window.TDGraph = new Chart(ctx, {
                        type: 'line',
                        data: chartdata,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        },
                    });

                };
            }
        }




        function show_log() {
            const div = document.getElementById('insertHere');

            if (data) {

                //console.log(data);
                var dict = {};
                dict["Informational"] = 0;
                dict["warning"] = 0;
                dict["error"] = 0;

                for (var i in data) {
                    if (data[i].loglevel === "Informational") {
                        dict["Informational"] += 1;
                        console.log("here")
                    } else if (data[i].loglevel === "warning") {
                        dict["warning"] += 1;
                    } else if (data[i].loglevel === "error") {
                        dict["error"] += 1;
                    }
                }

                console.log(dict);

                for (let key in dict) {
                    let nr = dict[key];
                    let html = `<p>Title: ${key}, number of logs ${nr}</p>`;
                    div.insertAdjacentHTML('beforeend', html);
                }
            };
        }




    </script>

</body>

</html>