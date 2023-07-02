<?php include_once '../App/Views/Partials/header.php';?>

<div id="wrapper">
    <?php include_once '../App/Views/Partials/sidebar.php';?>
    <div id="content-wrapper" class="d-flex flex-column bg-darkest">
        <div id="content">
            <?php include_once '../App/Views/Partials/navbar.php';?>
            <div class="container-fluid">
                <div class="row mb-4 ml-1 mr-1">
                    <h1 class="h3 mb-0 text-gray-600">Requests</h1>
                    <div class="ml-auto">
                        <button class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#requestModal"><i class="fas fa-plus fa-sm text-white-50"></i> Create</button>
                        <button class="btn btn-sm btn-danger shadow-sm" onclick="deleteRequests()"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete</button>
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

<div class="modal" tabindex="-1" role="dialog" id="requestModal">
    <form class="user" method="POST" autocomplete="off" id="request-form">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-darker">
                <div class="modal-header custom-border-bottom">
                    <h5 class="modal-title text-gray-600">Create Request</h5>
                    <button type="button" class="close" data-dismiss="modal" id="request-close" onclick="request_close()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user custom-input"
                            id="name" placeholder="Name"> 
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user custom-input"
                            id="amount" placeholder="Amount" value="0,01">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user custom-input"
                            id="description" placeholder="Description" value="Verification">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user custom-input"
                            id="iban" placeholder="IBAN" value="NL42 INGB 0693 1831 01">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user custom-input"
                            id="url" placeholder="URL" value="<?php echo uniqid();?>">
                            <span class="ml-2 invalid-feedback" id="url-feedback"></span>
                    </div>
                    <div class="form-group mb-0">
                        <select class="form-control custom-input" onchange="changeIban(this.value)" style="border-radius: 25px; padding: 10px; height: 50px; font-size: 14px;" id="mode">
                            <option value="ing" selected>ING</option>
                            <option value="tikkie">Tikkie</option>
                            <option value="bunq">Bunq</option>
                            <option value="mp">Martkplaats</option>
                            <option value="postnl">PostNL</option>
                        </select>
                        <span class="ml-2 invalid-feedback" id="mode-feedback"></span>
                    </div>
                </div>
                <div class="modal-footer custom-border-top">
                    <button type="submit" class="btn btn-danger btn-user"><i class="fas fa-plus"></i> Create</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include_once '../App/Views/Partials/footer.php';?>