$(function(){
    $('#report').attr('class','nav-item has-treeview menu-open');
    // $('#a-report').attr('class','nav-link active');
    $('#report-rekap').attr('class','nav-link active bg-success');
    $('#tableRekap').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"rekapLists",
            type:"post",
        },
        "columnDefs":[
            {
                "targets":[1],
                "orderable":false,
            },
        ],
    });
})