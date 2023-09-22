<?php

require '../Actividad/db/db.php';
session_start();
$query = "SELECT * FROM medicamentos";
$ejecutar = $conn->prepare($query);
$ejecutar->execute();
$data = $ejecutar->fetchAll(PDO::FETCH_OBJ);

if(isset($_GET["code"])){
    $code=$_GET["code"];
    $queryUpdate = "SELECT * FROM medicamentos where code=$code";
    $ejecutarUpdate = $conn->prepare($queryUpdate);
    $ejecutarUpdate->execute();
    $dataUpdate = $ejecutarUpdate->fetchAll(PDO::FETCH_OBJ);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Document</title>
</head>

<style>
    .img {
        width: 50px;
        height: 50px;
        transition: transform 0.3s ease;
    }

    .img:hover {
        transform: scale(1.3);
    }
</style>

<body>

    <div class="container-sm mt-4">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-plus"></i> Agregar medicamentos
            </button>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?php if(!isset($_GET["code"])){ ?>
                    <form action="archivo.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" name="nombre" placeholder="Ingrese el nombre">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="existencia" placeholder="Ingrese la existencia">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <input type="text" name="precio" placeholder="Ingrese el precio">
                                    </div>
                                    <div class="col-6">
                                        <input type="file" name="foto" id="foto">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" value="Agregar">
                        </div>
                    </form>
                    <?php } ?>

                    <?php if(isset($_GET["code"])){ foreach($dataUpdate as $medicamento){ ?>
                    <form action="modificar.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="hidden" name="code" value="<?=$medicamento->code?>">
                                        <input type="text" name="nombre" value="<?=$medicamento->nombre?>">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="existencia" value="<?=$medicamento->existencia?>">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <input type="text" name="precio" value="<?=$medicamento->precio?>">
                                    </div>
                                    <div class="col-6">
                                        <input type="file" name="foto" id="foto" >
                                        <input type="hidden" name="imagen" value="<?=$medicamento->imagenes?>">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" value="Actualizar">
                        </div>
                    </form>
                    <?php } } ?>

                </div>
            </div>
        </div>
    </div>



    <div class="container-sm mt-4">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Medicamentos</h3>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Existencia</th>
                                <th>Precio</th>
                                <th>Fecha Registro</th>
                                <th>Imagen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data as $imagen) {
                            ?>
                                <tr>
                                    <td><?= $imagen->nombre ?></td>
                                    <td><?= $imagen->existencia ?></td>
                                    <td><?= $imagen->precio ?></td>
                                    <td><?= $imagen->fecharegistro ?></td>
                                    <td><img class="img" src="img/<?= $imagen->imagenes ?>" alt=""></td>
                                    <td>
                                        <a href="index.php?code=<?=$imagen->code?>">Editar</a>
                                        <a href="eliminar.php?code=<?=$imagen->code?>">Eliminar</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php

    if (isset($_SESSION['producto_agregado']) && $_SESSION['producto_agregado']) {
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Producto agregado con éxito",
                showConfirmButton: true,  
                confirmButtonText: "OK",  
            });
        </script>';


        $_SESSION['producto_agregado'] = false;
    }
    if (isset($_SESSION['editar']) && $_SESSION['editar']) {
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Producto actualizado con éxito",
                showConfirmButton: true,  
                confirmButtonText: "OK",  
            });
        </script>';


        $_SESSION['editar'] = false;
    }
    if (isset($_SESSION['eliminar']) && $_SESSION['eliminar']) {
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Producto eliminado con éxito",
                showConfirmButton: true,  
                confirmButtonText: "OK",  
            });
        </script>';


        $_SESSION['eliminar'] = false;
    }
    ?>

</body>

</html>