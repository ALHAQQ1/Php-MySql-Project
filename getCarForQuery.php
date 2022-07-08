<?php


$listOfWhereCommand = [];
if (isset($Make) && $Make != "All")
    $listOfWhereCommand[] = "Make = :Make";
if (isset($Model) && $Model != "All")
    $listOfWhereCommand[] = "Model = :Model";
if (isset($Color) && $Color != "All")
    $listOfWhereCommand[] = "Color = :Color";
if (isset($CarType) && $CarType != "All")
    $listOfWhereCommand[] = "CarType = :CarType";
if (isset($EngineSize) && $EngineSize != "All")
    $listOfWhereCommand[] = "Engine = :Engine";
if (isset($Power) && $Power != "All")
    $listOfWhereCommand[] = "EnginePower = :Power";
if (isset($Fuel) && $Fuel != "All")
    $listOfWhereCommand[] = "Fuel = :Fuel";
if (isset($Gearbox) && $Gearbox != "All")
    $listOfWhereCommand[] = "Gearbox = :Gearbox";
if (isset($Color) && $Color != "All") $listOfWhereCommand[] = "Color = :Color";

if (count($listOfWhereCommand) > 0) $sql .= " WHERE " . implode(" AND ", $listOfWhereCommand);


?>
