<?php

require_once __DIR__ . '/lib/RedisConnector/Connection.php';
require_once __DIR__ . '/lib/RedisConnector/Exception.php';
require_once __DIR__ . '/lib/RedisConnector/Client.php';
require_once __DIR__ . '/lib/RedisConnector/CommandBuilder.php';
require_once __DIR__ . '/lib/RedisConnector/Response.php';

file_put_contents("test.log", "");

try {
    $com = new RedisConnector\Client(new RedisConnector\Connection());
    //echo("EXISTS " . $com->exists("foo") . "\n");
    // echo("GET " . $com->get("foo") . "\n");
    // echo("SET " . $com->set("foo2", "bar2") . "\n");
    // echo("GET " . $com->get("foo2") . "\n");1
    // echo("HASHSET " . $com->hashset("klucz", "hash", "1") . "\n");
    $com->listLPush("example_list", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum at condimentum felis. Vestibulum aliquam sodales mi eget sodales. Morbi vel ultricies ipsum. Quisque finibus ullamcorper ex, ac tristique neque ultrices at. Suspendisse pretium vitae magna a vestibulum. Maecenas varius egestas leo at condimentum. Aenean et cursus nisl. Nam imperdiet aliquam neque, et tempor ligula egestas in. Cras viverra nunc lacus, quis iaculis enim placerat ac. Donec commodo nisi eget mauris pretium imperdiet. Integer tincidunt metus rutrum mauris ornare, ac bibendum quam auctor. Aliquam ut magna rutrum, porttitor ex vitae, hendrerit mauris. In congue tincidunt diam in fringilla. In aliquam, ipsum vitae volutpat mollis, mauris ligula pellentesque lacus, in tristique odio elit sit amet orci. Morbi at odio nisl. Nunc lacinia odio id sem condimentum commodo.");
    $com->listLPush("example_list", "Lorem ipsum dolor sit amet, consectetur adipiscing elit.");
    $exampleList = $com->listRange("example_list", 0, -1);
    var_export($exampleList);
    // $element = $com->listRPop("example_list");
    // var_export($element);
}
catch(RedisConnector\Exception $e) {
    var_dump($e->getMessage());
}
