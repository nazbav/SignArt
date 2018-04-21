<?php
declare(strict_types = 1);
/**
 * File: test..php;
 * Author: Joker2620;
 * Date: 21.04.2018;
 * Time: 14:00;
 */
use joker2620\SingArt\SignArt;

include_once '../vendor/autoload.php';

$sign_art = new SignArt();
$sign_art->setDirectory('img');
$image_base = [
    ['0.png', 320, 247, 383, 709, 24],
    ['1.png', 201, 111, 383, 190, 19],
    ['2.png', 409, 177, 396, 508, -10],
    ['3.png', 606, 310, 165, 653, 7],
    ['4.png', 281, 121, 659, 342, 10],
    ['5.png', 386, 202, 261, 562, -9],
    ['6.png', 284, 188, 675, 507, 25],
    ['7.png', 191, 90, 253, 128, -9],
    ['8.png', 328, 75, 209, 325, -1]
];
$sign_art->addImageBase($image_base);
$autosign = $sign_art->generate('FASDFASfads', [0, 34, 56]);