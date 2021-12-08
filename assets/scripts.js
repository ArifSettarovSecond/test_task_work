$(document).on('click', '.tab_link', function (){
    var tabs = $(document).find('.tabs')
    tabs.find('.tab').removeClass('tab_active')
    var target = $(this).attr('data-id')
    tabs.find(target).addClass('tab_active')
})
var $form;
$(document).on('click', '.submit', function (){
    let data = new FormData();
    let form = $(this).closest('.form');
    $form =  $($(this).closest('.form'));
    $(form).find('.element').each(function (i, elem){
        data.append($(elem).attr('name'),$(elem).val())
    })
    $.ajax({
        url: $(form).attr('data-url'),
        processData: false,
        contentType: false,
        type: 'POST',
        data:data,
        success: AjaxDone
    });
})

function AjaxDone(response){
    response = JSON.parse(response)
    if(response.status && response.redirect){
        window.location.href  = response.redirect
    }
    if (response.status){
        $form.find('input').val('')

    }
    if (response.text){
        showNotify(response.text, response.status)
    }
}

function showNotify(text,status=false){
    if (status) {
        $('.notification').addClass('notification_success').html(text)
    }else{
        $('.notification').addClass('notification_error').html(text)
    }
    setTimeout(function (){
        $('.notification').removeClass('notification_success').removeClass('notification_error')
    }, 3000)

}