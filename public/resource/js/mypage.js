let type = document.querySelector('.user_type').innerHTML.split('(')[1].split(')')[0]
console.log(type)

window.addEventListener('load', e => {
    switch (type) {
        case 'normal':
            $(`.ot`).each(function() {
                let rows = $(`.ot:contains('` + $(this).text() + "')");
                let idx1 = rows.siblings('.bn')
                let idx2 = rows.siblings('.rn')
                let idx3 = rows.siblings('.et')
                let idx4 = rows.siblings('.st')
    
                if (rows.length > 1) {
                    rows.eq(0).attr("rowspan", rows.length);
                    idx1.eq(0).attr("rowspan", rows.length);
                    idx2.eq(0).attr("rowspan", rows.length);
                    idx3.eq(0).attr("rowspan", rows.length);
                    idx4.eq(0).attr("rowspan", rows.length);
    
                    rows.not(":eq(0)").remove();
                    idx1.not(":eq(0)").remove();
                    idx2.not(":eq(0)").remove();
                    idx3.not(":eq(0)").remove();
                    idx4.not(":eq(0)").remove();
                }
            });
            break;
        
        case 'rider':
            $(`.delid`).each(function() {
                let rows = $(`.delid:contains('` + $(this).text() + "')");
                let idx1 = rows.siblings('.sn')
                let idx2 = rows.siblings('.sa')
                let idx3 = rows.siblings('.da')
                let idx4 = rows.siblings('.st')
                let idx5 = rows.siblings('.at')
    
                if (rows.length > 1) {
                    rows.eq(0).attr("rowspan", rows.length);
                    idx1.eq(0).attr("rowspan", rows.length);
                    idx2.eq(0).attr("rowspan", rows.length);
                    idx3.eq(0).attr("rowspan", rows.length);
                    idx4.eq(0).attr("rowspan", rows.length);
                    idx5.eq(0).attr("rowspan", rows.length);
    
                    rows.not(":eq(0)").remove();
                    idx1.not(":eq(0)").remove();
                    idx2.not(":eq(0)").remove();
                    idx3.not(":eq(0)").remove();
                    idx4.not(":eq(0)").remove();
                    idx5.not(":eq(0)").remove();
                }
            });
    
            document.querySelector('.rider_location').addEventListener('change', e=> {
                $.ajax({
                    url:`/uplocation`,
                    method : 'post',
                    data : {
                        location : e.target.value
                    },
                    success : () => {
                        location.reload()
                    }
                })
            })
    
            document.querySelectorAll('input[name="transport"]').forEach(item => {
                item.addEventListener('change', e => {
                    console.log(e.target.value)
                    $.ajax({
                        url:`/uptransport`,
                        method : 'post',
                        data : {
                            transport : e.target.value
                        },
                        success : () => {
                            location.reload()
                        }
                    })
                })
            })
    
            document.querySelectorAll('.st').forEach(item => {
                item.addEventListener('click', e => {
                    $.ajax({
                        url : `/uprstate`,
                        method : 'post',
                        data : {
                            msg : e.target.innerHTML,
                            id : e.target.dataset.id
                        },
                        success : () => {
                            location.reload()
                        }
                    })
                })
            })
            break;
    
        case 'owner' : 
            $(`.delid`).each(function() {
                let rows = $(`.delid:contains('` + $(this).text() + "')");
                let idx1 = rows.siblings('.or')
                let idx2 = rows.siblings('.oa')
                let idx3 = rows.siblings('.di')
                let idx4 = rows.siblings('.at')
                let idx5 = rows.siblings('.st')

                if (rows.length > 1) {
                    rows.eq(0).attr("rowspan", rows.length);
                    idx1.eq(0).attr("rowspan", rows.length);
                    idx2.eq(0).attr("rowspan", rows.length);
                    idx3.eq(0).attr("rowspan", rows.length);
                    idx4.eq(0).attr("rowspan", rows.length);
                    idx5.eq(0).attr("rowspan", rows.length);

                    rows.not(":eq(0)").remove();
                    idx1.not(":eq(0)").remove();
                    idx2.not(":eq(0)").remove();
                    idx3.not(":eq(0)").remove();
                    idx4.not(":eq(0)").remove();
                    idx5.not(":eq(0)").remove();
                }
            });

            document.querySelectorAll('.stb').forEach(item => {
                item.addEventListener('click', e => {
                    $.ajax({
                        url : `/upsstate`,
                        method : 'post',
                        data : {
                            msg : e.target.innerHTML,
                            id : e.target.dataset.id
                        },
                        success : () => {
                            location.reload()
                        }
                    })
                })
            })

            break
        
        default:
            break;
    }
})