<?php

$type = $_POST['type'];

if($type === "District"){
    require("generate_district_certificate.php");
} else {
    require("generate_certificate.php");
}