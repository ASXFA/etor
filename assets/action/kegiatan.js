$(function(){
    $('#kegiatan-saya').attr('class','nav-link active');
    $('#data-master').attr('class','nav-item has-treeview menu-open');
    $('#a-data-master').attr('class','nav-link active');
    // $('#kegiatan').attr('class','nav-link active bg-success');
    // $('#data_upload > a').attr('class','nav-link active');
    // $('#uph > i').attr('class','far fa-circle nav-icon text-danger');
    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });
    $('.select2bs41').select2({
        theme: 'bootstrap4'
    });

    semuaAnggaran();

    function semuaAnggaran()
    {
        $.ajax({
            method:'GET',
            dataType:'JSON',
            url:'listSemuaAnggaranKegiatan',
            success:function(result){
                var html = '';
                html += '<tr>';
                html += '<td>'+result.biro+'</td>';
                html += '<td>'+result.jumlah_kegiatan+'</td>';
                html += '<td>'+result.jumlah_sub_kegiatan+'</td>';
                html += '<td>'+result.jumlah_anggaran+'</td>';
                html += '<td width="8%" class="text-center">'+result.button+'</td>';
                html += '</tr>';
                $('#listSemuaAnggaran').html(html);
            }
        })
    }

    getPPTK();
    getBagian();
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
                    html += '<option>PILIH</option>';
                    for(i; i<result.length; i++)
                    {
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

    $('#bagian').change(function(){
        var id_bagian = $('#bagian').val();
        getSubBagian(id_bagian);
    });

    function getBagian()
    {
        $.ajax({
            method:'GET',
            dataType:'JSON',
            url:'getBagian',
            success:function(result){
                var html ='';
                var i=0;
                html += "<option hidden> PILIH </option>";
                for(i; i<result.length; i++){
                    html += "<option value='"+result[i].id+"'>"+result[i].nama_bagian+"</option>";
                }
                $('#bagian').html(html);
            }
        })
    }

    function getSubBagian(id_bagian,id_sub='')
    {
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:id_bagian},
            url:'getSubByIdBagian',
            success:function(results){
                var html ='';
                var j=0;
                for(j; j<results.length; j++){
                    if (id_sub != '') {
                        if (results[j].id == id_sub) {
                            html += "<option value='"+results[j].id+"' selected>"+results[j].nama_sub_bagian+"</option>";
                        }else{
                            html += "<option value='"+results[j].id+"'>"+results[j].nama_sub_bagian+"</option>";
                        }
                    }else{
                        html += "<option value='"+results[j].id+"'>"+results[j].nama_sub_bagian+"</option>";
                    }
                }
                $('#sub_bagian').html(html);
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
        var tanggal_pengusulan = $('#tanggal_pengusulan').val();
        // var sifat_kegiatan = $('#sifat_kegiatan').val();
        var nama_pengusul = $('#nama_pengusul').val();
        var nip = $('#nip').val();
        var latar_belakang = $('#latar_belakang').val();
        var maksud_tujuan = $('#maksud_tujuan').val();
        var sasaran = $('#sasaran').val();
        var operation = $('#operation').val();
        var kegiatan_id = $('#kegiatan_id').val();

        if (biro != '' && bagian !='' && sub_bagian !='' && lokasi !='' && program !='' && kegiatan !='' && sub_kegiatan !='' && anggaran !='' && apbd_murni !='' && apbd_perubahan !='' && tanggal_pengusulan !='' && nama_pengusul != '' && nip !='' && latar_belakang != '' && maksud_tujuan != '' && sasaran != '') {
            if ((nama_pengusul != 'PILIH' || nama_pengusul !=0) && bagian != 'PILIH' && sub_bagian != 'PILIH' ) {
                $.ajax({
                    method:'POST',
                    // dataType:'JSON',
                    data:{biro:biro,bagian:bagian,sub_bagian:sub_bagian,lokasi:lokasi,program:program,kegiatan:kegiatan,sub_kegiatan:sub_kegiatan,anggaran:anggaran,apbd_murni:apbd_murni,apbd_perubahan:apbd_perubahan,tanggal_pengusulan:tanggal_pengusulan,nama_pengusul:nama_pengusul,nip:nip,latar_belakang:latar_belakang,maksud_tujuan:maksud_tujuan,sasaran:sasaran,operation:operation,kegiatan_id:kegiatan_id},
                    url:'addKegiatan',
                    success:function(result){
                        Swal.fire({
                            icon:'success',
                            title: 'Kegiatan sukses di'+operation+' !',
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

    // datatables list Kegiatan
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
                "targets":[-1],
                "orderable":false,
            },
        ],
    });

    // datatables list kegiatan saya 
    $('#tableKegiatanSaya').DataTable({
        "processing": false,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"kegiatanSayaLists",
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

    $(document).on('click','.delegasi',function(){
        var id_kegiatan = $(this).attr('id');
        $.ajax({
            method:"POST",
            dataType:"JSON",
            data:{id:id_kegiatan},
            url:'kegiatanById',
            success:function(result){
                // if (result.nama_pemegang_kegiatan == "") {
                // }else{
                //     getPemegangKegiatan();
                //     $('#nama_pemegang_kegiatan').val(result.nama_pemegang_kegiatan);
                //     $('#id_kegiatan').val(id_kegiatan);
                // }
                getPemegangKegiatan();
                $('#id_kegiatan').val(id_kegiatan);
                $('#delegasiModal').modal('show');
            }
        })
    })

    function getPemegangKegiatan()
    {
        var role = 3;
        $.ajax({
            method:"POST",
            dataType:"JSON",
            data:{role:role},
            url:'getUserByRole',
            success:function(result){
                var html = '';
                var i =0;
                for(i;i<result.length;i++){
                    html +="<option value='"+result[i].id+"'>"+result[i].nama+"</option>";
                }
                $('#nama_pemegang_kegiatan').html(html);
            }
        })
    }

    $('#delegasiForm').submit(function(){
        var nama_pemegang_kegiatan = $('#nama_pemegang_kegiatan').val();
        var id_kegiatan = $('#id_kegiatan').val();
        if (nama_pemegang_kegiatan != '') {
            $.ajax({
                method:'POST',
                // dataType:'JSON',
                data:{nama_pemegang_kegiatan:nama_pemegang_kegiatan,id_kegiatan:id_kegiatan},
                url:'doPemegangKegiatan',
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
                html += '<td><strong>BIRO</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.biro+'</td>';
                html += '<td><strong>Anggaran Sub Kegiatan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.anggaran+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Bagian</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.bagian+'</td>';
                html += '<tr>';
                html += '<td><strong>Sub Bagian</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.sub_bagian+'</td>';
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
                html += '<td><strong>Kegiatan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.kegiatan+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Nama Pengusul</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.nama_pengusul+'</td>';
                html += '<td><strong>Sub Kegiatan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.sub_kegiatan+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>NIP</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.nip+'</td>';
                html += '<td><strong>Nama Pemegang Kegiatan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.nama_pemegang_kegiatan+'</td>';
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

    $('#tambahPenyediaModal').hide();
    $(document).on('click','.tampilkan',function(){
        var id = $(this).attr('id');
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:id},
            url:'kegiatanById',
            success:function(result){
                $('#tambahPenyediaModal').show();
                $('#tambahPenyediaModal').attr('data-id',id);
                var html ='';
                html += '<table class="table table-borderless">';
                html += '<tr>';
                html += '<td width="15%"><strong>BIRO</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.biro+'</td>';
                html += '<td><strong>Anggaran Sub Kegiatan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.anggaran+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Bagian</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.bagian+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Sub Bagian</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.sub_bagian+'</td>';
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
                html += '<td><strong>Kegiatan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.kegiatan+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Nama Pengusul</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.nama_pengusul+'</td>';
                html += '<td><strong>Sub Kegiatan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.sub_kegiatan+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>NIP</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.nip+'</td>';
                html += '<td><strong>Nama Pemegang Kegiatan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td>'+result.nama_pemegang_kegiatan+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Latar Belakang</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td colspan="4" class="text-justify">'+result.latar_belakang+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Maksud & Tujuan</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td colspan="4" class="text-justify">'+result.maksud_tujuan+'</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<td><strong>Sasaran</strong></td>';
                html += '<td><strong> : </strong>';
                html += '<td colspan="4" class="text-justify">'+result.sasaran+'</td>';
                html += '</tr>';
                $('#infoKegiatan').html(html);
            }
        })
    })

    // event modal add Penyedia paket
    $('#tambahPenyediaModal').click(function(){
        $('#addPenyediaModal').modal('show');
        $('#id_kegiatan_paket').val($('#tambahPenyediaModal').attr('data-id'));
    })

    //event each button edit
    $(document).on('click','.update',function(){
        var ids = $(this).attr("id");
        var type = 'Edit';
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:ids,type:type},
            url:'kegiatanById',
            success:function(result){
                $('#addKegiatanModal').modal('show');
                $('#kegiatan_id').val(ids);
                $('#action').val('Edit');
                $('#operation').val('Edit');
                $('#biro').val(result.biro);
                $('#bagian').val(result.bagian);
                $('#bagian').trigger('change');
                // $('#')
                getSubBagian(result.bagian,result.sub_bagian);
                $('#sub_bagian').trigger('change');
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

    $('#formIndikator').submit(function(){
        // indikator
        var indikator1 = $('#indikator1').val();
        var indikator2 = $('#indikator2').val();
        var indikator3 = $('#indikator3').val();
        var indikator4 = $('#indikator4').val();

        // tolak ukur kinerja
        var tolak_ukur_kinerja1 = $('#tolak_ukur_kinerja1').val();
        var tolak_ukur_kinerja2 = $('#tolak_ukur_kinerja2').val();
        var tolak_ukur_kinerja3 = $('#tolak_ukur_kinerja3').val();
        var tolak_ukur_kinerja4 = $('#tolak_ukur_kinerja4').val();

        // target kinerja
        var target_kinerja1 = $('#target_kinerja1').val();
        var target_kinerja2 = $('#target_kinerja2').val();
        var target_kinerja3 = $('#target_kinerja3').val();
        var target_kinerja4 = $('#target_kinerja4').val();

        console.log(indikator3);

        if (indikator1 == '' && indikator2 == '' && indikator3 == '' && indikator3 == '' && indikator4 =='') {
            Toast.fire({
                icon: 'error',
                title: 'Semua indikator Harus Diisi !'
            })
        }else if(tolak_ukur_kinerja1 == '' && tolak_ukur_kinerja2 =='' && tolak_ukur_kinerja3 =='' & tolak_ukur_kinerja4 == ''){
            Toast.fire({
                icon: 'error',
                title: 'Semua Tolak Ukur Kinerja Harus Diisi ! '
            })
        }else if(target_kinerja1 == '' && target_kinerja2 =='' && target_kinerja3 =='' && target_kinerja4 ==''){
            Toast.fire({
                icon: 'error',
                title: 'Semua Target Kinerja harus Diisi ! '
            })
        }else{
            Swal.fire({
                icon:'success',
                title: 'Sukses di Tambahkan !',
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
    getIndikator();
    function getIndikator()
    {
        var id_kegiatan = $('#id_kegiatan_info').val();
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id_kegiatan:id_kegiatan},
            url:'../indikatorList',
            success:function(result){
                if (result.length > 0) {
                    var html = '';
                    var i = 0 ;
                    for(i; i<result.length; i++){
                        html += '<tr>';
                        html += '<td>'+result[i].indikator+'</td>';
                        html += '<td>'+result[i].tolak_ukur_kinerja+'</td>';
                        html += '<td>'+result[i].target_kinerja+'</td>';
                        html += '<td>';
                        html += '<button type="button" id="'+result[i].id+'" class="btn btn-warning btn-sm editIndikator" title="Edit Indikator"><i class="fa fa-edit"></i></button>';
                        html += '</td>';
                        html += '</tr>';
                    }
                    $('#tbodyIndikator').html(html);
                    
                }else{
                    var html = '';
                    html += '<tr>';
                    html += '<td colspan="4" class="text-center"> Indikator pada Kegiatan ini belum tersedia ! </td>';
                    html += '</tr>';
                    $('#tbodyIndikator').html(html);
                    var button ='<button type="button" data-toggle="modal" data-target="#indikatorModal" class="btn btn-primary btn-sm float-right" ><i class="fa fa-plus"></i></button>';
                    $('#buttonIndikator').html(button);
                }
            }
        })
    }

    $(document).on('click','.editIndikator',function(){
        var id = $(this).attr('id');
        $('#editIndikatorModal').modal('show');
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:id},
            url:'../getIndikatorById',
            success:function(result){
                $('#id_indikator').val(id);
                $('#indikatorEdit').val(result.indikator);
                $('#tolak_ukur_kinerja_Edit').val(result.tolak_ukur_kinerja);
                $('#target_kinerja_Edit').val(result.target_kinerja);
            }
        })
    })

    $('#editBtnIndi').click(function(){
        var id_indikator = $('#id_indikator').val();
        var indikator = $('#indikatorEdit').val();
        var tolak_ukur_kinerja = $('#tolak_ukur_kinerja_Edit').val();
        var target_kinerja = $('#target_kinerja_Edit').val();
        $.ajax({
            method:'POST',
            // dataTyep:'JSON',
            data:{id_indikator:id_indikator,indikator:indikator,tolak_ukur_kinerja:tolak_ukur_kinerja,target_kinerja:target_kinerja},
            url:'../editIndikator',
            success:function(){
                Swal.fire({
                    icon:'success',
                    title: 'Sukses di Edit !',
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
    })
})