<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

@include('admin_pannel.layouts.styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('AdminLTE/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

 @include('admin_pannel.layouts.nav')

 @include('admin_pannel.layouts.aside')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Students Details</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_student">
                                       Add New Student
                                      </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-head-fixed text-nowrap" id="student_details">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Class</th>
                                <th>Last Deposit</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
        
                            </tbody>
                        </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
  </div>

  <!-- Modal -->
<div class="modal fade" id="add_student" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add A New Student</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container mt-5">
                <h2 class="mb-4">Student Information Form</h2>
            
                <form action="{{route('student_details')}}" method="POST"  id="student_detail_form">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
                    </div>
            
                    <div class="form-group">
                        <label for="age">Age:</label>
                        <input type="number" class="form-control" name="age" id="age" placeholder="Enter Age(in Years)" required>
                    </div>
            
                    <div class="form-group">
                        <label for="class">Class:</label>
                        <select name="class" id="class" class="form-control" required>
                            <option value="" selected disabled>Select Class</option>
                            @foreach ($classes as $item)
                            <option value="{{$item->classes}}">{{$item->classes}} Class</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="student_details()">Add Record</button>
        </div>
      </div>
    </div>
  </div>



  <!-- Fess Modal -->
    <div class="modal fade" id="studentfees" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Fee Record of -:</h5>
                    <i class="fas fa-money-bill" style="position: relative; left: 20%; padding-top: 10px;" onclick="new_fess()" ></i>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="amount">Amount:</label>
                            <input type="number" class="form-control" name="amount" value="" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="due_on">Due Date:</label>
                            <input type="date" class="form-control" name="due_on" value="" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="deposit_on">Deposit Date:</label>
                            <input type="date" class="form-control" name="deposit_on">
                        </div>
                        <div class="form-group col-md-3" style="padding-top: 1px">
                            <label for="checkbox">Checkbox:</label><br>
                            <input type="checkbox" class="form-control"  data-toggle="toggle">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- New Fees Model --}}
        <div class="modal fade" id="new_fees_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Fess Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="amount">Amount:</label>
                                <input type="number" class="form-control" name="amount" placeholder="Enter The Fees Amount....  ">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="due_on">Due Date:</label>
                                <input type="date" class="form-control" name="due_on">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="add_fees()">Add Next Due</button>
                    </div>
                </div>
            </div>
        </div>


  @include('admin_pannel.layouts.footer')
</div>
@include('admin_pannel.layouts.scripts')
</body>
</html>
