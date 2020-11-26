$(function(){
    getPPTK();
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 6000
    });
    function getPPTK(){
        var role = 2;
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{role:role},
            url:'getUserByRole',
            success:function(result)
            {
                var html = '';
                var i = 0;
                if (result.length > 0) {
                    for(i; i<result.length; i++)
                    {
                        html += '<option>PILIH</option>';
                        html += '<option value="'+result[i].id+'">'+result[i].nama+'</option>';
                    }
                    $('#nama_pengusul').html(html);
                }else{
                    html += '<option value="0">User PPTK Belum Tersedia </option>';
                    $('#formKegiatan').hide();
                    $('#nama_pengusul').html(html);
                    $('#nama_pengusul').attr('disabled','disabled');
                    Toast.fire({
                        icon: 'error',
                        title: 'User PPTK Belum tersedia, Silahkan tambahkan user PPTK terlebih dahulu ... '
                    })
                }
            }
        })
    }

    $('#nama_pengusul').change(function(){
        var id = $('#nama_pengusul').val();
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:id},
            url:'userById',
            success:function(result){
                $('#nip').val(result.nip);
            }
        })
    })

    $('#formKegiatan').submit(function(e){
        e.preventDefault();
        var biro = $('#biro').val();
        var bagian = $('#bagian').val();
        var sub_bagian = $('#sub_bagian').val();
        var lokasi = $('#lokasi').val();
        var program = $('#program').val();
        var kegiatan = $('#kegiatan').val();
        var sub_kegiatan = $('#sub_kegiatan').val();
        var anggaran = $('#anggaran').val();
        var apbd_murni = $('#apbd_murni').val();
        var apbd_perubahan = $('#apbd_perubahan').val();
        var tanggal_pengisian = $('#tanggal_pengisian').val();
        var sifat_kegiatan = $('#sifat_kegiatan').val();
        var nama_pengusul = $('#nama_pengusul').val();
        var nip = $('#nip').val();
        var latar_belakang = $('#latar_belakang').val();
        var maksud_tujuan = $('#maksud_tujuan').val();
        var sasaran = $('#sasaran').val();
        var operation = $('#operation').val();
        var kegiatan_id = $('#kegiatan_id').val();

        if (biro != '' && bagian !='' && sub_bagian !='' && lokasi !='' && program !='' && kegiatan !='' && sub_kegiatan !='' && anggaran !='' && apbd_murni !='' && apbd_perubahan !='' && tanggal_pengisian !='' && sifat_kegiatan !='' && nama_pengusul != '' && nip !='' && latar_belakang != '' && maksud_tujuan != '' && sasaran != '') {
            if (nama_pengusul != 'PILIH' || nama_pengusul !=0 ) {
                $.ajax({
                    method:'POST',
                    // dataType:'JSON',
                    data:{biro:biro,bagian:bagian,sub_bagian:sub_bagian,lokasi:lokasi,program:program,kegiatan:kegiatan,sub_kegiatan:sub_kegiatan,anggaran:anggaran,apbd_murni:apbd_murni,apbd_perubahan:apbd_perubahan,tanggal_pengisian:tanggal_pengisian,sifat_kegiatan:sifat_kegiatan,nama_pengusul:nama_pengusul,nip:nip,latar_belakang:latar_belakang,maksud_tujuan:maksud_tujuan,sasaran:sasaran,operation:operation,kegiatan_id:kegiatan_id},
                    url:'addKegiatan',
                    success:function(result){
                        Swal.fire({
                            icon:'success',
                            title: 'Kegiatan sukses ditambah !',
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
                    title: 'Nama pengusul harus dipilih !'
                })
            }
        }else{
            Toast.fire({
                icon: 'error',
                title: 'Semua field harus diisi .. !'
            })
        }
    })

    // datatables
    $('#tableKegiatan').DataTable({
        "processing": false,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"kegiatanLists",
            type:"post",
        },
        "columnDefs":[
            {
                "targets":[0,2,3,4],
                "orderable":false,
            },
        ],
    });

    // event each button detail
    $(document).on('click','.detail',function(){
        var id = $(this).attr('id');
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:id},
            url:'kegiatanById',
            success:function(result){
                $('#detailModal').modal('show');
                var html ='';
                html += '<table class="table table-borderless">';
                html += '<tr>';
                html += '<td><strong>PD/BIRO</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.biro+'</td>';
                html += '<td><strong>Anggaran</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.anggaran+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Bagian</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.bagian+'</td>';
                html += '<td><strong>APBD Murni</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.apbd_murni+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Sub Bagian</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.sub_bagian+'</td>';
                html += '<td><strong>APBD Perubahan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.apbd_perubahan+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Lokasi</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.lokasi+'</td>';
                html += '<td><strong>Tanggal Pengisian</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.tanggal+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Program</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.program+'</td>';
                html += '<td><strong>Sifat Kegiatan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.sifat_kegiatan+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Kegiatan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.kegiatan+'</td>';
                html += '<td><strong>Nama Pengusul</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.nama_pengusul+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Sub Kegiatan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.sub_kegiatan+'</td>';
                html += '<td><strong>NIP</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.nip+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Latar Belakang</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td colspan="4">'+result.latar_belakang+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Maksud & Tujuan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td colspan="4">'+result.maksud_tujuan+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Sasaran</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td colspan="4">'+result.sasaran+'</td>';
                html += '</tr>';
                $('#detailKegiatan').html(html);
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
            url:'kegiatanById',
            success:function(result){
                $('#addKegiatanModal').modal('show');
                $('#kegiatan_id').val(ids);
                $('#action').val('Edit');
                $('#operation').val('Edit');
                $('#biro').val(result.biro);
                $('#bagian').val(result.bagian);
                $('#sub_bagian').val(result.sub_bagian);
                $('#lokasi').val(result.lokasi);
                $('#program').val(result.program);
                $('#kegiatan').val(result.kegiatan);
                $('#sub_kegiatan').val(result.sub_kegiatan);
                $('#anggaran').val(result.anggaran);
                $('#apbd_murni').val(result.apbd_murni);
                $('#apbd_perubahan').val(result.apbd_perubahan);
                $('#tanggal_pengisian').val(result.tanggal);
                $('#sifat_kegiatan').val(result.sifat_kegiatan);
                $('#nama_pengusul').val(result.nama_pengusul);
                $('#nip').val(result.nip);
                $('#latar_belakang').val(result.latar_belakang);
                $('#maksud_tujuan').val(result.maksud_tujuan);
                $('#sasaran').val(result.sasaran);
            }
        })
    })

    //event each button delete 
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
                    url:'deleteKegiatan',
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
})