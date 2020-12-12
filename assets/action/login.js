$(function(){
    $('#btnLogin').click(function(){
        var nip = $('#nip').val();
        var pass = $('#pass').val();
        
        if (nip != '' && pass != '') {
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{nip:nip,pass:pass},
                url:'action_login',
                success:function(result){
                    if (result.condition == 0) {
                        Swal.fire({
                            icon:'error',
                            title: result.pesan,
                            timer: 2000,
                            timerProgressBar: true,
                        }).then((result) => {

                        })
                    }else if (result.condition == 1) {
                        Swal.fire({
                            icon:'error',
                            title: result.pesan,
                            timer: 2000,
                            timerProgressBar: true,
                        }).then((result) => {

                        })                        
                    }else if(result.condition == 2){
                        Swal.fire({
                            icon:'success',
                            title: result.pesan,
                            timer: 2000,
                            timerProgressBar: true,
                        }).then((results) => {
                            /* Read more about handling dismissals below */
                            if (results.dismiss === Swal.DismissReason.timer) {
                                window.location.href=result.url;
                            }else if(results.isConfirmed){
                                window.location.href=result.url;
                            }
                        })
                    }
                }
            })
        }else{
            Swal.fire({
                icon:'error',
                title: 'Semua Field Harus diisi !',
                timer: 2000,
                timerProgressBar: true,
            }).then((result) => {
                
            })
        }
    })
})