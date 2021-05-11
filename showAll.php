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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Maven+Pro:900|Overpass" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row">
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
                        echo '<input class="btn border  m-2 mt-2 col-1" value="'.$response.'">';
                        ?>




                        <!-- Pobieranie danych o laptopach o danym typie ekranu-->
                        <select class="btn border m-2 mt-2" name = 'screen_type' >
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
                        $response = 0;
                        if (isset($_POST['screen_type'])) {
                            $screenType = $_POST['screen_type'];

                            $response = $client->call('getLaptopsByScreenType',
                                array("screenType" => $screenType));

                            $str = explode('|',$response);
                            $i=0;
                            foreach ($str as $row){
                                $data[$i] = explode(';',$row);
                                $i++;
                            }
                        }
                            for ($j=0; $j<$i; $j++){ ?>
                                <tr id="row">
                                    <?php for ($k=0; $k<15; $k++){ ?>
                                    <td><?php if ($data[$j][$k]){ echo $data[$j][$k];} else echo 'brak danych' ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>



                        <!-- Liczba laptopów o danej proporcji ekranu-->
                        <br/>
                        <select class="btn border m-2 mt-2" name = 'proportion' >
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
                        echo '<input class="btn border  m-2 mt-2 col-1" value="'.$response.'">';
                        ?>
                    </form>
                        </tbody>
                    </table>

            </div>
        </div>
    </div>
</body>
</html>