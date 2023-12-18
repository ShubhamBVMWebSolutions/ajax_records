
<!-- jQuery -->
<script src="{{asset('AdminLTE//plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('AdminLTE/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('AdminLTE/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('AdminLTE/plugins/sparklines/sparkline.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('AdminLTE/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('AdminLTE/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('AdminLTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('AdminLTE/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('AdminLTE/dist/js/demo.js')}}"></script>

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script>
  function student_details() {
    var formData = $('#student_detail_form').serialize();
    $.ajax({
            url: "{{ route('student_details') }}",
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                alert(response.message); 
                $('#student_detail_form')[0].reset();
                $('#add_student').modal('hide');
                fetchStudentData();
            },
            error: function(error) {
              alert('An error occurred. Please try again.');
            }
        });
  }
  

  function fetchStudentData() {
        $.ajax({
            url: '/student-data', 
            method: 'GET',
            dataType: 'json',
            success: function(data) {
              fillTableWithData(data);
            },
            error: function(error) {
            }
        });
    }

      function fillTableWithData(studentData) {
        var tableBody = $('#student_details tbody');
        tableBody.empty();
        var counter = 1;
        for (var i = 0; i < studentData.length; i++) {
          var row = '<tr>';
          row += '<td>' + counter + '</td>';
          row += '<td>' + studentData[i].name + '</td>';
          row += '<td>' + studentData[i].age + '</td>';
          row += '<td><span class="tag tag-success">' + studentData[i].class + '</span></td>';
          row += '<td>' + (studentData[i].last_deposit_date ? studentData[i].last_deposit_date : 'The Fees Is not Yet Being deposited') + '</td>';
          row += '<td><i class="fas fa-money-bill" title ="Fees Record" style="cursor: pointer;" onclick="openModal(' + studentData[i].id + ', \'' + studentData[i].name + '\')"></i><i class="fas fa-trash" title ="Delete Record" style="cursor: pointer; padding-left: 21px;" onclick="deleteRecord(' + studentData[i].id + ', \'' + studentData[i].name + '\')"></i></td>';
          row += '</tr>';
          tableBody.append(row);
          counter++;
        }
    }

    $(document).ready(function() {
      fetchStudentData();
    });

    var currentStudentId;
    var currentStudentName;
    function openModal(studentId, studentName) {
      var modal = $('#studentfees');
      currentStudentId = studentId;
      currentStudentName = studentName;
      $.ajax({
        url: '/fetch-fees/' + studentId,
        method:'GET',
        dataType:'json',
        success:function(response){
          
          modal.find('.modal-body').empty();
          if (response.message === 'Data Fetched successfully' && response.fees.length > 0) {
            modal.find('.modal-title').text('Fee Record of -: ' + studentName + '');
            $.each(response.fees,function (index , fee) {
             
              var feeDetails = '<div class="form-row">';
               feeDetails += '<input type="hidden" class="form-control" name="id" value="' + fee.id + '" >';
               feeDetails += '<div class="form-group col-md-3">';
               feeDetails += '<label for="amount">Amount:</label>';
               feeDetails += '<input type="number" class="form-control" name="amount" value="' + fee.amount + '" disabled>';
               feeDetails += '</div>';
               feeDetails += '<div class="form-group col-md-3">';
               feeDetails += '<label for="due_on">Due Date:<span style="font-weight: 100;font-size:smaller;">(mm/dd/yyyy)</span></label>';
               feeDetails += '<input type="date" class="form-control" name="due_on" value="' + fee.due_date + '" disabled>';
               feeDetails += '</div>';
               feeDetails += '<div class="form-group col-md-3">';
               feeDetails += '<label for="deposit_on">Deposit Date:<span style="font-weight: 100;font-size:smaller;">(mm/dd/yyyy)</span></label>';
               feeDetails += '<input type="date" class="form-control" name="deposit_on" value="' + fee.deposit_date + '"' + (fee.status == 1 ? 'disabled' : '') + ' required>';
               feeDetails += '</div>';
               feeDetails += '<div class="form-group col-md-2" style="padding-top: 1px">';
               feeDetails += '<label for="checkbox">Submit:</label><br>';
               feeDetails += '<input type="checkbox" class="form-control toggle-switch" data-id="' + fee.id + '" data-toggle="toggle"' + (fee.status == 1 ? 'checked disabled' : '') + '>';
               feeDetails += '</div>';
               feeDetails += '<div class="form-group col-md-1" style="padding-top: 1px">';
               feeDetails += '<label for="checkbox">Delete:</label><br>';
               feeDetails += '<i class="fas fa-trash" title ="Delete Record" style="cursor: pointer; padding-left: 21px; padding-top: 10px;" onclick="deleteFeeRecord(' + fee.id + ')"></i>';
               feeDetails += '</div>';
               feeDetails += '</div>'; 
               modal.find('.modal-body').append(feeDetails);
               modal.find('.toggle-switch').bootstrapToggle();
            });
            modal.modal('show');
            modal.find('.toggle-switch').change(function () {
              var checkbox = $(this);
              var depositIdValue =  checkbox.data('id');
              var depositDateValue = checkbox.closest('.form-row').find('input[name="deposit_on"]').val();
              $.ajax({
                      url: '/update-fees',
                      method:'POST',
                      data: {
                            _token: '{{ csrf_token() }}',
                            depositIdValue: depositIdValue,
                            depositDateValue: depositDateValue,
                            currentStudentId:currentStudentId
                          },
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                              alert(response.error);
                              openModal(currentStudentId,currentStudentName);
                            }else{
                              modal.modal('hide');
                              fetchStudentData();
                            }
                          },
                        error: function(error) {
                        
                      }
                    });
                  });
          } else if(response.message === 'Data Fetched successfully' && response.fees.length < 1) {
            modal.find('.modal-title').text('Fee Record of -: ' + studentName + '');
            modal.modal('show');
          }else{
            
          }
        },
        error :function(error){
          
        }
      });
    }

function new_fess() {
    var uncheckedCheckbox = false;
    $('.toggle-switch').each(function() {
        if (!$(this).prop('checked')) {
            uncheckedCheckbox = true;
            return false; 
        }
    });

    if (uncheckedCheckbox) {
        alert('Previous Month Fees Is Still Pending !');
    } else {
        $('#new_fees_model').modal('show');
    }
}

  function add_fees() {
    var amount = $('#new_fees_model input[name="amount"]').val();
    var due_on = $('#new_fees_model input[name="due_on"]').val();
    $.ajax({
      url: '/add-fees',
      method:'POST',
      data: {
                _token: '{{ csrf_token() }}',
                amount: amount,
                due_on: due_on,
                currentStudentId:currentStudentId
            },
      dataType: 'json',
      success: function(response) {
          if (response.error) {
            alert(response.error);
            $('#new_fees_model').on('hidden.bs.modal', function () {
              $(this).find('input[type="number"], input[type="date"]').val('');
            });
            $('#new_fees_model').modal('hide');
          } else {
            alert(response.message);
            $('#studentfees input[name="amount"]').val(response.fees.amount);
            $('#studentfees input[name="due_on"]').val(response.fees.due_date);
            $('#new_fees_model').on('hidden.bs.modal', function () {
              $(this).find('input[type="number"], input[type="date"]').val('');
            });
            $('#new_fees_model').modal('hide');
            openModal(currentStudentId,currentStudentName);
            
          }
            },
      error: function(error) {
       alert(error.message);
            }
    });
  }


  $(document).ready(function () {
    $('#search').on('input',function () {
       var query = $(this).val();
       $.ajax({
        url : '{{route('search')}}',
        method : 'GET',
        data : {query : query},
        success:function(data){
          displayResults(data.results);
        },
        error:function(error){
          console.error('Error Searching :',error);
        }
       }); 
    });
    function displayResults(results) {
      var $tableBody = $('#student_details tbody')
      $tableBody.empty();

      if (results.length>0) {
        results.forEach(function (result, index) {
                    var row = '<tr>';
                    row += '<td>' + (index + 1) + '</td>';
                    row += '<td>' + result.name + '</td>';
                    row += '<td>' + result.age + '</td>';
                    row += '<td>' + result.class + '</td>';
                    row += '<td>' + (result.last_deposit_date ? result.last_deposit_date : 'The Fees Is not Yet Being deposited') + '</td>';
                    row += '<td><i class="fas fa-money-bill" style="cursor: pointer;" onclick="openModal(' + result.id + ', \'' + result.name + '\')"></i> <i class="fas fa-trash" title ="Delete Record" style="cursor: pointer; padding-left: 21px;" onclick="deleteRecord(' + result.id + ', \'' + result.name + '\')"></i> </td>';
                    row += '</tr>';
                    $tableBody.append(row);
                });
      }else{
        $tableBody.append('<tr><td colspan="6" class="text-center">No Student Found</td></tr>');
      }
    }   
  });
  function deleteRecord(id,name) {
    if (confirm('Are you sure you want to delete The Records Of :- ' + name + '?')) {
        $.ajax({
            url: '/delete-student/' + id,
            method: 'DELETE',
            dataType: 'json',
            data : {_token: '{{ csrf_token() }}'},
            success: function (response) {
                alert(response.message);
                fetchStudentData();
            },
            error: function (error) {
                alert('An error occurred. Please try again.');
            }
        });
    }
  }

  function deleteFeeRecord(id) {
    if (confirm('This Action Will Permanently Delete This Fees Record .Are you sure you want to continue')) {
      $.ajax({
        url : '/delete-fee-record/' +id,
        method :'DELETE',
        dataType : 'json',
        data :{_token:'{{csrf_token()}}'},
        success:function(response){
          alert(response.message);
          openModal(currentStudentId,currentStudentName);
        },
        error:function (error) {
          console.error('Error occurred:', error);
          alert('An Error Occured! Please Try Again After Some Time ');
        }
      }); 
    }
  }

  function date_filtration() {
    // alert(currentStudentId);
    var selectedDate = document.getElementById('date_filter').value;
    $.ajax({
      url : '/date-filter',
      method : 'GET',
      dataType :'json',
      data : {
        currentStudentId:currentStudentId,
        selectedDate:selectedDate
      },
      success:function(response){
        var modal = $('#studentfees');
        modal.find('.modal-body').empty();
        if (response.message === 'Data Fetched successfully' && response.fees.length > 0) {
            $.each(response.fees,function (index , fee) {
             
              var feeDetails = '<div class="form-row">';
               feeDetails += '<input type="hidden" class="form-control" name="id" value="' + fee.id + '" >';
               feeDetails += '<div class="form-group col-md-3">';
               feeDetails += '<label for="amount">Amount:</label>';
               feeDetails += '<input type="number" class="form-control" name="amount" value="' + fee.amount + '" disabled>';
               feeDetails += '</div>';
               feeDetails += '<div class="form-group col-md-3">';
               feeDetails += '<label for="due_on">Due Date:<span style="font-weight: 100;font-size:smaller;">(mm/dd/yyyy)</span></label>';
               feeDetails += '<input type="date" class="form-control" name="due_on" value="' + fee.due_date + '" disabled>';
               feeDetails += '</div>';
               feeDetails += '<div class="form-group col-md-3">';
               feeDetails += '<label for="deposit_on">Deposit Date:<span style="font-weight: 100;font-size:smaller;">(mm/dd/yyyy)</span></label>';
               feeDetails += '<input type="date" class="form-control" name="deposit_on" value="' + fee.deposit_date + '"' + (fee.status == 1 ? 'disabled' : '') + ' required>';
               feeDetails += '</div>';
               feeDetails += '<div class="form-group col-md-2" style="padding-top: 1px">';
               feeDetails += '<label for="checkbox">Submit:</label><br>';
               feeDetails += '<input type="checkbox" class="form-control toggle-switch" data-id="' + fee.id + '" data-toggle="toggle"' + (fee.status == 1 ? 'checked disabled' : '') + '>';
               feeDetails += '</div>';
               feeDetails += '<div class="form-group col-md-1" style="padding-top: 1px">';
               feeDetails += '<label for="checkbox">Delete:</label><br>';
               feeDetails += '<i class="fas fa-trash" title ="Delete Record" style="cursor: pointer; padding-left: 21px; padding-top: 10px;" onclick="deleteFeeRecord(' + fee.id + ')"></i>';
               feeDetails += '</div>';
               feeDetails += '</div>'; 
               modal.find('.modal-body').append(feeDetails);
               modal.find('.toggle-switch').bootstrapToggle();
            });
            modal.modal('show');
            modal.find('.toggle-switch').change(function () {
              var checkbox = $(this);
              var depositIdValue =  checkbox.data('id');
              var depositDateValue = checkbox.closest('.form-row').find('input[name="deposit_on"]').val();
              $.ajax({
                      url: '/update-fees',
                      method:'POST',
                      data: {
                            _token: '{{ csrf_token() }}',
                            depositIdValue: depositIdValue,
                            depositDateValue: depositDateValue,
                            currentStudentId:currentStudentId
                          },
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                              alert(response.error);
                              openModal(currentStudentId,currentStudentName);
                            }else{
                              modal.modal('hide');
                              fetchStudentData();
                            }
                          },
                        error: function(error) {
                        
                      }
                    });
                  });
          } else {
            openModal(currentStudentId,currentStudentName);
            document.getElementById('date_filter').value = ''
          }
      },
      error:function(error){
        console.error(error);
      }
    });
  }
</script>