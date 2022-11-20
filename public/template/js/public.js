$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function loadMore() {
    const page = $('#page').val();

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: { page },
        url: '/service/load-product',
        success: function(result) {
            if (result.html != '') {
                $('#loadProducts').append(result.html)
                $('#page').val(page + 1)
            } else {
                $('#btn-loadMore').css('display', 'none');
            }
        }
    })
}

const inputSize1 = document.getElementById('input-size1');
const inputSize2 = document.getElementById('input-size2');
const inputSize3 = document.getElementById('input-size3');
const inputSize4 = document.getElementById('input-size4');
const labelSize1 = document.getElementById('label-size1');
const labelSize2 = document.getElementById('label-size2');
const labelSize3 = document.getElementById('label-size3');
const labelSize4 = document.getElementById('label-size4');


inputSize1.addEventListener('change', function() {
    labelSize1.classList.add("label-border");
    labelSize2.classList.remove("label-border");
    labelSize3.classList.remove("label-border");
    labelSize4.classList.remove("label-border");
})

inputSize2.addEventListener('change', function() {
    labelSize2.classList.add("label-border");
    labelSize1.classList.remove("label-border");
    labelSize3.classList.remove("label-border");
    labelSize4.classList.remove("label-border");
})

inputSize3.addEventListener('change', function() {
    labelSize3.classList.add("label-border");
    labelSize1.classList.remove("label-border");
    labelSize2.classList.remove("label-border");
    labelSize4.classList.remove("label-border");
})

inputSize4.addEventListener('change', function() {
    labelSize4.classList.add("label-border");
    labelSize1.classList.remove("label-border");
    labelSize2.classList.remove("label-border");
    labelSize3.classList.remove("label-border");
})

