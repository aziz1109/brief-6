<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    

    <title>Document</title>
</head>
<body>
    <?php
        include("index.php");  
    $sql = "CREATE TABLE if not exists distributeurs(
     id INT(10)   AUTO_INCREMENT PRIMARY KEY,
     longtitude VARCHAR(255) NOT NULL,
     latitude VARCHAR(255) NOT NULL,
     adresse VARCHAR(255) NOT NULL,
     agencyId INT  UNSIGNED,
     FOREIGN KEY (agencyId) REFERENCES agency(id)
        ON DELETE CASCADE ON UPDATE CASCADE 
    )";
    if ($conn->query($sql) === TRUE) {  
        //   echo "Table account created successfully";
        } else {
          echo "Error creating table: " . $conn->error;
        }
        if (isset($_POST["submit"])){ 
        $longtitude = isset($_POST['longtitude']) ? htmlspecialchars(strtolower(trim($_POST['longtitude']))) : '';
        $latitude = isset($_POST['latitude']) ? htmlspecialchars(strtolower(trim($_POST['latitude']))) : '';
        $agencyId = isset($_POST['agencyId']) ? htmlspecialchars(strtolower(trim($_POST['agencyId']))) : '';
        $adresse = isset($_POST['adresse']) ? htmlspecialchars(strtolower(trim($_POST['adresse']))) : '';

        if ($longtitude && $latitude && $agencyId && $adresse ) {
            $insertsql = "INSERT INTO distributeurs(longtitude,latitude,agencyId,adresse)
                        VALUES('$longtitude','$latitude','  $agencyId','$adresse')"; 
            mysqli_query($conn, $insertsql);
            // echo "Valid";    
        } else {
            echo "Veuillez saisir tous les champs" . $conn->error;
        }
    }
    ?>
    <?php
    include("navbar.php");
    ?>
    <div class="absolute flex flex-col justify-center top-0 ml-96 ">
    <button class="absolute top-9 bg-sky-950 px-5 py-2 rounded-lg text-white drop-shadow-lg	" id="button" type="submit">Ajouter un compte</button>

    <table class="w-[800px]" >
           <thead>
            <tr>
                    <td>ID</td>  
                    <td>LONGTITUDE</td>
                    <td>LATITUDE</td>
                    <td>ADRESSE</td>
                    <td>AGENCE ID</td>
                    <td>ACTION</td>
                    

                </tr>
            </thead> 
            <tbody>
                <?php
         if(!$conn){
            die("connection is not connected : " .mysqli_connection_error());
          }
              $sql = "SELECT * FROM distributeurs";
              $result = mysqli_query($conn, $sql);
          
              if($result) {
                while($row = mysqli_fetch_array($result)){
                  echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['longtitude']}</td>
                                <td>{$row['latitude']}</td>
                                <td>{$row['adresse']}</td>
                                <td>{$row['agencyId']}</td>
                                
                               
                                <td>
                                    <a href='{$row["id"]}' class='font-bold text-white h-8 rounded cursor-pointer px-3 bg-gray-700 shadow-md transition ease-out duration-500 border-gray-700 '>EDIT</a>
                                    <a href='deletedistr.php?id={$row["id"]}' class='font-bold text-white h-8 rounded  cursor-pointer px-2 bg-red-700 shadow-md transition ease-out duration-500 border-red-700 '>DELET</a>
                                </td>
          
                        </tr>";
                  
                  
                }
                echo "</tbody></table>";
                    } else {
                        echo "Erreur lors de l'exécution de la requête : " . mysqli_error($cnx);
                    }
              
          ?>
          
        
        <div id="ajouter" class="w-84 h-96 items-center flex gap-[20px] rounded-lg ml-72 mt-10 flex-col justify-center text-center bg-black transform scale-0 duration-500 ease-in-out ">
             <form action="distributeurs.php" method="POST" class="flex flex-col gap-2 ">

           
                <img class="absolute top-3 right-9" src="icons8-effacer-30.png" id="hide">
                
                
                <label for="id"></label>
                <input class="px-5 py-2 rounded text-gray-300 bg-gray-700" type="text" name="agencyId" placeholder="AGENCE ID">
                
                <label for="devis"></label>
                <input class="px-5 py-2 rounded text-gray-300 bg-gray-700 " type="text" name="longtitude" placeholder="LONGTITUDE">
                
                <label for="nom"></label>
                <input class="px-5 py-2 rounded text-gray-300 bg-gray-700" type="text" name="latitude" placeholder="LATITUDE">
                
                <label for="nom"></label>
                <input class="px-5 py-2 rounded text-gray-300 bg-gray-700" type="text" name="adresse" placeholder="ADRESSE">
                <div>
                 <button class="px-8 py-2 rounded text-white bg-orange-700 " type="submit" name="submit" >Ajouter</button>
                 </div>
            </form>
    </div>

    </div>
    <script src="script.js"></script>
</body>
</html>