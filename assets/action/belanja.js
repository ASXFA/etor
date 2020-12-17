$(function(){
    $('#kegiatan').attr('class','nav-link active');
    $('#sub-kegiatan').attr('class','nav-link active');
    var id_kegiatan_global = $('#id_kegiatan_global').val();
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    // datatables list kegiatan saya 
    $('#tableTipeBelanja').DataTable({
        "processing": false,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"../tipeBelanjaList/"+id_kegiatan_global,
            type:"post",
        },
        "columnDefs":[
            {
                "targets":[-1],
                "orderable":false,
                "pageLength" : 5,
                "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]]
            },
        ],
    });

    $('#btnTambahUsulanAnggaran').click(function(){
        $('#tambahUsulanAnggaranModal').modal('show');
        $('#operation_belanja').val('Tambah');
        $('#tipe_belanja').val('');
        $('#tipe_belanja_sub').val('');
        $('#tipe_belanja_sub_sub').val('');
        $('#tipe_belanja_sub_sub_sub').val('');
        $('#judul_pengajuan').val('');
        $('#tipe_anggaran').prop('selected',function(){
            return this.defaultSelected;
        });
        getK(); 
    })
    
    function getK()
    {
        $.ajax({
            method:'GET',
            dataType:'JSON',
            async:'FALSE',
            url:'../getK',
            success:function(result){
                var html='';
                var i=0;
                html += "<option hidden>PILIH</option>";
                for(i; i<result.length; i++){
                    html += "<option value='"+result[i].ALL_90_M+"'>"+result[i].URAIAN_90_M+"</option>";
                }
                $('#tipe_belanja-1').html(html);
            }
        })
    }

    function getJ(K)
    {
        $.ajax({
            method:'POST',
            dataType:'JSON',
            async:'FALSE',
            data:{K:K},
            url:'../getJ',
            success:function(result){
                var html='';
                var i=0;
                html += "<option hidden>PILIH</option>";
                for(i; i<result.length; i++){
                    html += "<option value='"+result[i].ALL_90_M+"'>"+result[i].URAIAN_90_M+"</option>";
                }
                $('#tipe_belanja').html(html);
            }
        })
    }
    
    
    function getO(K,J)
    {
        $.ajax({
            method:'POST',
            dataType:'JSON',
            async:'FALSE',
            data:{K:K,J:J},
            url:'../getO',
            success:function(result){
                var html='';
                var i=0;
                html += "<option hidden>PILIH</option>";
                for(i; i<result.length; i++){
                    html += "<option value='"+result[i].ALL_90_M+"'>"+result[i].URAIAN_90_M+"</option>";
                }
                $('#tipe_belanja_sub').html(html);
            }
        })
    }

    function getRO(K,J,O)
    {
        $.ajax({
            method:'POST',
            dataType:'JSON',
            async:'FALSE',
            data:{K:K,J:J,O:O},
            url:'../getRO',
            success:function(result){
                var html='';
                var i=0;
                html += "<option hidden>PILIH</option>";
                for(i; i<result.length; i++){
                    html += "<option value='"+result[i].ALL_90_M+"'>"+result[i].URAIAN_90_M+"</option>";
                }
                $('#tipe_belanja_sub_sub').html(html);
            }
        })
    }
    
    function getSRO(K,J,O,RO)
    {
        $.ajax({
            method:'POST',
            dataType:'JSON',
            async:'FALSE',
            data:{K:K,J:J,O:O,RO:RO},
            url:'../getSRO',
            success:function(result){
                var html='';
                var i=0;
                html += "<option hidden>PILIH</option>";
                for(i; i<result.length; i++){
                    html += "<option value='"+result[i].ALL_90_M+"'>"+result[i].URAIAN_90_M+"</option>";
                }
                $('#tipe_belanja_sub_sub_sub').html(html);
            }
        })
    }
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 6000
    });
    $('#tambahTipeBelanja').click(function(){
        var id_kegiatan_anggaran = $('#id_kegiatan_belanja').val();
        var id_belanja = $('#id_belanja').val();
        var operation = $('#operation_belanja').val();
        var tipe_belanja = $('#tipe_belanja').val();
        var tipe_belanja_sub = $('#tipe_belanja_sub').val();
        var tipe_belanja_sub_sub = $('#tipe_belanja_sub_sub').val();
        var tipe_belanja_sub_sub_sub = $('#tipe_belanja_sub_sub_sub').val();
        var judul_pengajuan = $('#judul_pengajuan').val();
        var tipe_anggaran = $('#tipe_anggaran').val();

        if (tipe_anggaran == 'PILIH') {
            Toast.fire({
                icon: 'error',
                title: 'Tipe Anggaran harus dipilih !'
            })
        }else{
            $.ajax({
                method:'POST',
                dataType:'JSON',
                async:'FALSE',
                data:{id_kegiatan_anggaran:id_kegiatan_anggaran,id_belanja:id_belanja,tipe_belanja:tipe_belanja,tipe_belanja_sub:tipe_belanja_sub,tipe_belanja_sub_sub:tipe_belanja_sub_sub,tipe_belanja_sub_sub_sub:tipe_belanja_sub_sub_sub,judul_pengajuan:judul_pengajuan,tipe_anggaran:tipe_anggaran,operation:operation},
                url:'../doTipeBelanja',
                success:function(){
                    Swal.fire({
                        icon:'success',
                        title: 'Sukses !',
                        timer: 2000,
                        timerProgressBar: true,
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            location.reload();
                        }else if(result.isConfirmed){
                            location.reload();
                        }
                    })
                }
            })
        }
    })
    
    $(document).on('click','.editTipeBelanja',function(){
        var id = $(this).attr('id');
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:id},
            url:'../detailEditTipe',
            success:function(result){
                $('#tambahUsulanAnggaranModal').modal('show');
                $('#operation_belanja').val('Edit');
                // getJ();
                $('#judul_pengajuan').val(result.judul_pengajuan);
                $('#tipe_anggaran').val(result.tipe_anggaran);
                $('#tipe_belanja').val(result.kodering1).trigger('change');
                $('#tipe_belanja_sub').val(result.kodering2).trigger('change');
                $('#tipe_belanja_sub_sub').val(result.kodering3).trigger('change');
                $('#tipe_belanja_sub_sub_sub').val(result.kodering4).trigger('change');
            }
        })
    })
    $('#tipe_belanja-1').change(function(){
        var kode = $('#tipe_belanja-1').val();
        var K = kode.slice(2,3);
        getJ(K);
    })
    $('#tipe_belanja').change(function(){
        var kode = $('#tipe_belanja').val();
        var K = kode.slice(2,3);
        var J = kode.slice(4,6);
        getO(K,J);
    })

    $('#tipe_belanja_sub').change(function(){
        var kode = $('#tipe_belanja_sub').val();
        var K = kode.slice(2,3);
        var J = kode.slice(4,6);
        var O = kode.slice(7,9);
        getRO(K,J,O);
    })

    $('#tipe_belanja_sub_sub').change(function(){
        var kode = $('#tipe_belanja_sub_sub').val();
        var K = kode.slice(2,3);
        var J = kode.slice(4,6);
        var O = kode.slice(7,9);
        var RO = kode.slice(10,12);
        getSRO(K,J,O,RO);
    })

    $(document).on('click','.deleteTipeBelanja',function(){
        var id = $(this).attr('id');
        Swal.fire({
            title: 'Yakin Hapus Tipe Belanja ini ?',
            text: "Semua anggaran yang diusulkan pada tipe belanja ini akan terhapus permanen !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method:'POST',
                    // dataType:'JSON',
                    data:{id:id},
                    url:'../deleteTipeBelanja',
                    success:function(){
                        Swal.fire({
                            icon:'success',
                            title: 'Sukses di Ganti !',
                            timer: 2000,
                            timerProgressBar: true,
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                location.reload();
                            }else if(result.isConfirmed){
                                location.reload();
                            }
                        })
                    }
                })
            }
        })
    })
})