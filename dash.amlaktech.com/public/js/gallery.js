// room_count
// halls_count
// toilets_count
// pools_count

const GalleryText = 'اضغط على المربع لتحميل الصور أو اسحبها',
    extensions = ['.jpg', '.jpeg', '.png', '.gif', '.svg', '.PNG', '.JPEG', '.JPG'],
    mimes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];

let roomsImages = $('#rooms-images'),
    hallsImages = $('#halls-images'),
    toiletsImages = $('#toilets-images'),
    poolsImages = $('#pools-images');

$('.gallery-items-count').on('change', function (){
    let gallery = '';
    const galleryItemsCount = $(this).val();
    const fieldsName = $(this).data('name');
    const fieldArabicName = $(this).data('trans');

    for (let i = 0; i < galleryItemsCount; i++){
        gallery += '<h6 class="mb-2 mt-2"><small>صور '+fieldArabicName+' '+(i+1)+'</small></h6>';
        gallery += '<div class="images-wrapper">';
        gallery += '<div class="single-image-upload">';
        gallery += '<label class="" for="'+fieldsName+i+'-image-field">';
        gallery += '<i class="fa fa-plus"></i>';
        gallery += '</label>';
        gallery += '<input class="gallery-image-field" id="'+fieldsName+i+'-image-field" type="file" accept="image/*" data-name="'+fieldsName+'" data-no="'+(i+1)+'" name="'+fieldsName+'_field[]" multiple />';
        gallery += '</div>';
        gallery += '</div>';
    }

    $(this).parents('.step').find('.images-container').html(gallery);
});

$('body').on('change', '.gallery-image-field', function (){
    let output = '' ,
        loadingOutput = '';

    const fieldName = $(this).data('name');
    const $this = $(this);
    const $this_no = $this.data('no')

    let formData = new FormData();

    let TotalFiles = this.files.length;
    let images = [];

    // console.log(TotalFiles)
    for (let i = 0; i < TotalFiles; i++) {
        formData.append('file-'+i, this.files[i]);

        loadingOutput += '<div class="uploaded-image preloading">';
        loadingOutput += '<label class="uploaded-image-label">';
        loadingOutput += '<div class="button-loading"><span class="loader"></span></div>';
        loadingOutput += '</div>';
        loadingOutput += '</div>';

    }

    $this.parents('.single-image-upload').before(loadingOutput);

    formData.append('TotalFiles', TotalFiles);

    $('.next').addClass('button-loading');

    $.ajax({
        type:'POST',
        url: "/api/upload-multiple",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: (data) => {

            const index = Math.floor(Math.random() * 10);

            for (let i = 0; i < data.length; i++){
                output += '<div class="uploaded-image">';
                output += '<label class="uploaded-image-label">';
                output += '<a href="/temp/gallery/'+data[i]+'" class="single-image-link">';
                output += '<img src="/temp/gallery/'+data[i]+'" alt="" />';
                output += '</a>';
                output += '</label>';
                output += '<button class="remove-image"><i class="fa fa-times"></i></button>';
                output += '<input class="gallery-no-field" id="'+fieldName+'-no-field-'+index+'" type="hidden" value="'+$this_no+'" name="'+fieldName+'_no[]" />';
                output += '<input class="gallery-image-path" id="room-image-'+index+'" value="'+data[i]+'" type="hidden" name="'+fieldName+'[]" />';
                output += '</div>';
            }

            // $this.parents('.single-image-upload').before(output);
            $('#gallery-wrapper').css({'display': 'flex'}).append(output)

            $('#gallery-wrapper').sortable({
                placeholder: "ui-state-highlight"
            })

            $this.val('');

            $('.next').removeClass('button-loading');
            $('.uploaded-image.preloading').remove()

            $("a.single-image-link").fancybox();
        },
        error: function(data){
            alert(data.responseJSON.errors.files[0]);
            // console.log(data.responseJSON.errors);
        }
    });
});

$('body').on('click', '.remove-image', function (){
    $(this).parents('.uploaded-image').remove()
});

$('#room_count').on('change', function (e){
    e.preventDefault();

    // const count = $(this).val();
    // let i, output;
    //
    // for (i=1;i<=count;i++){
    //     output += '<div class="single-image-upload">';
    //     output += '<label class="upload-image-field" for="room-image-'+i+'">';
    //     output += '<i class="fa fa-plus"></i>';
    //     output += '<img src="" alt="" />';
    //     output += '</label>';
    //     output += '<input class="gallery-image-field" id="room-image-'+i+'" type="file" accept="image/*" name="rooms[]" required />';
    //     output += '</div>';
    // }
    //
    // let ImagesWrapper = $(this).parents('.image-with-select').find('.images-wrapper');
    //
    // ImagesWrapper.empty();
    // ImagesWrapper.append(output);

    roomsImages.empty();

    roomsImages.imageUploader({
        imagesInputName:'rooms',
        preloadedInputName:'roomsPreloaded',
        label:GalleryText,
        maxFiles: $(this).val(),
        extensions,
        mimes
    });
});

$('.single-image').on('change', function (){
    const [file] = $(this)[0].files

    if (file) {
        $('#blah').show().attr('src', URL.createObjectURL(file));
    }

    $('#main-image-wrapper .upload-image i, #main-image-wrapper .upload-image span').hide()
});

$('#halls_count').on('change', function (e){
    e.preventDefault();

    // const count = $(this).val();
    // let i, output;
    //
    // for (i=1;i<=count;i++){
    //     output += '<div class="single-image-upload">';
    //     output += '<label class="upload-image-field" for="hall-image-'+i+'">';
    //     output += '<i class="fa fa-plus"></i>';
    //     output += '<img src="" alt="" />';
    //     output += '</label>';
    //     output += '<input class="gallery-image-field" id="hall-image-'+i+'" type="file" accept="image/*" name="halls[]" required />';
    //     output += '</div>';
    // }
    //
    // let ImagesWrapper = $(this).parents('.image-with-select').find('.images-wrapper');
    //
    // ImagesWrapper.empty();
    // ImagesWrapper.append(output);

    hallsImages.empty();

    if ($(this).val() > 0){
        $('#halls-note').empty();

        hallsImages.imageUploader({
            imagesInputName:'halls',
            preloadedInputName:'hallsPreloaded',
            label:GalleryText,
            maxFiles: $(this).val(),
            extensions,
            mimes
        });
    }else{
        $('#halls-note').html('برجاء اختيار رقم أكبر من 0 لاضافة الصور')
    }
});

$('#toilets_count').on('change', function (e){
    e.preventDefault();

    // const count = $(this).val();
    // let i, output;
    //
    // for (i=1;i<=count;i++){
    //     output += '<div class="single-image-upload">';
    //     output += '<label class="upload-image-field" for="toilet-image-'+i+'">';
    //     output += '<i class="fa fa-plus"></i>';
    //     output += '<img src="" alt="" />';
    //     output += '</label>';
    //     output += '<input class="gallery-image-field" id="toilet-image-'+i+'" type="file" accept="image/*" name="toilets[]" required />';
    //     output += '</div>';
    // }
    //
    // let ImagesWrapper = $(this).parents('.image-with-select').find('.images-wrapper');
    //
    // ImagesWrapper.empty();
    // ImagesWrapper.append(output);

    toiletsImages.empty();

    toiletsImages.imageUploader({
        imagesInputName:'toilets',
        preloadedInputName:'toiletsPreloaded',
        label:GalleryText,
        maxFiles: $(this).val(),
        extensions,
        mimes
    });
});

$('#pools_count').on('change', function (e){
    e.preventDefault();

    // const count = $(this).val();
    // let i, output;
    //
    // for (i=1;i<=count;i++){
    //     output += '<div class="single-image-upload">';
    //     output += '<label class="upload-image-field" for="pool-image-'+i+'">';
    //     output += '<i class="fa fa-plus"></i>';
    //     output += '<img src="" alt="" />';
    //     output += '</label>';
    //     output += '<input class="gallery-image-field" id="pool-image-'+i+'" type="file" accept="image/*" name="pools[]" required />';
    //     output += '</div>';
    // }
    //
    // let ImagesWrapper = $(this).parents('.image-with-select').find('.images-wrapper');
    //
    // ImagesWrapper.empty();
    // ImagesWrapper.append(output);

    poolsImages.empty();

    poolsImages.imageUploader({
        imagesInputName:'pools',
        preloadedInputName:'poolsPreloaded',
        label:GalleryText,
        maxFiles: $(this).val(),
        extensions,
        mimes
    });
});

$('body').on('change', '.single-image-field', function (){
    const file = $(this).get(0).files[0];
    const image = $(this).parents('.main-image-upload').find('img');
    const icon = $(this).parents('.main-image-upload').find('i');

    if(file){
        var reader = new FileReader();

        reader.onload = function(){
            image.show().attr("src", reader.result);
            icon.hide();
        }

        reader.readAsDataURL(file);
    }
});

$('.up-down-numeric button').on('click', function () {
    const field = $(this).parents('.up-down-numeric').find('input');
    let fieldVal = field.val() === '' ? 0 : parseInt(field.val());

    if ($(this).hasClass('up')) {
        field.val(fieldVal+1)
    }else {
        if (fieldVal > 0)
            field.val(fieldVal-1)
    }
})

function validateStep(step){
    let errorCount = 0;
    let checkBoxes = [];

    step.find('input[type="text"],input[type="number"],input[type="file"],textarea,select').each(function (){
        if($(this).attr('required') && $(this).val() === '') {
            requiredMessage(this)
            errorCount++;
        }else {
            removeRequiredMessage(this)
        }
    });

    step.find('input[type="radio"],input[type="checkbox"]').each(function (){
        if($(this).attr('required')) {
            checkBoxes.push($(this).attr('name'))
        }
    })

    return !errorCount && validateCheckBoxes(checkBoxes.filter(onlyUnique));
}

function requiredMessage(ele) {
    return $(ele).addClass('has-error').parents('.form-group').find('.text-danger').addClass('active').html('هذا الحقل مطلوب ، برجاء إدخال القيمة المطلوبة.');
}
function removeRequiredMessage(ele) {
    $(ele).removeClass('has-error').addClass('valid').parents('.form-group').find('.text-danger').removeClass('active').html('')
}
function validateCheckBoxes(checkboxes) {
    let i;

    for (i=0;i<checkboxes.length;i++) {
        const field = $('input[name="'+checkboxes[i]+'"]');
        let checked = 0;

        field.each(function (){
            if($(this).is(':checked'))
                checked++
        });

        if (!checked) {
            requiredMessage(field)
            return false;
        }else {
            removeRequiredMessage(field)
        }
    }

    return true
}
function onlyUnique(value, index, array) {
    return array.indexOf(value) === index;
}
$(document).ready(function (){
    checkUnitContents()
})
$('.unit-contents-input').on('change', function (){
    checkUnitContents()
});

function checkUnitContents() {
    $('.unit-contents-input').each(function (index){
        const lastObj = parseInt(index) + 3;
        const currentObj = parseInt(index) + 4;
        const contentVal = $(this).data('content')

        if ($(this).is(':checked')) {
            $('#'+contentVal+'_step').addClass('required')

            checkRequired($(this).val())

            if (!$('body').find(".progress-bar--ribbon[data-step="+(contentVal)+"]").length)
                $('body').find(".progress-bar--ribbon[data-step-key="+(lastObj)+"]").after("<div class='progress-bar--ribbon' data-step-key='"+currentObj+"' data-step='"+contentVal+"'></div>");
        } else {
            $('#'+contentVal+'_step').removeClass('required')
            $('body').find(".progress-bar--ribbon[data-step="+(contentVal)+"]").remove()
            checkRequired(contentVal, false)
        }

        // console.log($(".progress-bar--ribbon[data-step-key="+(lastObj)+"]"))
    })
}

function checkRequired(step, status = true){
    $('#'+step+'_step').find('[data-required]').each(function (){
        $(this).attr('required', status)
    })
}

function getCheckBoxesClasses(step){
    step.find('input[type="checkbox"], input[type="radio"]').each(function (){
        const dataRequired = $(this).attr('data-required');

        if (typeof dataRequired !== 'undefined' && dataRequired !== false) {
            deRequireCb($(this).attr('data-class'))
        }

        // console.log($(this).attr('data-class'))
    })
}
function deRequireCb(elClass) {
    let el = document.getElementsByClassName(elClass);

    var atLeastOneChecked = false; //at least one cb is checked
    for (i = 0; i < el.length; i++) {
        if (el[i].checked === true) {
            atLeastOneChecked = true;
        }
    }

    if (atLeastOneChecked === true) {
        for (i = 0; i < el.length; i++) {
            el[i].required = false;
        }
    } else {
        for (i = 0; i < el.length; i++) {
            el[i].required = true;
        }
    }
}
