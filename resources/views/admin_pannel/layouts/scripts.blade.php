
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
                console.error('Error fetching data:', error);
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
          row += '<td><i class="fas fa-money-bill" style="cursor: pointer;" onclick="openModal(' + studentData[i].id + ', \'' + studentData[i].name + '\')"></i></td>';
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
               feeDetails += '<div class="form-group col-md-3" style="padding-top: 1px">';
               feeDetails += '<label for="checkbox">Checkbox:</label><br>';
               feeDetails += '<input type="checkbox" class="form-control toggle-switch" data-id="' + fee.id + '" data-toggle="toggle"' + (fee.status == 1 ? 'checked disabled' : '') + '>';
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
</script>