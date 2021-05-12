<!DOCTYPE html>

<?php
require 'lib/nusoap.php';
 $client = new nusoap_client("http://localhost/SystemIntegrationProject/Service.php?wsdl");



?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Integration Web Application</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
    <link href="https://fonts.googleapis.com/css?family=Maven+Pro:900|Overpass" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row card">
                <div class="col-12 mt-3">
                    <h2 class="pl-5 mb-0">
                        System Integration Web Application - Client
                    </h2>

                    <table class='table table-responsive table-borderless'>
                        <thead class='thead-dark'>
                        <tr>
                            <th><div style='width: 100px'>Nazwa producenta</div></th>
                            <th><div style='width: 70px'>Przekatna ekranu</div></th>
                            <th><div style='width: 100px'>Rozdzielczosc ekranu</div></th>
                            <th><div style='width: 120px'>Rodzaj powierzechni ekranu</div></th>
                            <th><div style='width: 70px'>Ekran dotykowy</div></th>
                            <th><div style='width: 80px'>Nazwa procesora</div></th>
                            <th><div style='width: 80px'>Liczba rdzeni fizycznych</div></th>
                            <th><div style='width: 130px'>Predkosc taktowania MHz</th>
                            <th><div style='width: 80px'>Wielkosc pamieci RAM</div></th>
                            <th><div style='width: 80px'>Pojemnosc dysku</div></th>
                            <th><div style='width: 80px'>Rodzaj dysku</div></th>
                            <th><div style='width: 170px'>Nazwa ukladu graficznego</div></th>
                            <th><div style='width: 100px'>Pamiec ukladu graficznego</div></th>
                            <th><div style='width: 170px'>Nazwa systemu operacyjnego</div></th>
                            <th><div >Rodzaj napedu fizycznego</div></th>
                        </tr>
                        </thead>

                        <tbody style='font-size: 12px; border: none'>

                        <form method='post' action="">

                            <!-- Liczba laptopów o danego producenta-->
                            <select class="btn border m-2 mt-2" name = 'manufacturer' >
                                <option value=" ">Wybierz producenta</option>

                                <?php
                                $response = $client->call('getLaptopByManufacturers',array());
                                $manufacturers = explode(';', $response);
                                foreach ($manufacturers as $manufacturer){
                                    if ($_POST['manufacturer'] == $manufacturer){
                                        $option = ' selected ';

                                    }
                                    else $option = '';
                                    echo ' <option value="'.$manufacturer.'" '.$option.'>'.$manufacturer.'</option>';
                                }
                                ?>
                            </select>

                            <input class="btn btn-dark m-2 mt-2" type="submit" name="submit" value="Liczba laptopów producenta">


                            <?php
                            $response = 0;
                            if (isset($_POST['manufacturer'])){
                                $manufacturer = $_POST['manufacturer'];

                                $response = $client->call('getQuantityOfLaptopsByManufacturer',
                                    array("manufacturer"=>$manufacturer));

                            }
                            echo '<input class="btn border m-2 mt-2 mr-5" style="width: 60px" value="'.$response.'">';
                            ?>

                            <!-- Liczba laptopów o danej proporcji ekranu-->
                            <select class="ml-5 btn border m-2 mt-2" name = 'proportion' >
                                <option value="">Wybierz proporcje ekranu</option>
                                <?php
                                $response = $client->call('getLaptopsScreenProportion',array());
                                $proportions = explode(';', $response);
                                foreach ($proportions as $proportion){
                                    if ($_POST['proportion'] == $proportion){
                                        $option = ' selected ';

                                    }
                                    else $option = '';
                                    echo ' <option value="'.$proportion.'" '.$option.'>'.$proportion.'</option>';
                                }
                                ?>
                            </select>

                            <input class="btn btn-dark m-2 mt-2" type="submit" name="submit" value="Liczba laptopów">

                            <?php
                            $response = 0;
                            if (isset($_POST['proportion'])){
                                $proportion = $_POST['proportion'];

                                $response = $client->call('getLaptopsByScreenProportion',
                                    array("proportion"=>$proportion));

                            }
                            echo '<input class="btn border m-2 mt-2 mr-5" style="width: 60px" value="'.$response.'">';
                            ?>


                            <!-- Pobieranie danych o laptopach o danym typie ekranu-->
                            <select class=" ml-5 btn border m-2 mt-2" name = 'screen_type' >
                                <option value="">Wybierz typ ekranu</option>

                                <?php
                                $response = $client->call('getLaptopsScreenType',array());
                                $screenTypes = explode(';', $response);
                                foreach ($screenTypes as $screenType){
                                    if ($_POST['screen_type'] == $screenType){
                                        $option = ' selected ';

                                    }
                                    else $option = '';
                                    echo ' <option value="'.$screenType.'" '.$option.'>'.$screenType.'</option>';
                                }
                                ?>
                            </select>

                            <input class="btn btn-dark m-2 mt-2" type="submit" name="submit" value="Lista laptopów">
                            <?php
                            $i=0;
                            $response = 0;
                            if (isset($_POST['screen_type'])) {
                                $data[] = array();
                                if ($_POST['screen_type'] == "błyszcząca") $screenType = 'blyszczaca';
                                else $screenType = $_POST['screen_type'];


                                $response = $client->call('getLaptopsByScreenType',
                                    array("screenType" => $screenType));

                                $str = json_decode($response, true);
                                foreach ($str as $row){
                                    $data[$i] = json_decode($row, true);
                                    $i++;
                                }
                            }
                            for ($j=0; $j<$i; $j++){
                                if ($data[$j]['screen_type'] == 'blyszczaca') $data[$j]['screen_type'] = "błyszcząca";

                                    ?>
                                <tr id="row">
                                    <td><?php if ($data[$j]['manufacturer']){ echo $data[$j]['manufacturer'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['screen_size']){ echo $data[$j]['screen_size'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['screen_resolution']){ echo $data[$j]['screen_resolution'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['screen_type']){ echo $data[$j]['screen_type'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['screen_touch']){ echo $data[$j]['screen_touch'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['processor_name']){ echo $data[$j]['processor_name'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['processor_physical_cores']){ echo $data[$j]['processor_physical_cores'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['processor_clock_speed']){ echo $data[$j]['processor_clock_speed'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['ram']){ echo $data[$j]['ram'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['disc_type']){ echo $data[$j]['disc_type'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['disc_storage']){ echo $data[$j]['disc_storage'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['graphic_card_name']){ echo $data[$j]['graphic_card_name'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['graphic_card_memory']){ echo $data[$j]['graphic_card_memory'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['os']){ echo $data[$j]['os'];} else echo 'brak danych' ?></td>
                                    <td><?php if ($data[$j]['disc_reader']){ echo $data[$j]['disc_reader'];} else echo 'brak danych' ?></td>
                                </tr>
                            <?php } ?>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>