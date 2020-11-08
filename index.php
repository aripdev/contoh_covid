<?php

/** 
 * Project Covid with extension curl PHP
 * Data from https://api.covid19api.com/summary
 */

/** Process Request data */

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.covid19api.com/summary",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "X-Access-Token: 5cf9dfd5-3449-485e-b5ae-70a60e997864"
    ),
));

$response = curl_exec($curl);

curl_close($curl);

/** Getting response and parsing data from Request */

$country = [];
$confirmed = [];
$death = [];
$recovered = [];

foreach (json_decode($response, true)['Countries'] as $key) {
    array_push($country, $key['Country']);
    array_push($confirmed, $key['TotalConfirmed']);
    array_push($death, $key['TotalDeaths']);
    array_push($recovered, $key['TotalRecovered']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>Tugas Covid</title>
</head>

<body>

    <!-- Navigation bar -->

    <div class="container-fluid">
        <div class="row">
            <div class="col p-0">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="/">Covid-19</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="/bycountry.php">by Country</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-center">Global</h2>

                <div class="container">
                    <div class="row" id="global">

                    <!-- Loop For Global Data -->

                        <?php foreach (json_decode($response, true)['Global'] as $key => $val) : ?>
                            <div class="col-lg-6">
                                <button type="button" class="btn btn-primary p-3 m-2 w-100">
                                    <?php echo $key; ?> <span class="badge badge-light"><?php echo $val; ?></span>
                                </button>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>

            </div>
            <div class="col-lg-6">
                <h2 class="text-center">Confirmed</h2>
                <canvas id="confirmed"></canvas>
            </div>

            <div class="col-lg-6">
                <h2 class="text-center">Deaths</h2>
                <canvas id="death"></canvas>
            </div>

            <div class="col-lg-6">
                <h2 class="text-center">Recovered</h2>
                <canvas id="recover"></canvas>
            </div>
        </div>
    </div>



    <!-- Footer -->

    <div class="container-fluid bg-light p-3 mt-3">
        <div class="row">
            <div class="col text-center" id="last_update">
                Last Update : <?php date_default_timezone_set('Asia/Jakarta'); echo date('l,d-F-Y H:i:s');?>
            </div>
        </div>
    </div>


    <script>
        /** Get All Element Charts */

        var ctx_confirm = document.getElementById('confirmed').getContext('2d');
        var ctx_death = document.getElementById('death').getContext('2d');
        var ctx_recover = document.getElementById('recover').getContext('2d');

        /** Get All Dataset */

        var country = <?php echo json_encode($country); ?>;
        var confirmed = <?php echo json_encode($confirmed); ?>;
        var death = <?php echo json_encode($death); ?>;
        var recovered = <?php echo json_encode($recovered); ?>;

        /**  Make Dynamic Color  */

        var coloR = [];

        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
        };

        for (var i in country) {
            coloR.push(dynamicColors());
        }


        /** Chart Total Confirmed */


        var chart_confirm = new Chart(ctx_confirm, {
            type: 'pie',
            data: {
                labels: country,
                datasets: [{
                    label: '# of Votes',
                    data: confirmed,
                    backgroundColor: coloR,
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: false
                }
            }
        });

        /** Chart Total Deaths */


        var chart_death = new Chart(ctx_death, {
            type: 'pie',
            data: {
                labels: country,
                datasets: [{
                    label: '# of Votes',
                    data: death,
                    backgroundColor: coloR,
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: false
                }
            }
        });


        /** Chart Total Recovered */


        var chart_recover = new Chart(ctx_recover, {
            type: 'pie',
            data: {
                labels: country,
                datasets: [{
                    label: '# of Votes',
                    data: recovered,
                    backgroundColor: coloR,
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: false
                }
            }
        });
    </script>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>



</body>

</html>