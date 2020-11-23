$(function(){
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
                "targets":[0,2,3],
                "orderable":false,
            },
        ],
    });

    $('#btnAddRole').click(function(){
        var nama = $('#nama').val();
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{nama:nama},
            url:'addRole',
            success:function(result){
                alert('tambah berhasil');
                location.reload();
            }
        })
    })
})