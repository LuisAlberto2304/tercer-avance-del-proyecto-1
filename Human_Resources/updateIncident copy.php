<?php

include "../includes/headerHR.php";
require_once "../includes/config/MySQL_ConexionDB.php";
require_once "../admin/functionsAdmin.php";
require_once "../functions.php";


if(isset($_POST['btnReport'])){
    $id = trim($_POST['id']);
    $incidentType = traducirTexto(trim($_POST['type']));
    $incidentDate = trim($_POST['dateIncident']);
    $description = traducirTexto(trim($_POST['description']));
    $employee = trim($_POST['employee']);

    if (strlen($incidentType) > 100) {
        echo "<script>
                alert('The description exceeds 100 characters. Please shorten it.');
                window.history.back(); // Regresa al formulario
              </script>";
        exit(); // Detener la ejecución del script
    }
    
    if (strlen($description) > 100) {
        echo "<script>
                alert('The description exceeds 100 characters. Please shorten it.');
                window.history.back(); // Regresa al formulario
              </script>";
        exit(); // Detener la ejecución del script
    }

    try {
        global $db_con;
        
        $incidentDate = (new DateTime())->format('Y-m-d');

        $stmt = $db_con->prepare("update incident SET incidentType = :incidentType, incidentDate = :incidentDate, description = :description where id = :id");
        $stmt->bindParam(':id', $id);

        $stmt->bindParam(':incidentType', $incidentType, PDO::PARAM_STR);
        $stmt->bindParam(':incidentDate', $incidentDate, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<script>
                    alert('The incident has been updated successful.');
                    window.location.href = 'incidents.php';
                  </script>";
        } else {
            echo "Error updating incident.";
        }

    } catch (PDOException $e) {
        echo "Connection error: " . $e->getMessage();
    }


}

?>