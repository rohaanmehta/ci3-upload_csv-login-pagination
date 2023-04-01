<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('header.php') ?>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    </link>
    <style>
        .page_Btn{
            padding:5px 10px 5px 10px;
            border-radius: 5px;
            margin-right: 5px;
            background-color: #0000;
            color: #d1d1d1;
        }
        .page_Btn_Active{
            padding:5px 10px 5px 10px;
            border-radius: 5px;
            margin-right: 5px;
            background-color: #d1d1d1;
            color: #000;
            margin-top: 6px;
        }
        a{
            color: #000;
        }
        a:active{
            color: #000;
        }
        a:hover{
            color: #000;
        }
    </style>
</head>
<body class="bg-default">
    <div class="col-lg-10" style='margin:auto'><br><br>
        <div class='table-responsive table-bordered' style='padding:20px;'>
        <div class="input-group mb-3 col-lg-4 pl-0">
            <input type="text" class="form-control search_info" placeholder="Search">
            <div class="input-group-append">
                <button class='btn btn-info mr-3' id='search'>Search</button>
            </div>
            <a href='<?= base_url('details');?>' class='btn btn-primary'>Reset</a>
        </div>
            <table id="myTable" class="table">
                <thead>
                    <tr>
                        <th>AWBNo</th>
                        <th>BookingDate</th>
                        <th>ForwardinNo</th>
                        <th>Origin</th>
			            <th>Destination</th>
                        <th>ConsigneeName</th>
                        <th>CustomerName</th>
                        <th>ShipperName</th>
                        <th>VendorCode</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $row){ ?>
                        <tr>
                            <td><?= $row['AWBNo']?></td>
                            <td><?= $row['BookingDate']?></td>
                            <td><?= $row['ForwardinNo']?></td>
                            <td><?= $row['Origin']?></td>
			                <td><?= $row['Destination']?></td>
                            <td><?= $row['ConsigneeName']?></td>
                            <td><?= $row['CustomerName']?></td>
                            <td><?= $row['ShipperName']?></td>
                            <td><?= $row['VendorCode']?></td>
                            <td><a id='<?= $row['id']?>' class='btn btn-danger delete' style='color:#fff'><i class='fa fa-trash'></i></a></td>
                        </tr>
                        <?php } ?>
                </tbody>
            </table>
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // $('#myTable').DataTable();
            $('.delete').click(function(){
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('delete_awb')?>",
                    data:  {id:this.id} ,
                    // contentType: false,
                    cache: false,
                    // processData: false,
                    dataType: "json",
                    success: function(data){
                        if(data == 200){
                            Toastify({
                                text: "Record Deleted !",
                                style: {
                                    background: 'green',
                                },
                                duration: 2000
                            }).showToast();
                            setTimeout(function(){
                                window.location.reload();
                            },2000);
                        }
                    }
                });
            });

            $('#search').click(function(){
                var search = $('.search_info').val();
                window.location = '<?= base_url('details?search=')?>'+search;
            });
        });
    </script>
</body>

</html>