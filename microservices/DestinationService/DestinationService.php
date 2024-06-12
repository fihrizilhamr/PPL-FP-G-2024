<?php
class DestinationService {

public function createDestination(Destination $destination) {
    $destination->save();
}

public function getDestinationById($id) {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT * FROM destinations WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $destination = new Destination(
            $row['id'],
            $row['name'],
            $row['description'],
            $row['picture'],
            $row['address'],
        );
        return $destination;
    }

    return null;
}

public function getAllDestinations() {
    $destinations = [];
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT * FROM destinations");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $destination = new Destination(
            $row['id'],
            $row['name'],
            $row['description'],
            $row['picture'],
            $row['address'],
        );

        $destinations[] = $destination;
    }

    return $destinations;
}

public function updateDestination(Destination $destination) {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("UPDATE destinations SET name = ?, description = ?, picture = ?, address = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $destination->getName(), $destination->getDescription(), $destination->getPicture(), $destination->getAddress(), $destination->getId());
    $stmt->execute();
}

public function deleteDestination(Destination $destination) {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("DELETE FROM destinations WHERE id = ?");
    $stmt->bind_param("i", $destination->getId());
    $stmt->execute();
}

}
?>