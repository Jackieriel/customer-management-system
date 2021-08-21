@extends('layouts.app')

{{-- @section('title')
    {{ $title }}
@endsection --}}


@section('content')


    <div class="container">
        <div class="card row">
            <div class="card-body col-md-12">

                <div id="card-header" class=" card-header">
                    <b>Customers List</b>
                    <span>
                        <a href="#" class=" btn btn-primary" data-toggle="modal" data-target="#customerModal"><i
                                class="fa fa-plus-circle"></i> Add</a>
                    </span>
                </div>

                <br>
                <div class="card-body">
                    <table class="table table-bordered" id="customerList">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Phone #</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($customers as $customer)
                            <tr id="cid{{ $customer->id }}">
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->address }}</td>
                                <td><a href="javascript:void(0)"
                                        onclick="editCustomer(<?php echo $customer->id; ?>)"
                                        class="btn btn-primary">Edit</a><a href="javascript:void(0)"
                                        onclick="deleteCustomer(<?php echo $customer->id; ?>)"
                                        class="btn btn-danger">Delete</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <!-- Button trigger modal -->



            <!-- Add Customer Modal -->
            <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id='addCustomer'>
                                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address">
                                                                                          </textarea>
                                    <input type="hidden" class="form-control" id="name" name="">
                                </div>
                                <input type="submit" value="Add" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Update Customer Modal -->
            <div class="modal fade" id="editcustomerModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id='editcustomerForm'>
                                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                                <input type="hidden" id="id" name="id">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name1" name="name1">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone1" name="phone1">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email1" name="email1">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address1" name="address1"></textarea>
                                </div>
                                <input type="submit" value="Add" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Add function --}}
    <script type="text/javascript">
        $("#addCustomer").submit(function(e) {
            e.preventDefault();
            let name = $("#name").val();
            let phone = $("#phone").val();
            let email = $("#email").val();
            let address = $("#address").val();
            let _token = $("input[_token]").val();
            $.ajax({
                url: "{{ route('addCustomer') }}",
                type: "POST",
                data: {
                    name: name,
                    phone: phone,
                    email: email,
                    address: address,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response) {
                        $("#customerList tbody").append('<tr><td>' + response.id + '<td>' + response
                            .name + '</td><td>' + response.phone + '</td><td>' + response.email +
                            '</td><td>' + response.address + '</td><td>' +
                            "<a href='javascript:void(0)' onclick='editCustomer(" + response.id +
                            ")'class='btn btn-primary'>Edit</a><a href='' class='btn btn-danger'>Delete</a>" +
                            '</td></tr>');
                        $("#addCustomer")[0].reset();
                        $("#customerModal").modal('hide');
                    }
                }
            });
        });

    </script>


    {{-- Edit function --}}
    <script type="text/javascript">
        function editCustomer(id) {
            // opens edit modal and inserts values
            $.get('/customer/' + id, function(customer) {
                $("#id").val(customer.id);
                $("#name1").val(customer.name);
                $("#phone1").val(customer.phone);
                $("#email1").val(customer.email);
                $("#address1").val(customer.address);
                $("#editcustomerModal").modal('toggle');
            });
        }
        // updates the customer
        $("#editcustomerForm").submit(function(e) {
            e.preventDefault();
            let id = $("#id").val();
            let name = $("#name1").val();
            let phone = $("#phone1").val();
            let email = $("#email1").val();
            let address = $("#address1").val();
            let _token = $("input[_token]").val();
            $.ajax({
                url: "{{ route('updateCustomer') }}",
                type: "PUT",
                data: {
                    id: id,
                    name: name,
                    phone: phone,
                    email: email,
                    address: address,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#cid' + response.id + ' td:nth-child(1)').text(response.id);
                    $('#cid' + response.id + ' td:nth-child(2)').text(response.name);
                    $('#cid' + response.id + ' td:nth-child(3)').text(response.phone);
                    $('#cid' + response.id + ' td:nth-child(4)').text(response.email);
                    $('#cid' + response.id + ' td:nth-child(5)').text(response.address);
                    $("#editcustomerModal").modal('hide');
                    $("#editcustomerForm")[0].reset();
                }
            });
        });

    </script>

    {{-- Delete function --}}
    <script type="text/javascript">
        function deleteCustomer(id) {
            if (confirm("Do you want to delete?")) {
                $.ajax({
                    url: '/deleteCustomer/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $("#cid" + id).remove();
                    }
                });
            }
        }

    </script>



@endsection
