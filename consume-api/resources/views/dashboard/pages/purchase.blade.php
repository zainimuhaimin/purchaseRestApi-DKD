@extends('dashboard.layout.template')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Table {{ $title }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="p-3">
                                    <a href="/excel" class="badge badge-success">excel</a>
                                    <a href="/pdf" class="badge badge-danger">pdf</a>
                                </div>
                            </div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#exampleModal">
                                New Data
                            </button>
                            <div class="row mt-2 ml-2">
                                <input type="text" id="searchByName" class="form-input" placeholder="search">
                            </div>

                            <div class="table-responsive mt-2">
                                <table class="table table-bordered table-md" id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah Produk</th>
                                            <th>Kategori</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Total Bayar</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="purchase">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Edit Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Input Purchase</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="purchaseForm">
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <select class="custom-select option" name="goods_id" id="productId">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product">Product Name</label>
                            <input id="productName" type="product" class="form-control" placeholder="Enter Product Name"
                                name="goods_name">
                        </div>
                        <div class="form-group">
                            <label for="qty">Qty</label>
                            <input type="qty" class="form-control" placeholder="Enter Qty" name="qty">
                        </div>
                        <div class="form-group">
                            <label for="company">Company</label>
                            <input type="company" id="company" class="form-control" placeholder="Enter Company Name"
                                name="company">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="category" id="category" class="form-control" placeholder="Enter Category"
                                name="category">
                        </div>
                        <div class="form-group">
                            <label for="pay_total">Pay Total</label>
                            <input type="pay_total" class="form-control" placeholder="Enter Pay Total" name="pay_total">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Edit Purchase</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="purchaseFormEdit">
                    <div class="modal-body">
                        <input type="text" name="id" hidden id="purchaseId">
                        <div class="form-group">
                            <label for="product">Product Name</label>
                            <input id="eproductName" type="product" class="form-control"
                                placeholder="Enter Product Name" name="goods_name">
                        </div>
                        <div class="form-group">
                            <label for="qty">Qty</label>
                            <input type="qty" id="eqty" class="form-control" placeholder="Enter Qty"
                                name="qty">
                        </div>
                        <div class="form-group">
                            <label for="company">Company</label>
                            <input type="company" id="ecompany" class="form-control" placeholder="Enter Company Name"
                                name="company">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="category" id="ecategory" class="form-control" placeholder="Enter Category"
                                name="category">
                        </div>
                        <div class="form-group">
                            <label for="pay_total">Pay Total</label>
                            <input type="pay_total" id="epay_total" class="form-control" placeholder="Enter Pay Total"
                                name="pay_total">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#purchaseForm').submit(function(e) {
            e.preventDefault()
            $.ajax({
                type: "post",
                url: "http://127.0.0.1:8000/api/purchase/create",
                headers: {
                    "Authorization": "Bearer {{ Session::get('isToken') }}",
                    "accept": "application/json"
                },
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Berhasil Ditambah',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    window.location.href =
                        "{{ URL::to('/purchase') }}";
                }
            });
        })
        $('#productName').on('keyup', function(e) {
            e.preventDefault()
            $("#productId").prop("disabled", true);
        })
        $('#productId').on('change', function(e) {
            e.preventDefault()
            $("#productName").prop('readonly', true);
            $("#category").prop('readonly', true);
            $("#company").prop('readonly', true);
            let id = $('#productId').val()
            $.ajax({
                type: "post",
                url: "http://127.0.0.1:8000/api/goods/findById",
                data: {
                    id: id
                },
                headers: {
                    "Authorization": "Bearer {{ Session::get('isToken') }}",
                    "accept": "application/json"
                },
                dataType: "json",
                success: function(response) {
                    $.each(response, function(i, v) {
                        console.log(v);
                        $('#productName').val(v.goods_name)
                        $('#company').val(v.company)
                        $('#category').val(v.category)
                    });
                }
            });
        })
        $.ajax({
            type: "get",
            url: "http://127.0.0.1:8000/api/goods/findAll",
            headers: {
                "Authorization": "Bearer {{ Session::get('isToken') }}",
                "accept": "application/json"
            },
            dataType: "json",
            success: function(response) {
                let option = ` <option selected>Choose for update qty of goods...</option>`
                $.each(response, function(i) {
                    $.each(response[i], function(i, v) {
                        option += `<option value="` + v.id + `">` + v.name + `</option>`
                    });
                });
                $('.option').append(option)
            }
        });


        $.ajax({
            type: "get",
            url: "http://127.0.0.1:8000/api/purchase/findAll",
            headers: {
                "Authorization": "Bearer {{ Session::get('isToken') }}",
                "accept": "application/json"
            },
            dataType: "json",
            success: function(response) {
                let table;
                $.each(response, function(i) {
                    let no = 1
                    $.each(response[i], function(k, v) {
                        table += `<tr><td>` + no++ + `</td>
                                    <td>` + v.goods_name + `</td>
                                    <td>` + v.qty + `</td>
                                    <td>` + v.category + `</td>
                                    <td>` + v.company + `</td>
                                    <td>` + v.pay_total + `</td>
                                    <td>
                                    <button type="button" id="editPurchase" class="badge badge-success" data-toggle="modal"
                                    data-target="#editModal" onclick=getPurchaseById("` + v.id + `")>
                                Edit
                            </button>
                                        <a href="#" onclick=deletePurchase("` + v.id + `") class="badge badge-danger">delete</a>
                                    </td>
                                </tr>`
                    });
                });
                $('.purchase').append(table)
            }
        });



        function getPurchaseById(params) {
            console.log(params);
            $.ajax({
                type: "post",
                url: "http://127.0.0.1:8000/api/purchase/findById",
                headers: {
                    "Authorization": "Bearer {{ Session::get('isToken') }}",
                    "accept": "application/json"
                },
                data: {
                    id: params
                },
                dataType: "json",
                success: function(response) {
                    $.each(response, function(i, v) {
                        $('#eproductName').val(v.goods_name)
                        $('#ecompany').val(v.company)
                        $('#epay_total').val(v.pay_total)
                        $('#ecategory').val(v.category)
                        $('#eqty').val(v.qty)
                        $('#purchaseId').val(v.id)
                    });
                }
            });
        }

        function deletePurchase(params) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        headers: {
                            "Authorization": "Bearer {{ Session::get('isToken') }}",
                            "accept": "application/json"
                        },
                        url: "http://127.0.0.1:8000/api/purchase/delete",
                        data: {
                            id: params
                        },
                        dataType: "json",
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            window.location.href =
                                "{{ URL::to('/purchase') }}";
                        }
                    });
                }
            })
        }

        $('#purchaseFormEdit').submit(function(param) {
            param.preventDefault()
            $.ajax({
                type: "post",
                url: "http://127.0.0.1:8000/api/purchase/update",
                headers: {
                    "Authorization": "Bearer {{ Session::get('isToken') }}",
                    "accept": "application/json"
                },
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.body) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Berhasil Ditambah',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.location.href =
                            "{{ URL::to('/purchase') }}";
                    }
                }
            });
        })

        $('#searchByName').on('keyup', function(e) {
            e.preventDefault()
            let productName = $('#searchByName').val();

            $.ajax({
                type: "post",
                url: "http://127.0.0.1:8000/api/purchase/findByProductName",
                headers: {
                    "Authorization": "Bearer {{ Session::get('isToken') }}",
                    "accept": "application/json"
                },
                data: {
                    name: productName
                },
                dataType: "json",
                success: function(response) {
                    let fill;
                    $.each(response, function(i) {
                        let no = 1
                        $.each(response[i], function(k, v) {
                            fill += `<tr>
                                <td>` + no++ + `</td>
                                <td>` + v.goods_name + `</td>
                                <td>` + v.qty + `</td>
                                <td>` + v.category + `</td>
                                <td>` + v.company + `</td>
                                <td>` + v.pay_total + `</td>
                                <td><button type="button" id="editPurchase" class="badge badge-success" data-toggle="modal"data-target="#editModal" onclick=getPurchaseById("` +
                                v.id + `")>
                                Edit
                                </button>
                                        <a href="#" onclick=deletePurchase("` + v.id + `") class="badge badge-danger">delete</a>
                                    </td>
                                </tr>`
                        });
                    });
                    $('.purchase').html(fill)
                }
            });
        })
    </script>
@endsection
