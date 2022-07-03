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
                            <div class="row mt-2 ml-2">
                                <input type="text" id="searchByNameGoods" class="form-input" placeholder="search">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md" id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah Produk</th>
                                            <th>Kategori</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="goods">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $.ajax({
            type: "get",
            url: "http://127.0.0.1:8000/api/goods/findAll",
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
                                <td>` + v.name + `</td>
                                <td>` + v.qty + `</td>
                                <td>` + v.category + `</td>
                                <td>
                                    <a href="#" onclick=deleteGoods("` + v.id + `") class="badge badge-danger">delete</a>
                                </td>
                            </tr>`
                    });
                });
                $('.goods').append(table)
            }
        });

        function deleteGoods(params) {
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
                        url: "http://127.0.0.1:8000/api/goods/delete",
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
                                "{{ URL::to('/goods') }}";
                        }
                    });
                }
            })
        }

        $('#searchByNameGoods').on('keyup', function(e) {
            e.preventDefault()
            let productName = $('#searchByNameGoods').val();

            $.ajax({
                type: "post",
                url: "http://127.0.0.1:8000/api/goods/findByProductName",
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
                            fill += `<tr><td>` + no++ + `</td>
                                <td>` + v.name + `</td>
                                <td>` + v.qty + `</td>
                                <td>` + v.category + `</td>
                                <td>
                                    <a href="#" onclick=deleteGoods("` + v.id + `") class="badge badge-danger">delete</a>
                                </td>
                            </tr>`
                        });
                    });
                    $('.goods').html(fill)
                }
            });
        })
    </script>
@endsection
