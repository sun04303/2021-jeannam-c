$('#order_ok').on('click', e => {
    let data = []
    document.querySelectorAll('input[type="number"]').forEach(item => {
        if(Number(item.value) > 0) {
            data.push({
                id:item.id,
                cnt:Number(item.value),
                price:Number(item.parentElement.querySelector('.order_bread').innerHTML)
            })
        }
    })

    if(data.length == 0) {
        alert('하나 이상 선택해주세요.')
    } else {
        $.ajax({
            url : `/orderok`,
            method : 'post',
            data : {
                a:data,
                id : document.querySelector('input[name="store_id"]').value
            },
            success : res => {
                console.log(res)
                alert(res);
                location.href = "/"
            }
        })
    }
})