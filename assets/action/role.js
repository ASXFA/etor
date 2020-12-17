$(function(){
    $('#pengaturan').attr('class','nav-link menu-open');
    $('#role-page').attr('class','nav-link active');
    $('#tableRole').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"roleLists",
            type:"post",
        },
        "columnDefs":[
            {
                "targets":[-1],
                "orderable":false,
            },
        ],
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    $('#btnAddRoleModal').click(function(){
        $('#addRoleModal').modal('show');
        $('#role_id').val('');
        $('#action').val('Add');
        $('#operation').val('Add');
        $('#nama_role').val('');
    })

    $('#formRole').submit(function(e){
        e.preventDefault();
        var nama = $('#nama_role').val();
        var role_id = $('#role_id').val();
        var operation = $('#operation').val();
        if (nama != '') {
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{nama:nama,role_id:role_id,operation:operation},
                url:'doRole',
                success:function(result){
                    Swal.fire({
                        icon:'success',
                        title: 'Sukses di '+operation+' !',
                        timer: 2000,
                        timerProgressBar: true,
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            $('#tableRole').DataTable.ajax.reload();
                        }else if(result.isConfirmed){
                            $('#tableRole').DataTable.ajax.reload();
                        }
                    })
                }
            })
        }else{
            Toast.fire({
                icon: 'error',
                title: 'Semua field harus diisi !'
            })
        }
    })

    //event each button edit
    $(document).on('click','.update',function(){
        var ids = $(this).attr("id");
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:ids},
            url:'roleById',
            success:function(result){
                $('#addRoleModal').modal('show');
                $('#role_id').val(ids);
                $('#action').val('Edit');
                $('#operation').val('Edit');
                $('#nama_role').val(result.nama);
            }
        })
    })

    // event each button delete
    $(document).on('click','.delete',function(){
        var ids = $(this).attr("id");
        Swal.fire({
            title: 'Yakin untuk dihapus ?',
            text: "Data akan permanen dihapus !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method:'POST',
                    dataType:'JSON',
                    data:{id:ids},
                    url:'deleteRole',
                    success:function()
                    {
                        Swal.fire({
                            icon:'success',
                            title: 'Sukses di Hapus !',
                            timer: 2000,
                            timerProgressBar: true,
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                $('#tableRole').DataTable.ajax.reload();
                            }else if(result.isConfirmed){
                                $('#tableRole').DataTable.ajax.reload();
                            }
                        })
                    }
                })
            }
        })
    })

})