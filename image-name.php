<?php

function uploadImage($image)
{
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    if(!($extension == '')) {
        $filename = uniqid() . "." . $extension;
        move_uploaded_file($image['tmp_name'], "uploads/" . $filename);
    } else {
        $filename = "noimage.jpg";
    }
    return $filename;
}