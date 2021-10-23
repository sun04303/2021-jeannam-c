let kind = "이름"
let keyword = ""

window.addEventListener('load', e => {
    search()
})

document.querySelectorAll('label').forEach(item => {
    item.addEventListener('click', e => {
        kind = e.target.innerHTML
    })
})

function enterKey() {
    if(window.event.keyCode == 13) {
        search()
    }
}

$('.searchBtn').on('click', e => {
    search()
})

function search() {
    keyword = document.querySelector('#searchbar').value
    
    $.ajax({
        url : `/search`,
        method:'post',
        data : {
            kind,
            keyword
        },
        dataType:'JSON',
        success : res => {
            console.log(res)
            $('.bestshop .list').html('')
            res.slice(0, 5).forEach(item => {
                let card = `<div class="card">
                                <img src="./resource${item.image}" class="card-img-top" alt="빵집 이미지" title="빵집">
                                <div class="card-body">
                                    <h5 class="card-title">${item.name}</h5>
                                    <p class="card-text">
                                        ${Number(item.grade).toFixed(1)} `
                                        + mkStar(Number(item.grade)) +
                                        ` (${item.reviewcnt})
                                    </p>
                                    <p class="card-text">${item.connect}</p>
                                    <p class="card-text">${item.borough} ${item.dong}</p>
                                </div>
                            </div>`
                $('.bestshop .list').append(card)
            })

            $('.shoplist .box').html('')
            res.slice(5).forEach(item => {
                let card = `<div>
                                <div style="padding: 0;">
                                    <img src="./resource${item.image}" alt="빵집" title="빵집">
                                </div>
                                <div>
                                    <h5>${item.name}</h5>
                                    <p>
                                        ${Number(item.grade).toFixed(1)} `
                                        + mkStar(Number(item.grade)) +
                                        ` (${item.reviewcnt})
                                    </p>
                                    <p>${item.connect}</p>
                                    <p>${item.borough} ${item.dong}</p>
                                </div>
                            </div>`
                $('.shoplist .box').append(card)
            })
        }
    })
}

function mkStar(num) {
    let star = '', re = num
    for(let i = 0; i<5; i++) {
        if(re >= 1) {
            star += `<i class="fas fa-star"></i>`
        } else if (re < 1 && re > 0) {
            star += `<i class="fas fa-star-half-alt"></i>`
        } else star += `<i class="far fa-star"></i>`

        re-=1
    }

    return star
}