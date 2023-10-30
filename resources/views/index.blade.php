<!DOCTYPE html>
<html>
    <head>
        <title>Document</title>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
    </head>
    <body>
        <form id="form">
            @csrf
            <input type="hidden" name="record_id" id="record_id">
            <table>
                <tr>
                    <td>Name</td>
                    <td><input type="text" name="name" id="name" required></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" id="email" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" id="form-submit"></td>
                </tr>
            </table>
        </form>
        <div id="message"></div>

        <table id="data" border="1" style="border-collapse:collapse;" width="50%">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </table>
        <script>
            $(document).ready(function(){
                function updatetable(){
                    $.ajax({
                        url:'{{url("/form")}}',
                        method:'get',
                        success: function(result){
                            // Clear the existing table content
                            $('#data').find("tr:gt(0)").remove();
    
                            // Populate the table with data
                            $.each(result.data, function(index, record) {
                                var row = '<tr>';
                                row += '<td>' + record.id + '</td>';
                                row += '<td>' + record.name + '</td>';
                                row += '<td>' + record.email + '</td>';
                                row += '<td><a href="#" class="edit-record" data-id="' + record.id + '">Edit</a></td>';
                                row += '<td><a href="#" class="delete-record" data-id="' + record.id + '">Delete</a></td>';
                                row += '</tr>';
                                $('#data').append(row);
                            });
     
                            $('.delete-record').click(function(e){
                                e.preventDefault();
                                var recordId = $(this).data('id');
                                deleteRecord(recordId);
                            });

                            $('.edit-record').click(function (e) {
                                e.preventDefault();
                                var recordId = $(this).data('id');
                                editRecord(recordId);
                            });
                        }
                    });
                }
                function deleteRecord(recordId) {
                    $.ajax({
                        url: '{{ url("delete_record") }}', // Define the route for delete operation
                        method: 'post',
                        data: { _token: '{{ csrf_token() }}', id: recordId }, // Include CSRF token and record ID
                        success: function(result) {
                            $('#message').html(result.msg);
                            updatetable(); // Refresh the table after deletion
                        }
                    });
                }

                // Function to edit a record
                function editRecord(recordId) {
                    // Fetch the record data to be edited
                    $.ajax({
                        url: '{{ url("get_record") }}',
                        method: 'get',
                        data: { id: recordId },
                        success: function (result) {
                            $('#record_id').val(result.data.id);
                            $('#name').val(result.data.name);
                            $('#email').val(result.data.email);
                            // console.log(result.data.name);
                        }
                    });
                }

                function resetForm() {
                    $('#record_id').val('');
                    $('#name').val('');
                    $('#email').val('');
                }
                
                updatetable();
                
                $('#form').submit(function(e){
                    e.preventDefault();
                    var recordId = $('#record_id').val();
                    
                    var url = recordId ? '{{ url("update_record") }}' : '{{ url("form_submit") }}';
                    
                    $.ajax({
                        url:url,
                        data:$('#form').serialize(),
                        type:'post',
                        success:function(result){
                            $('#message').html(result.msg);
                            updatetable();
                            resetForm();
                        }
                    });
                });
            });
        </script>
    </body>
</html>