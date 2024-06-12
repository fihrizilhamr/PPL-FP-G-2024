<?php

// Factory Method for creating destinations
class DestinationFactory {
    public static function createDestination($id, $name, $description, $picture, $address) {
        return new Destination($id, $name, $description, $picture, $address);
    }
}

?>