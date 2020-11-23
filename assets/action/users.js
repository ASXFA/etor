$(function(){
    // $.ajax({
    //     method:'GET',
    //     dataType:'JSON',
    //     url:'userLists',
    //     success:function(result){
    //         var html ='';
    //         var i = 0;
    //         for(i; i<result.length; i++)
    //         {
    //             html += '<tr>';
    //             html += '<td>'+(i+1)+'</td>';
    //             html += '<td>'+result[i].nip+'</td>';
    //             html += '<td>'+result[i].nama+'</td>';
    //             html += '<td>'+result[i].role+'</td>';
    //             html += '<td>'+result[i].status+'</td>';
    //             html += '<td>'+result[i].created_by+'</td>';
    //             html += '<td>';
    //             html += '<a href="#" class="btn btn-warning btn-sm" onclick="editUsers('+result[i].id+')"><i class="fa fa-edit"></i> Edit </a>';
    //             html += '</td>';
    //             html += '</tr>';
    //         }
    //         $('#listUsers').html(html);
    //     }
    // })
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
                "targets":[0,2,3,4],
                "orderable":false,
            },
        ],
    });
})