@extends('hrViews.layouts.body')
@section('title', 'Travel Orders')
@section('pagespecificstyle')
@stop
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2><i class="far fa-calendar-check mr-2"></i>Travel Order</h2>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="card-title text-muted" id="travel-list-text">
                  <strong>Travel Order Application</strong>
                </div>
                <div class="card-tools">
                  <button type="button" id="add-travel-btn" class="btn btn-primary btn-sm">
                    <i class="fas fa-file-alt mr-2"></i>
                    Add Travel Order
                  </button>
                  <button type="button" id="return-btn" class="btn btn-secondary btn-sm" style="display: none;">
                    <i class="fas fa-list mr-2"></i>
                    Return to list
                  </button>
                </div>
              </div>

              <div class="card-body">

                <!-- Employee Master List Table -->
                <table id="travel-list-table" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Employee</th>
                      <th>Department</th>
                      <th>Date Filed</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Rows are dynamically being inputted -->
                  </tbody>
                </table>

                <!-- Form for viewing travel order details -->
                <div class="container">
                  <form id="travel-view-form" action="" method="post" class="needs-validation" novalidate style="display: none;">
                    @if(Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if(Session::has('fail'))
                    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                    @endif
                    @csrf
                    <input type="text" id="view-control-number-hidden" name="view_control_number" class="d-none" readonly/>
                    <div class="form-group d-flex justify-content-end text-muted small">
                        <span class="mr-2"><strong>Control Number:</strong></span>
                        <span id="view-control-number"></span>
                        <span class="ml-3 mr-2"><strong>Date Filed:</strong></span>
                        <span id="view-date-filed" name="view_date_filed"></span>
                    </div>
                    <hr> <!-- Horizontal line separator before the title -->
                    <!-- Date Overtime -->
                    <div class="form-group row">
                        <div class="col">
                            <label for="view-employee-id">Employee Name</label>
                            <select class="form-control select2" style="width: 100%;" name="view_employee_name" id="view-employee-id" disabled>
                                <option value="" selected disabled>Type / Select Employee</option>
                            </select>
                        </div>
                    </div>
                    <hr> <!-- Horizontal line separator -->
                    <!-- Time In and Time Out -->
                    <div class="form-group row">
                        <div class="col">
                            <label for="view-departure-date">Date Departure</label>
                            <input type="date" class="form-control" id="view-departure-date" name="view_departure_date" readonly>
                        </div>
                        <div class="col">
                            <label for="view-departure-time">Departure Time</label>
                            <input type="time" class="form-control" id="view-departure-time" name="view_departure_time" readonly>
                            <!-- Error message for Time Out generated by jquery -->
                            <span id="time_out_error" class="text-danger" style="display: none;"></span>
                        </div>
                        <div class="col">
                            <label for="view-return-time">Return Time</label>
                            <input type="time" class="form-control" id="view-return-time" name="view_return_time" readonly>
                            <!-- Error message for Time Out generated by jquery -->
                            <span id="time_out_error" class="text-danger" style="display: none;"></span>
                        </div>
                    </div>
                    <hr> <!-- Horizontal line separator -->
                    <!-- Reason -->
                    <div class="form-group row">
                        <div class="col">
                            <label for="view-destination">Destination</label>
                            <input type="text" class="form-control" id="view-destination" name="view_destination" placeholder="Provide Destination" readonly>
                        </div>
                        <div class="col">
                            <label for="view-purpose">Purpose</label>
                            <input type="text" class="form-control" id="view-purpose" name="view_purpose" placeholder="Enter purpose" readonly>
                        </div>
                        <div class="col">
                            <label for="view-remarks">Remarks</label>
                            <input type="text" class="form-control" id="view-remarks" name="view_remarks" placeholder="Enter remarks" readonly>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-primary btn-block" id="submitButton" disabled>Submit</button>
                    </div>
                </form>
                </div>

                <!-- Form for travel order applications -->
                <div class="container">
                    <form id="travel-form" action="/submit-travel-application" method="post" class="needs-validation" novalidate style="display: none;">
                        @if(Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if(Session::has('fail'))
                            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                        @endif
                        @csrf
                        <input type="text" id="control-number-hidden" name="control_number" class="d-none"/>
                        <div class="form-group d-flex justify-content-end text-muted small">
                          <span class="mr-2"><strong>Control Number:</strong></span>
                          <span id="control-number"></span>
                          <span class="ml-3 mr-2"><strong>Date Filed</strong></span>
                          <span id="date-filed" name="date_filed"></span>
                        </div>
                        <hr> <!-- Horizontal line separator before the title -->
                        <!-- Date Overtime -->
                        <div class="form-group row">
                            <div class="col">
                                <label for="employee-name">Employee Name</label>
                                <select class="form-control select2" style="width: 100%;" name="employee_id" id="employee-id">
                                    <option value="" selected disabled>Type / Select Employee</option>
                                </select>
                            </div>
                        </div>
                        <hr> <!-- Horizontal line separator -->
                        <!-- Time In and Time Out -->
                        <div class="form-group row">
                            <div class="col">
                                <label for="departure_date">Date Departure</label>
                                <input type="date" class="form-control" id="departure-date" name="departure_date" required>
                            </div>
                            <div class="col">
                                <label for="departure_time">Departure Time</label>
                                <input type="time" class="form-control" id="departure-time" name="departure_time" required>
                                <!-- Error message for Time Out generated by jquery -->
                                <span id="time_out_error" class="text-danger" style="display: none;"></span>
                            </div>
                            <div class="col">
                                <label for="return_time">Return Time</label>
                                <input type="time" class="form-control" id="return-time" name="return_time" required>
                                <!-- Error message for Time Out generated by jquery -->
                                <span id="time_out_error" class="text-danger" style="display: none;"></span>
                            </div>
                        </div>
                        <hr> <!-- Horizontal line separator -->
                        <!-- Reason -->
                        <div class="form-group row">
                            <div class="col">
                                <label for="destination">Destination</label>
                                <input type="text" class="form-control" id="destination" name="destination" placeholder="Provide Destination" required>
                            </div>
                            <div class="col">
                                <label for="purpose">Purpose</label>
                                <input type="text" class="form-control" id="purpose" name="purpose" placeholder="Enter purpose" required>
                            </div>
                            <div class="col">
                                <label for="remarks">Remarks</label>
                                <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter remarks" required>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-primary btn-block" id="submitButton">Submit</button>
                        </div>
                    </form>
                </div>

                <!-- Form for updating travel order applications -->
                <div class="container">
                    <form id="update-travel-form" action="/submit-travel-application" method="post" class="needs-validation" novalidate style="display: none;">
                        @if(Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if(Session::has('fail'))
                            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                        @endif
                        @csrf
                        <input type="text" id="update-control-number-hidden" name="update_control_number" class="d-none"/>
                        <div class="form-group d-flex justify-content-end text-muted small">
                          <span class="mr-2"><strong>Control Number:</strong></span>
                          <span id="update-control-number"></span>
                          <span class="ml-3 mr-2"><strong>Date Filed</strong></span>
                          <span id="update-date-filed" name="update_date_filed"></span>
                        </div>
                        <hr> <!-- Horizontal line separator before the title -->
                        <!-- Date Overtime -->
                        <div class="form-group row">
                            <div class="col">
                                <label for="update-employee-name">Employee Name</label>
                                <select class="form-control select2" style="width: 100%;" name="update_employee_id" id="update-employee-id">
                                    <option value="" selected disabled>Type / Select Employee</option>
                                </select>
                            </div>
                        </div>
                        <hr> <!-- Horizontal line separator -->
                        <!-- Time In and Time Out -->
                        <div class="form-group row">
                            <div class="col">
                                <label for="update-departure-date">Date Departure</label>
                                <input type="date" class="form-control" id="update-departure-date" name="update_departure_date" required>
                            </div>
                            <div class="col">
                                <label for="update-departure-time">Departure Time</label>
                                <input type="time" class="form-control" id="update-departure-time" name="update_departure_time" required>
                                <!-- Error message for Time Out generated by jquery -->
                                <span id="update-time-out-error" class="text-danger" style="display: none;"></span>
                            </div>
                            <div class="col">
                                <label for="update-return-time">Return Time</label>
                                <input type="time" class="form-control" id="update-return-time" name="update_return_time" required>
                                <!-- Error message for Time Out generated by jquery -->
                                <span id="update-time-out-error" class="text-danger" style="display: none;"></span>
                            </div>
                        </div>
                        <hr> <!-- Horizontal line separator -->
                        <!-- Reason -->
                        <div class="form-group row">
                            <div class="col">
                                <label for="update-destination">Destination</label>
                                <input type="text" class="form-control" id="update-destination" name="update_destination" placeholder="Provide Destination" required>
                            </div>
                            <div class="col">
                                <label for="update-purpose">Purpose</label>
                                <input type="text" class="form-control" id="update-purpose" name="update_purpose" placeholder="Enter purpose" required>
                            </div>
                            <div class="col">
                                <label for="update-remarks">Remarks</label>
                                <input type="text" class="form-control" id="update-remarks" name="update_remarks" placeholder="Enter remarks" required>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-primary btn-block" id="update-submit-button">Submit</button>
                        </div>
                    </form>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('pagespecificscript')
<script src="{{ asset('custom/js/hrViewsScript/travelList.js') }}"></script>

<script>
  $(document).on('click', '#view-details-btn', function()
    {
      $('#travel-view-form').show();
      $('#travel-list-table').hide();
      $('#add-travel-btn').toggle();
      $('#return-btn').toggle();
      $('#travel-list-text').html('<strong>Travel Order Details</strong>');
      $('.dataTables_paginate, .dataTables_info, .dataTables_length, .dataTables_filter').toggle();
    });

    $(document).on('click', '#modify-btn', function()
    {
      $('#update-leave-form').show();
      $('#leave-list-table').hide();
      $('#add-leave-btn').toggle();
      $('#return-btn').toggle();
      $('#employee-list-text').html('<strong>Modify Travel Order</strong>');
      $('.dataTables_paginate, .dataTables_info, .dataTables_length, .dataTables_filter').toggle();
    });

    $('#return-btn').click(function() 
    {
      $('#travel-view-form').hide();
      $('#update-travel-form').hide();
      $('#travel-form').hide();
      $('#travel-list-table').show();
      $('#add-travel-btn').toggle();
      $('#return-btn').toggle();
      $('#travel-list-text').html('<strong>Travel Order Application</strong>');
      $('.dataTables_paginate, .dataTables_info, .dataTables_length, .dataTables_filter').toggle();
    });

    $('#add-travel-btn').click(function()
    {
      $('#travel-form').show();
      $('#travel-list-table').hide();
      $('#add-travel-btn').toggle();
      $('#return-btn').toggle();
      $('#travel-list-text').html('<strong>Add New Travel Order</strong>');
      $('.dataTables_paginate, .dataTables_info, .dataTables_length, .dataTables_filter').toggle();
    });

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    $(document).on('click', '#print-btn', function() 
    {
       var applicationNumber = $(this).data('application-number');

        // Show loading animation
        Swal.fire
        ({
          title: 'Generating Travel Order...',
          html: 'Please wait while we generate your Travel Order.',
          allowOutsideClick: false,
          didOpen: () => 
          {
            Swal.showLoading();
            // Add a slight delay to ensure the loading animation is shown
            setTimeout(() => 
            {
              var printUrl = '/print-travel';
              window.open(printUrl, '_blank');
              Swal.close();
            }, 3000); // Adjust the delay as needed
          }
      });
    })
</script>

<!-- Add necessary scripts for carousel functionality -->
<script>
  $(document).ready(function() {
    $('#form-carousel').carousel({
      interval: false
    });

    // Add custom validation for forms if needed
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        var form = document.getElementById('add-employee-form');
        if (form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        }
      }, false);
    })();
  });
</script>
@stop