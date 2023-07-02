<?php include_once '../App/Views/Partials/header.php';?>

<div id="wrapper">
    <?php include_once '../App/Views/Partials/sidebar.php';?>
    <div id="content-wrapper" class="d-flex flex-column bg-darkest">
        <div id="content">
            <?php include_once '../App/Views/Partials/navbar.php';?>
            <div class="container-fluid">
                <div class="row mb-4 ml-1 mr-1">
                    <h1 class="h3 mb-0 text-gray-600">Logs</h1>
                    <div class="ml-auto">
                        <button class="btn btn-sm btn-danger shadow-sm" onclick="deleteLogs()"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete</button>
                    </div>
                </div>
                <div class="row data">
                    
                </div>
            </div>
        </div>
    </div>
</div>
     
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<?php include_once '../App/Views/Partials/footer.php';?>