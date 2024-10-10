<?php
$conn = mysqli_connect("localhost","root","","osoby");
$sql = "SELECT * FROM `uczen` WHERE 1";
if (isset($_POST["dodaj"])) {
    $sql = "INSERT INTO `uczen` (`id`, `imie`, `nazwisko`, `wiek`) VALUES (NULL, \"".$_POST["imie"]."\", \"".$_POST["nazwisko"]."\", ".$_POST["wiek"].")";
}
elseif (isset($_POST["usun"])) {
    
    $sql = "DELETE FROM uczen WHERE `uczen`.`id` = ".$_POST["usun"];
}
elseif (isset($_POST["zatwierdz"])) {
    $sql = "UPDATE `uczen` SET `imie` = \"".$_POST["imie"]."\", `nazwisko` = \"".$_POST["nazwisko"]."\", `wiek` = ".$_POST["wiek"]." WHERE `uczen`.`id` = ".$_POST["zatwierdz"];
}
mysqli_query($conn, $sql);

$sql = "SELECT * FROM `uczen` WHERE 1";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        td{
            width: 10%;
        }
        input{
            width: 90%;
        }
    </style>
</head>
<body>
    <form method="post">
    <table>
        <?php 
        if(!isset($_POST["edytuj"])){
            echo "<tr>";
            echo "<td><input type=\"text\" name=\"imie\" id=\"imie\" placeholder=\"imie\"></td>";
            echo "<td><input type=\"text\" name=\"nazwisko\" id=\"nazwisko\" placeholder=\"nazwisko\"></td>";
            echo "<td><input type=\"number\" name=\"wiek\" id=\"wiek\" placeholder=\"wiek\" oninput=\"walidacja()\"></td>";
            echo "<td><button name = \"dodaj\" id = \"dodaj\" disabled>dodaj</button></td>";
            echo "</tr> ";
            echo "<button name = \"zatwierdz\" id=\"zatwierdz\" value =\"0\" disabled hidden>zatwierdz</button>";
        }
        ?>
            <!-- <td><input type="text" name="imie" id="imie" placeholder="imie"></td>
            <td><input type="text" name="nazwisko" id="nazwisko" placeholder="nazwisko"></td>
            <td><input type="number" name="wiek" id="wiek" placeholder="wiek" oninput="walidacja()"></td>
            <td><button name = "dodaj" id = "dodaj" disabled>dodaj</button></td> -->
    <tr> 
        <th>id</th>
        <th>imie</th>
        <th>nazwisko</th>
        <th>wiek</th>
        <th>operacje</th>
    </tr>
    <?php 
       while ($row = mysqli_fetch_array($result)) {
            $id = $row["id"];
            $imie = $row["imie"];
            $nazwisko = $row["nazwisko"];
            $wiek = $row["wiek"];
            echo "<tr>";
            echo "<td>$id</td>";
            if(isset($_POST["edytuj"]) && $_POST["edytuj"] == $id){
                echo "<td><input type=\"text\" name=\"imie\" id=\"imie\" placeholder=\"imie\" value=\"$imie\"></td>";
                echo "<td><input type=\"text\" name=\"nazwisko\" id=\"nazwisko\" placeholder=\"nazwisko\" value=\"$nazwisko\"></td>";
                echo "<td><input type=\"number\" name=\"wiek\" id=\"wiek\" placeholder=\"wiek\" oninput=\"walidacja()\" value=\"$wiek\"></td>";
                echo "<td><button name = \"anuluj\" value =\"$id\">anuluj</button> <button name = \"zatwierdz\" id=\"zatwierdz\" value =\"$id\">zatwierdz</button> <button name = \"dodaj\" id = \"dodaj\" disabled hidden>dodaj</button></td>";
            }
            else{
                echo "<td>$imie</td>";
                echo "<td>$nazwisko</td>";
                echo "<td>$wiek</td>";
                echo "<td><button name = \"usun\" value =\"$id\">usun</button> <button name = \"edytuj\" value =\"$id\">edytuj</button></td>";
            }
            echo "</tr>";
            }
    ?>
    </table>
    <script>
        function walidacja(){
            wiek = document.getElementById("wiek").value;
            zatwierdz = document.getElementById("zatwierdz");
            dodaj = document.getElementById("dodaj");
            if(wiek >= 0 && wiek <=120){
                dodaj.disabled = false;
                zatwierdz.disabled = false;
            }
            else{
                dodaj.disabled = true;
                zatwierdz.disabled = true;

            }
        }
    </script>
    </form>
</body>
</html>