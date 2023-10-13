@extends('layouts.template')

@section('content')
<div id="msg-success"></div>
@if(Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if(Session::get('deleted'))
<div class="alert alert-warning">{{ Session::get('deleted') }}</div>
@endif

<div class="d-flex flex-row-reverse">
    <div class="p-2">
        <a href="{{ route('account.create')}}" class="btn btn-secondary">Tambah pengguna</a>
</div>
</div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>email</th>
            <th>role</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($account as $item)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $item['nama'] }}</td>
            <td>{{ $item['email'] }}</td>
            <td>{{ $item['role'] }}</td>
            <td class="d-flex justify-content-center">
                <a href="{{ route('account.edit', $item['id'] )}}" class="btn btn-primary me-3">Edit</a>
                {{-- <form action="{{ route('account.delete', $item['id']) }}" method="POST">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Hapus</button>
                    </div> --}}
              
                    <!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="hapus('{{$item['id']}}')" >
    Hapus
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus data</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" id="form-delete">
            
            <input type="hidden" name="id" id="id">
        <div class="modal-body">
          Yakin hapus data?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger" >Hapus</button>
        </div>
    </form>
      </div>
    </div>
  </div>
  @endforeach
 @endsection
                    
                    
                    @push('script')
                        <script type="text/javascript">
                    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    
                    function hapus(id) {
                        var url = "{{ route('account.hapus', ":id") }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            type: "GET",
                            url: url,
                            dataType: "json",
                            success: function(res){
                                $('#edit-stock').modal('show');
                                $('#id').val(res.id);
           
                            }
                        });
                    }
                    
                    $('#form-delete').submit(function(e){
                        e.preventDefault();
                    
                        var id = $('#id').val();
                        var urlForm = "{{ route('account.delete', ":id") }}";
                        urlForm = urlForm.replace(':id', id);
                    
                        var data = {
                            stock: $('#stock').val(),
                        };
                    
                        $.ajax({
                            type: 'DELETE',
                            url:  urlForm,
                            data: data,
                            cache: false,
                            success: (data) => {
                                $("#edit-stock").modal('hide');
                                sessionStorage.reloadAfterPageLoad = true;
                                window.location.reload();
                            },
                            error: function(data){
                                $('#msg').attr("class", "alert alert-danger");
                                $('#msg').text(data.responseJSON.message);
                            }
                        });
                    });
                        
                    $(function() {
                        if(sessionStorage.reloadAfterPageLoad){
                            $('#msg-success').attr("class", "alert alert-success");
                            $('#msg-success').text("Berhasil menghapus data!");
                            sessionStorage.clear();
                        }
                    });
                    
                    </script>
                    @endpush
                </form>
            </td>
        </tr>
    </tbody>
</table>
