let kind = "이름"
let keyword = ""

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
        }
    })
}