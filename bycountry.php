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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap CSS -->

    <title>Tugas Covid</title>
</head>

<body>

    <!-- Navigation bar -->

    <div class="container-fluid">
        <div class="row">
            <div class="col p-0">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="index.php">Covid-19</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="bycountry.html">by Country</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <!-- Option Country -->

    <div class="container">
        <div class="row" id="view">

            <!-- Loop Data from response -->

            <?php foreach (json_decode($response, true)['Countries'] as $key) : ?>
                <div class="col-lg-3">
                    <div class="card my-2">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $key['Country']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $key['CountryCode']; ?></h6>
                            <button type="button" class="btn rounded-0 my-2 btn-info w-100">
                                New Confirmed<span class="badge badge-light ml-2"><?php echo $key['NewConfirmed']; ?></span>
                            </button>
                            <button type="button" class="btn rounded-0 my-2  btn-info w-100">
                                Total Confirmed<span class="badge badge-light ml-2"><?php echo $key['TotalConfirmed']; ?></span>
                            </button>
                            <button type="button" class="btn rounded-0 my-2  btn-danger w-100">
                                New Death<span class="badge badge-light ml-2"><?php echo $key['NewDeaths']; ?></span>
                            </button>
                            <button type="button" class="btn rounded-0 my-2  btn-danger w-100">
                                Total Death<span class="badge badge-light ml-2"><?php echo $key['TotalDeaths']; ?></span>
                            </button>
                            <button type="button" class="btn rounded-0 my-2  btn-primary w-100">
                                New Recoved<span class="badge badge-light ml-2"><?php echo $key['NewRecovered']; ?></span>
                            </button>
                            <button type="button" class="btn rounded-0 my-2  btn-primary w-100">
                                Total Recovered<span class="badge badge-light ml-2"><?php echo $key['TotalRecovered']; ?></span>
                            </button>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </div>

    <!-- Footer -->

    <div class="container-fluid bg-light p-3 mt-3">
        <div class="row">
            <div class="col text-center" id="last_update">
                Last Update : <?php date_default_timezone_set('Asia/Jakarta'); echo date('l,d-F-Y H:i:s'); ?>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>



</body>

</html>