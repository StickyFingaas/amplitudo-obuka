<?php

    require './file_functions.php'; // throws an error
    require './users_functions.php';
    require './form_functions.php';
    require './auth_functions.php';

    checkAuth();

    // $countries = getUsersFromFile("countries.txt");
    // for ($i=0; $i < count($countries); $i++) {
    //     echo $countries[$i]["name"];
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedmica 6</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="./style.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
</head>
<body>

    <!-- HTTP, GET (query string)/POST -->

    <div class="container pt-5">
      <div class="row">
        <div class="col-10 offset-1">

            <?php
                if(isset($_GET['user_saved']) && $_GET['user_saved'] == 1)
                    showAlertDiv("Uspješno dodavanje korisnika!", "alert-success");
                if(isset($_GET['user_deleted']) && $_GET['user_deleted'] == 1)
                    showAlertDiv("Uspješno brisanje korisnika!", "alert-success");
                if(isset($_GET['user_updated']) && $_GET['user_updated'] == 1)
                    showAlertDiv("Uspješna izmjena korisnika!", "alert-success");
                if(isset($_GET['logged_in']) && $_GET['logged_in'] == 1)
                    showAlertDiv("Dobrodošli!", "alert-success");
            ?>

            <div class="row mb-3">
                <div class="col-12 text-end">
                    <form action="./index.php" method="GET">
                        <div class="row">
                            <div class="col-3 text-start">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#newUserModal" class="btn btn-primary w-100">Dodaj novog korisnika</a>
                            </div>
                            <div class="col-3 offset-6">
                                <input type="text" placeholder="Pretraga..." name="term" class="form-control" id="searchTermInput" value="<?=isset($_GET['term']) ? $_GET['term'] : ''?>" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>E-mail</th>
                        <th>Lokacija</th>
                        <th>Izmjena</th>
                        <th>Brisanje</th>
                        <th>Dodavanje lokacije</th>

                    </tr>
                </thead>
                <tbody>
                    <?php

                       $users = getUsersFromFile();
                       if(isset($_GET['term'])){
                           $users = filterUsers($users, strtolower($_GET['term']));
                       }

                       for($i = 0; $i < count($users); $i++){
                           echo "<tr>";
                           echo "   <td>".$users[$i]['id']."</td>";
                           echo "   <td>".$users[$i]['first_name']."</td>";
                           echo "   <td>".$users[$i]['last_name']."</td>";
                           echo "   <td>".$users[$i]['email']."</td>";

                           if(isset($users[$i]['country']) && isset($users[$i]['city'])){
                            echo "   <td>". $users[$i]['country'] . ", " . $users[$i]['city'] . "</td>";
                           }else{
                               echo "<td><p>ne postoji</p></td>";
                           }

                           echo "   <td> <a class=\"btn btn-primary\" href=\"#\" onclick=\"showEditModal(".$users[$i]['id'].")\" >i</a> </td>";
                           echo "   <td> <a class=\"btn btn-danger\" href=\"#\" onclick=\"confirmDelete(".$users[$i]['id'].")\" >X</a> </td>";
                           echo "   <td> <a class=\"btn btn-info\" href=\"#\" onclick=\"addCountryCity(".$users[$i]['id'].")\" >+</a> </td>";
                           echo "</tr> \n ";
                       }

                    ?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-12 text-end">
                    <!-- php echo shorthand -->
                    Ukupno redova: <?=count($users)?>
                </div>
            </div>

        </div>
      </div>

    </div>

    <?php include("./modals/confirm_delete_modal.php"); ?>
    <?php include("./modals/new_user_modal.php"); ?>
    <?php include("./modals/edit_user_modal.php"); ?>
    <?php include("./modals/country_city_modal.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
    <script>

        function confirmDelete(id){
            var confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {});
            document.getElementById("deleteUserIdSpan").innerHTML = id;
            document.getElementById("deleteButton").href = 'delete_user.php?id='+id;
            confirmModal.show();
        }

        async function showEditModal(id){
            var editModal = new bootstrap.Modal(document.getElementById('editUserModal'), {});

            let userId = document.getElementById("user_id")
            userId.value = id

            let response = await fetch("http://localhost/domaci-3/api/user.php?id="+id);
            let responseJSON = await response.json();
            if(responseJSON.status == true){
                let userData = responseJSON.data;
                document.getElementById("editModalFirstName").value = userData.first_name;
                document.getElementById("editModalLastName").value = userData.last_name;
                document.getElementById("editModalEmail").value = userData.email;
            }
            editModal.show();
        }

       async function addCountryCity(id){
            let response = await fetch("http://localhost/domaci-3/api/countries.php");
            let responseJSON = await response.json();
            let countryCityModal = new bootstrap.Modal(document.getElementById('countryCityModal'), {});
            let countrySelector = document.getElementById("country_select")

            let userId = document.getElementById("user_id")
            userId.value = id

            let citiesMenu = document.getElementById("city_select")
            citiesMenu.innerHTML = ""

            let html = "<option selected>Izaberite...</option>"
            responseJSON.data.forEach((country) => {
                html += `<option id="country_${country.id}" value="${country.name}">${country.name}</option>`

            })
            countrySelector.innerHTML = html;

            countryCityModal.show()
        }

    </script>

</body>
</html>