$(function(){
    $('#pengaturan').attr('class','nav-item has-treeview menu-open');
    $('#users-page').attr('class','nav-link active bg-success');
    $('#tableUsers').DataTable({
        "processing": true,
        "serverSide": true, 
        "order":[],
        "ajax":{
            url:"userLists",
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

    // action form
    $('#formUsers').submit(function(e){
        e.preventDefault();
        var nip = $('#nip').val();
        var nama = $('#nama').val();
        var email = $('#email').val();
        var no_hp = $('#no_hp').val();
        var jabatan = $('#jabatan').val();
        var role = $('#role_user').val();
        var user_id = $('#user_id').val();
        var operation = $('#operation').val();
        if (nip != '' && nama != '' && email != '' && no_hp !='' && jabatan != '') {
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{nip:nip,nama:nama,email:email,no_hp:no_hp,jabatan:jabatan,role:role,user_id:user_id,operation:operation},
                url:'doUser',
                success:function(result){
                    Swal.fire({
                        icon:'success',
                        title: 'Sukses di '+operation+' !',
                        timer: 2000,
                        timerProgressBar: true,
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            $('#tableUsers').DataTable().ajax.reload();
                        }else if(result.isConfirmed){
                            $('#tableUsers').DataTable().ajax.reload();
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

    // ambil role
    $.ajax({
        method:'GET',
        dataType:'JSON',
        url:'getRole',
        success:function(result){
            var html='';
            var i=0;
            for(i; i<result.length; i++){
                html += "<option value='"+result[i].id+"'>"+result[i].nama_role+"</option>";
            }
            $('#role_user').html(html);
        }
    })

    // event each button ganti status
    $(document).on('click','.status',function(){
        var ids = $(this).attr("id");
        var status = $(this).attr('data-stat');
        Swal.fire({
            title: 'Ganti status user ?',
            text: "Status akan terganti !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ganti!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method:'POST',
                    // dataType:'JSON',
                    data:{id:ids,status:status},
                    url:'changeStatusUser',
                    success:function(){
                        Swal.fire({
                            icon:'success',
                            title: 'Sukses di Ganti !',
                            timer: 2000,
                            timerProgressBar: true,
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                $('#tableUsers').DataTable().ajax.reload();
                            }else if(result.isConfirmed){
                                $('#tableUsers').DataTable().ajax.reload();
                            }
                        })
                    }
                })
            }
        })
    })

    //event each button edit
    $(document).on('click','.update',function(){
        var ids = $(this).attr("id");
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:ids},
            url:'userById',
            success:function(result){
                $('#addUsersModal').modal('show');
                $('#user_id').val(ids);
                $('#action').val('Edit');
                $('#operation').val('Edit');
                $('#nip').val(result.nip);
                $('#nama').val(result.nama);
                $('#email').val(result.email);
                $('#no_hp').val(result.no_hp);
                $('#jabatan').val(result.jabatan);
                $('#role_user').val(result.role);
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
                    // dataType:'JSON',
                    data:{id:ids},
                    url:'deleteUser',
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
                                $('#tableUsers').DataTable().ajax.reload();
                            }else if(result.isConfirmed){
                                $('#tableUsers').DataTable().ajax.reload();;
                            }
                        })
                    }
                })
            }
        })
    })

})