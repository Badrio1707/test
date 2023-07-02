<?php include_once '../App/Views/Partials/header.php';?>

<input type="hidden" id="token" value="<?php echo htmlspecialchars($token);?>">
<div id="wrapper">
    <?php include_once '../App/Views/Partials/sidebar.php';?>
    <div id="content-wrapper" class="d-flex flex-column bg-darkest">
        <div id="content">
            <?php include_once '../App/Views/Partials/navbar.php';?>
            <div class="container">
                <div class="data mb-4 ml-1 mr-1">
                    
                </div>
            </div>
        </div>
    </div>
</div>
     
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php include_once '../App/Views/Partials/footer.php';?>