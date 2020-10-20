<?php
require (dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'init.php');

try {
    $helper = new TwigHelper();
    $helper->setTemplateParams(array(
        'title' => 'トップページ',
        'copylight' => 'docker-php53-and-twig'
    ));
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}