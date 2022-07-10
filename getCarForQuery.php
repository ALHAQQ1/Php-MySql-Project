<?php


$listOfWhereCommand = [];
if (isset($Make) && $Make != "All")$listOfWhereCommand[] = "Make = :Make";
if (isset($Model) && $Model != "All")$listOfWhereCommand[] = "Model = :Model";
if (isset($Color) && $Color != "All")$listOfWhereCommand[] = "Color = :Color";
if (isset($CarType) && $CarType != "All")$listOfWhereCommand[] = "CarType = :CarType";
if (isset($EngineSize) && $EngineSize != "All")$listOfWhereCommand[] = "Engine = :Engine";
if (isset($Power) && $Power != "All")$listOfWhereCommand[] = "EnginePower = :Power";
if (isset($Fuel) && $Fuel != "All")$listOfWhereCommand[] = "Fuel = :Fuel";
if (isset($Gearbox) && $Gearbox != "All")$listOfWhereCommand[] = "Gearbox = :Gearbox";
if (isset($Color) && $Color != "All") $listOfWhereCommand[] = "Color = :Color";
if (isset($City) && $City != "All") $listOfWhereCommand[] = "SellerCity = :City";
if(isset($MinPrice) && is_numeric($MinPrice)) $listOfWhereCommand[] = "Price >= :MinPrice";
if(isset($MaxPrice) && is_numeric($MaxPrice)) $listOfWhereCommand[] = "Price <= :MaxPrice";
if(isset($MinYear) && is_numeric($MinYear)) $listOfWhereCommand[] = "Year >= :MinYear";
if(isset($MaxYear) && is_numeric($MaxYear)) $listOfWhereCommand[] = "Year <= :MaxYear";
if(isset($MinMileage) && is_numeric($MinMileage)) $listOfWhereCommand[] = "Milage >= :MinMileage";
if(isset($MaxMileage) && is_numeric($MaxMileage)) $listOfWhereCommand[] = "Milage <= :MaxMileage";


if (count($listOfWhereCommand) > 0) $sql .= " WHERE " . implode(" AND ", $listOfWhereCommand);







?>
