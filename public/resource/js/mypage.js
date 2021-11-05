let type = document.querySelector('.user_type').innerHTML.split('(')[1].split(')')[0]
console.log(type)

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

    default:
        break;
}