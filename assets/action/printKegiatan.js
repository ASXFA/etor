$(function(){
    $('#report').attr('class','nav-item has-treeview menu-open');
    // $('#a-report').attr('class','nav-link active');
    $('#report-kegiatan').attr('class','nav-link active bg-success');
    getIndikator();
    function getIndikator()
    {
        var id_kegiatan = $('#id_kegiatan').val()
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id_kegiatan:id_kegiatan},
            url:'indikatorList',
            success:function(result){
                var i = 0;
                var html = '';
                for(i; i<result.length; i++){
                    html += '<tr>';
                    html += '<td>'+result[i].indikator+'</td>';
                    html += '<td>'+result[i].tolak_ukur_kinerja+'</td>';
                    html += '<td>'+result[i].target_kinerja+'</td>';
                    html += '</tr>';
                }
                $('#indikatorList').html(html);
            }
        })
    }

    $('#tableKegiatan').DataTable({
        "processing": false,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"kegiatanLists",
            type:"post",
            data:{page:'Print'}
        },
        "columnDefs":[
            {
                "targets":[-1],
                "orderable":false,
            },
        ],
    });

    // $(document).on('click','.printAll',function(){
    //     var id = $(this).attr('id');
    //     loading();
    //     $.ajax({
    //         method:'POST',
    //         dataType:'JSON',
    //         data:{id_kegiatan:id},
    //         url:'printKegiatan',
    //         success:function(result){
                
    //         }
    //     })
    // })

    // function loading()
    // {
    //     let timerInterval
    //     Swal.fire({
    //     title: 'Harap Tunggu Sebentar,',
    //     html: 'File akan langsung ter Download',
    //     timer: 5000,
    //     timerProgressBar: true,
    //     willOpen: () => {
    //         Swal.showLoading()
    //     },
    //     willClose: () => {
    //         clearInterval(timerInterval)
    //     }
    //     }).then((result) => {
    //     /* Read more about handling dismissals below */
    //         if (result.dismiss === Swal.DismissReason.timer) {
                
    //         }
    //     })
    // }
})