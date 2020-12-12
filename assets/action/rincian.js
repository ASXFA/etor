$(function(){
    $('#kegiatan-saya').attr('class','nav-link active');
    $('#data-master').attr('class','nav-item has-treeview menu-open');
    $('#a-data-master').attr('class','nav-link active');
    var id_global_tipe_belanja = $('#id_tipe_belanja_global').val();
    $('#tableRincian').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"../rincianLists/"+id_global_tipe_belanja,
            type:"post",
        },
        "columnDefs":[
            {
                "targets":[-1],
                "orderable":false,
            },
        ],
    });

    $('#btnTambahRincian').click(function(){
        $('#tambahRincianModal').modal('show');
        $('#operation_rincian').val('Tambah');
        $('#deskripsi').val('');
        $('#jumlah1').val(0);
        $('#satuan1').val('');
        $('#jumlah2').val(0);
        $('#satuan2').val('');
        $('#jumlah3').val(0);
        $('#satuan3').val('');
        $('#jumlah4').val(0);
        $('#satuan4').val('');
        $('#satuan').val('');
        $('#harga').val(0);
        $('#ppn').val(0);
        $('#total_rincian').val(0);
        $('#total_rincian_old').val(0);
        $('#id_rincian').val('');
    });

    $(document).on('click','.editRincian',function(){
        var id = $(this).attr('id');
        $('#tambahRincianModal').modal('show');
        $('#operation_rincian').val('Edit');
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:id},
            url:'../rincianById',
            success:function(result){
                $('#deskripsi').val(result.deskripsi);
                $('#jumlah1').val(result.jumlah1);
                $('#satuan1').val(result.satuan1);
                $('#jumlah2').val(result.jumlah2);
                $('#satuan2').val(result.satuan2);
                $('#jumlah3').val(result.jumlah3);
                $('#satuan3').val(result.satuan3);
                $('#jumlah4').val(result.jumlah4);
                $('#satuan4').val(result.satuan4);
                $('#satuan').val(result.satuan);
                $('#harga').val(result.harga);
                $('#ppn').val(result.ppn);
                $('#total_rincian').val(result.total_rincian);
                $('#total_rincian_old').val(result.total_rincian);
                $('#id_rincian').val(id);
            }
        })
    })

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });


    $('#jumlah1').change(function(){
        var jumlah1 = $('#jumlah1').val();
        var harga = $('#harga').val();
        if (jumlah1 == 0) {
            var count = jumlah1 * harga;    
        }else{
            var count = jumlah1 * harga;
        }
        $('#jumlah2').removeAttr('disabled','disabled');
        $('#satuan2').removeAttr('disabled','disabled');
        $('#total_rincian').val(count);
    })
    $('#jumlah2').change(function(){
        var jumlah1 = $('#jumlah1').val();
        var jumlah2 = $('#jumlah2').val();
        var harga = $('#harga').val();
        if (jumlah2 == 0) {
            var countJmlh = jumlah1;
        }else{
            var countJmlh = jumlah1 * jumlah2;
        }
        $('#jumlah3').removeAttr('disabled','disabled');
        $('#satuan3').removeAttr('disabled','disabled');
        if (jumlah2 == 0) {
            $('#jumlah3').attr('disabled','disabled');
            $('#satuan3').attr('disabled','disabled');
        }
        var count = countJmlh * harga;
        $('#total_rincian').val(count);
    })
    $('#jumlah3').change(function(){
        var jumlah1 = $('#jumlah1').val();
        var jumlah2 = $('#jumlah2').val();
        var jumlah3 = $('#jumlah3').val();
        var harga = $('#harga').val();
        if (jumlah3 == 0) {
            var countJmlh = jumlah1 * jumlah2;
        }else{
            var countJmlh = jumlah1 * jumlah2 * jumlah3;
        }
        $('#jumlah4').removeAttr('disabled','disabled');
        $('#satuan4').removeAttr('disabled','disabled');
        if (jumlah3 == 0) {
            $('#jumlah4').attr('disabled','disabled');
            $('#satuan4').attr('disabled','disabled');
        }
        var count = countJmlh * harga;
        $('#total_rincian').val(count);
    })

    $('#jumlah4').change(function(){
        var jumlah1 = $('#jumlah1').val();
        var jumlah2 = $('#jumlah2').val();
        var jumlah3 = $('#jumlah3').val();
        var jumlah4 = $('#jumlah4').val();
        var harga = $('#harga').val();
        if (jumlah4 == 0) {
            var countJmlh = jumlah1 * jumlah2 * jumlah3;
        }else{
            var countJmlh = jumlah1 * jumlah2 * jumlah3 * jumlah4;
        }
        var count = countJmlh * harga;
        $('#total_rincian').val(count);
    })


    $('#harga').keyup(function(){
        var jumlah1 = $('#jumlah1').val();
        var jumlah2 = $('#jumlah2').val();
        var jumlah3 = $('#jumlah3').val();
        var jumlah4 = $('#jumlah4').val();

        if (jumlah1 != 0) {
            var countJmlh = jumlah1;
        }
        if (jumlah2 != 0) {
            var countJmlh = jumlah1 * jumlah2;
        }
        if (jumlah3 != 0) {
            var countJmlh = jumlah1 * jumlah2 * jumlah3;
        }
        if (jumlah4 != 0) {
            var countJmlh = jumlah1 * jumlah2 * jumlah3 * jumlah4;
        }

        var harga = $('#harga').val();
        var count = countJmlh * harga;
        $('#total_rincian').val(count);
    })
    

    $('#btnTambahRincianModal').click(function(){
        var deskripsi = $('#deskripsi').val();
        var jumlah1 = $('#jumlah1').val();
        var jumlah2 = $('#jumlah2').val();
        var jumlah3 = $('#jumlah3').val();
        var jumlah4 = $('#jumlah4').val();
        var satuan1 = $('#satuan1').val();
        var satuan2 = $('#satuan2').val();
        var satuan3 = $('#satuan3').val();
        var satuan4 = $('#satuan4').val();
        var satuan = $('#satuan').val();
        var harga = $('#harga').val();
        var ppn = $('#ppn').val();
        var total = $('#total_rincian').val();
        var id_kegiatan_tipe_belanja = $('#id_kegiatan_tipe_belanja').val();
        var id_tipe_belanja = $('#id_tipe_belanja').val();
        var operation_rincian = $('#operation_rincian').val();
        var id_rincian = $('#id_rincian').val(); 
        var total_rincian_old = $('#total_rincian_old').val();
        
        if (deskripsi == '' && jumlah1 == 0 && satuan1 == '' && satuan == '' && harga==0) {
            Toast.fire({
                icon: 'error',
                title: 'Field dengan tanda * harus diisi !'
            });
        }else{
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{id_tipe_belanja:id_tipe_belanja,deskripsi:deskripsi,jumlah1:jumlah1,jumlah2:jumlah2,jumlah3:jumlah3,jumlah4:jumlah4, satuan1:satuan1,satuan2:satuan2,satuan3:satuan3,satuan4:satuan4,satuan:satuan,harga:harga,ppn:ppn,total:total,operation_rincian:operation_rincian,id_rincian:id_rincian},
                url:'../doRincian',
                success:function(results){
                    Swal.fire({
                        icon:'success',
                        title: 'Sukses di '+operation_rincian+' !',
                        timer: 2000,
                        timerProgressBar: true,
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            editAnggaranTipeBelanja(id_tipe_belanja,total,total_rincian_old);
                            editAnggaranKegiatan(id_kegiatan_tipe_belanja,total,total_rincian_old);
                            location.reload();
                        }else if(result.isConfirmed){
                            editAnggaranTipeBelanja(id_tipe_belanja,total,total_rincian_old);
                            editAnggaranKegiatan(id_kegiatan_tipe_belanja,total,total_rincian_old);
                            location.reload();
                        }
                    })
                }
            })
        }
    })

    function editAnggaranTipeBelanja(id_tipe_belanja,total_rincian,total_rincian_old)
    {
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id_tipe_belanja:id_tipe_belanja,total_rincian:total_rincian,total_rincian_old:total_rincian_old},
            url:'../editAnggaranTipeBelanja',
            success:function(result){
                
            }
        })
    }

    function editAnggaranKegiatan(id_kegiatan,total_rincian,total_rincian_old)
    {
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id_kegiatan:id_kegiatan,total_rincian:total_rincian,total_rincian_old:total_rincian_old},
            url:'../editAnggaranKegiatan',
            success:function(result){

            }
        })
    }

    $(document).on('click','.editTelaahan',function(){
        $('#telaahanRincianModal').modal('show');
        var id_rincian = $(this).attr('id');
        $('#id_rincian_telaahan').val(id_rincian);
    })
    $(document).on('click','.editRekomendasi',function(){
        $('#rekomendasiRincianModal').modal('show');
        var id_rincian = $(this).attr('id');
        $('#id_rincian_rekomendasi').val(id_rincian);
    })
    $(document).on('click','.hapusRincian',function(){
        var id = $(this).attr('id');
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
                    data:{id:id},
                    url:'../deleteRincian',
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

    $(document).on('click','.changeStatus',function(){
        var id_rincian = $(this).attr('id');
        var status = $(this).attr('data-status');
        Swal.fire({
            title: 'Yakin untuk Ganti ?',
            text: "anda akan mengganti status rincian tersebut !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method:'POST',
                    dataType:'JSON',
                    data:{id_rincian:id_rincian,status:status},
                    url:'../changeStatus',
                    success:function(result){
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

    $('#btnTambahTelaahanRincianModal').click(function(){
        var telaahan = $('#telaahan_form').val();
        var id_rincian_telaahan = $('#id_rincian_telaahan').val();
        if (telaahan != '') {
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{id_rincian_telaahan:id_rincian_telaahan, telaahan:telaahan},
                url:'../addTelaahanRincian',
                success:function(results){
                    Swal.fire({
                        icon:'success',
                        title: 'Sukses di Telaah !',
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
        }else{
            Toast.fire({
                icon: 'error',
                title: 'Field telaah harus diisi !'
            });
        }
    })
    $('#btnTambahRekomendasiRincianModal').click(function(){
        var rekomendasi = $('#rekomendasi_form').val();
        var id_rincian_rekomendasi = $('#id_rincian_rekomendasi').val();
        if (rekomendasi != '') {
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{id_rincian_rekomendasi:id_rincian_rekomendasi, rekomendasi:rekomendasi},
                url:'../addRekomendasiRincian',
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
        }else{
            Toast.fire({
                icon: 'error',
                title: 'Field telaah harus diisi !'
            });
        }
    })

})